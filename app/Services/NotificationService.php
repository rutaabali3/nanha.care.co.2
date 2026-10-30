<?php

namespace App\Services;

use App\Contracts\INotificationService;
use App\Models\System\Notification;
use App\Models\User;
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
        $notifications = $userIds->map(fn ($userId) => [
            'user_id' => $userId,
            'type' => 'broadcast',
            'message' => $message,
            'link' => $link,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Notification::insert($notifications->toArray());

        foreach ($userIds as $userId) {
            Cache::forget("notifications.unread.{$userId}");
            Cache::forget("notifications.recent.{$userId}");
        }
    }
}
