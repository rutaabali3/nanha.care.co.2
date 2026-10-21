<?php

namespace Tests\Unit;

use App\Enums\BookingStatus;
use App\Models\Babysitting\Booking;
use App\Models\User;
use App\Services\BookingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_by_parent_eager_loads_babysitter_relation(): void
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
            'date' => now()->addDay(),
            'start_time' => '10:00',
            'duration_hours' => 2,
            'location' => 'Test Location',
            'total_fee' => 50.00,
            'status' => BookingStatus::Pending,
        ]);

        $notificationMock = \Mockery::mock(\App\Contracts\INotificationService::class);
        $emailMock = \Mockery::mock(\App\Contracts\IEmailService::class);

        $service = new BookingService($notificationMock, $emailMock);

        $result = $service->getByParent((string) $parent->id, null);

        $this->assertCount(1, $result->items());
        $fetchedBooking = $result->items()[0];

        // Ensure babysitter relation is relationLoaded to prevent N+1 queries
        $this->assertTrue($fetchedBooking->relationLoaded('babysitter'));
        $this->assertEquals($babysitter->id, $fetchedBooking->babysitter->id);
    }
}
