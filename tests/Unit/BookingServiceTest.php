<?php

namespace Tests\Unit;

use App\Enums\BookingStatus;
use App\Models\Babysitting\Booking;
use App\Models\User;
use App\Services\BookingService;
use App\Contracts\INotificationService;
use App\Contracts\IEmailService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_by_parent_eager_loads_babysitter(): void
    {
        $parent = User::create([
            'name' => 'Parent User',
            'email' => 'parent@example.com',
            'password' => bcrypt('password'),
        ]);

        $babysitter = User::create([
            'name' => 'Babysitter User',
            'email' => 'babysitter@example.com',
            'password' => bcrypt('password'),
        ]);

        $booking = Booking::create([
            'parent_id' => $parent->id,
            'babysitter_id' => $babysitter->id,
            'date' => now()->addDays(2),
            'start_time' => '10:00',
            'duration_hours' => 3,
            'location' => 'Lahore',
            'total_fee' => 4500,
            'status' => BookingStatus::Pending,
        ]);

        $notificationService = $this->createMock(INotificationService::class);
        $emailService = $this->createMock(IEmailService::class);

        $service = new BookingService($notificationService, $emailService);
        $result = $service->getByParent((string) $parent->id, null);

        $this->assertCount(1, $result->items());
        $retrievedBooking = $result->items()[0];

        // Ensure babysitter relation is eager-loaded to prevent N+1 query issue
        $this->assertTrue($retrievedBooking->relationLoaded('babysitter'));
        $this->assertEquals('Babysitter User', $retrievedBooking->babysitter->name);
    }
}
