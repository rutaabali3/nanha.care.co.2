<?php

namespace Tests\Unit;

use App\Models\Babysitting\BabysitterReview;
use App\Models\Babysitting\Booking;
use App\Models\User;
use App\Services\DashboardService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_babysitter_overview_calculates_aggregated_stats_correctly(): void
    {
        $babysitter = User::create([
            'name' => 'Jane Babysitter',
            'email' => 'jane@example.com',
            'password' => bcrypt('password'),
        ]);

        $parent = User::create([
            'name' => 'John Parent',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
        ]);

        $booking1 = Booking::create([
            'babysitter_id' => $babysitter->id,
            'parent_id' => $parent->id,
            'date' => now()->toDateString(),
            'start_time' => '10:00:00',
            'duration_hours' => 2,
            'location' => '123 Main St',
            'status' => 'completed',
            'total_fee' => 40.00,
        ]);

        $booking2 = Booking::create([
            'babysitter_id' => $babysitter->id,
            'parent_id' => $parent->id,
            'date' => now()->addDay()->toDateString(),
            'start_time' => '11:00:00',
            'duration_hours' => 3,
            'location' => '123 Main St',
            'status' => 'completed',
            'total_fee' => 75.00,
        ]);

        Booking::create([
            'babysitter_id' => $babysitter->id,
            'parent_id' => $parent->id,
            'date' => now()->addDays(2)->toDateString(),
            'start_time' => '12:00:00',
            'duration_hours' => 2,
            'location' => '123 Main St',
            'status' => 'pending',
            'total_fee' => 40.00,
        ]);

        BabysitterReview::create([
            'booking_id' => $booking1->id,
            'babysitter_id' => $babysitter->id,
            'parent_id' => $parent->id,
            'rating' => 5,
            'comment' => 'Great babysitter!',
        ]);

        BabysitterReview::create([
            'booking_id' => $booking2->id,
            'babysitter_id' => $babysitter->id,
            'parent_id' => $parent->id,
            'rating' => 3,
            'comment' => 'Average service.',
        ]);

        $service = new DashboardService();
        $overview = $service->getBabysitterOverview($babysitter->id);

        $this->assertEquals(3, $overview['total_bookings']);
        $this->assertEquals(2, $overview['completed_bookings']);
        $this->assertEquals(1, $overview['pending_bookings']);
        $this->assertEquals(115.00, $overview['total_earned']);
        $this->assertEquals(4, $overview['average_rating']);
        $this->assertCount(3, $overview['recent_bookings']);
        $this->assertCount(2, $overview['recent_reviews']);
    }
}
