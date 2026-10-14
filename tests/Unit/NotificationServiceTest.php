<?php

namespace Tests\Unit;

use App\Models\System\Notification;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class NotificationServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_broadcast_sends_notifications_and_clears_cache_for_role_users(): void
    {
        $role = Role::findOrCreate('parent');

        $user1 = User::create([
            'name' => 'Parent One',
            'email' => 'parent1@example.com',
            'password' => bcrypt('password'),
        ]);
        $user1->assignRole($role);

        $user2 = User::create([
            'name' => 'Parent Two',
            'email' => 'parent2@example.com',
            'password' => bcrypt('password'),
        ]);
        $user2->assignRole($role);

        Cache::put("notifications.unread.{$user1->id}", 3);
        Cache::put("notifications.recent.{$user1->id}", ['test']);
        Cache::put("notifications.unread.{$user2->id}", 5);
        Cache::put("notifications.recent.{$user2->id}", ['test']);

        $service = new NotificationService();
        $service->broadcast(['parent'], 'Maintenance scheduled at 10 PM');

        $this->assertDatabaseHas('notifications', [
            'user_id' => $user1->id,
            'type' => 'broadcast',
            'message' => 'Maintenance scheduled at 10 PM',
        ]);
        $this->assertDatabaseHas('notifications', [
            'user_id' => $user2->id,
            'type' => 'broadcast',
            'message' => 'Maintenance scheduled at 10 PM',
        ]);

        $this->assertNull(Cache::get("notifications.unread.{$user1->id}"));
        $this->assertNull(Cache::get("notifications.recent.{$user1->id}"));
        $this->assertNull(Cache::get("notifications.unread.{$user2->id}"));
        $this->assertNull(Cache::get("notifications.recent.{$user2->id}"));
    }

    public function test_broadcast_handles_empty_user_list_gracefully(): void
    {
        Role::findOrCreate('empty_role');

        $service = new NotificationService();
        $service->broadcast(['empty_role'], 'Hello empty world');

        $this->assertEquals(0, Notification::count());
    }
}
