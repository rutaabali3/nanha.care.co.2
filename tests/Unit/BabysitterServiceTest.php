<?php

namespace Tests\Unit;

use App\Enums\VerifiedStatus;
use App\Models\Babysitting\BabysitterReview;
use App\Models\Babysitting\Booking;
use App\Models\Profiles\BabysitterProfile;
use App\Models\User;
use App\Services\BabysitterService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BabysitterServiceTest extends TestCase
{
    use RefreshDatabase;

    private BabysitterService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new BabysitterService();
    }

    public function test_get_featured_uses_database_avg_rating_aggregation(): void
    {
        $user = User::create([
            'name' => 'Jane Babysitter',
            'email' => 'jane@example.com',
            'password' => bcrypt('password'),
            'city' => 'Lahore',
        ]);

        $profile = BabysitterProfile::create([
            'user_id' => $user->id,
            'verified_status' => VerifiedStatus::Verified,
            'hourly_rate' => 1000,
        ]);

        $booking = Booking::create([
            'parent_id' => $user->id,
            'babysitter_id' => $user->id,
            'date' => now()->toDateString(),
            'start_time' => '10:00:00',
            'duration_hours' => 2,
            'location' => 'Lahore',
            'total_fee' => 2000,
            'status' => 'completed',
        ]);

        BabysitterReview::create([
            'booking_id' => $booking->id,
            'babysitter_id' => $user->id,
            'parent_id' => $user->id,
            'rating' => 4,
            'comment' => 'Great service',
        ]);

        BabysitterReview::create([
            'booking_id' => $booking->id,
            'babysitter_id' => $user->id,
            'parent_id' => $user->id,
            'rating' => 5,
            'comment' => 'Awesome',
        ]);

        $featured = $this->service->getFeatured();

        $this->assertCount(1, $featured);
        $babysitter = $featured->first();
        $this->assertEquals(4.5, $babysitter->avgRating);
        $this->assertFalse($babysitter->relationLoaded('reviews'), 'Reviews relation should not be loaded in list view.');
    }

    public function test_get_all_uses_database_avg_rating_aggregation_without_loading_full_reviews_collection(): void
    {
        $user = User::create([
            'name' => 'Sara Babysitter',
            'email' => 'sara@example.com',
            'password' => bcrypt('password'),
            'city' => 'Karachi',
        ]);

        $profile = BabysitterProfile::create([
            'user_id' => $user->id,
            'verified_status' => VerifiedStatus::Verified,
            'hourly_rate' => 1500,
        ]);

        $booking = Booking::create([
            'parent_id' => $user->id,
            'babysitter_id' => $user->id,
            'date' => now()->toDateString(),
            'start_time' => '10:00:00',
            'duration_hours' => 2,
            'location' => 'Karachi',
            'total_fee' => 3000,
            'status' => 'completed',
        ]);

        BabysitterReview::create([
            'booking_id' => $booking->id,
            'babysitter_id' => $user->id,
            'parent_id' => $user->id,
            'rating' => 3,
            'comment' => 'Good',
        ]);

        BabysitterReview::create([
            'booking_id' => $booking->id,
            'babysitter_id' => $user->id,
            'parent_id' => $user->id,
            'rating' => 5,
            'comment' => 'Excellent',
        ]);

        $paginator = $this->service->getAll([]);

        $this->assertCount(1, $paginator->items());
        $babysitter = $paginator->items()[0];

        $this->assertEquals(4.0, $babysitter->avgRating);
        $this->assertFalse($babysitter->relationLoaded('reviews'), 'Reviews relation should not be hydrated in list queries.');
    }
}
