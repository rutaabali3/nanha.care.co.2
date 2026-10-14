<?php

namespace App\Services;

use App\Contracts\INotificationService;
use App\Models\System\Notification;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class NotificationService implements INotificationService
{
    public function send(string $userId, string $type, string $message, ?string $link = null): void
    {
        Notification::create([
            'user_id' => $userId,
            'type' => $type,
            'message' => $message,
            'link' => $link,
        ]);
    }

    public function markRead(int $id, string $userId): void
    {
        $notification = Notification::where('id', $id)->where('user_id', $userId)->firstOrFail();
        $notification->update(['is_read' => true]);
    }

    public function markAllRead(string $userId): void
    {
        Notification::where('user_id', $userId)->where('is_read', false)->update(['is_read' => true]);
    }

    public function delete(int $id, string $userId): void
    {
        $notification = Notification::where('id', $id)->where('user_id', $userId)->firstOrFail();
        $notification->delete();
    }

    public function broadcast(array $roles, string $message, ?string $link = null): void
    {
        $userIds = User::role($roles)->pluck('id');

        // Early return if no target users exist for the given roles
        if ($userIds->isEmpty()) {
            return;
        }

        // Performance Optimization: Calculate timestamp once instead of invoking now() inside the loop per user
        $now = now();
        $notifications = $userIds->map(fn($userId) => [
            'user_id' => $userId,
            'type' => 'broadcast',
            'message' => $message,
            'link' => $link,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        Notification::insert($notifications->toArray());

        // Performance Optimization: Use batch cache deletion (deleteMultiple) in a single operation
        // instead of executing 2 * N individual Cache::forget() calls in a loop.
        $cacheKeys = $userIds->flatMap(fn($userId) => [
            "notifications.unread.{$userId}",
            "notifications.recent.{$userId}",
        ])->all();

        Cache::deleteMultiple($cacheKeys);
    }
}
