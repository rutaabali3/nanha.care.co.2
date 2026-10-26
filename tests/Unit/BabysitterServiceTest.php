<?php

namespace Tests\Unit;

use App\Enums\BookingStatus;
use App\Enums\VerifiedStatus;
use App\Models\Babysitting\BabysitterReview;
use App\Models\Babysitting\Booking;
use App\Models\Profiles\BabysitterProfile;
use App\Models\User;
use App\Services\BabysitterService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class BabysitterServiceTest extends TestCase
{
    use RefreshDatabase;

    private BabysitterService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new BabysitterService;
    }

    public function test_get_all_computes_average_rating_without_eager_loading_reviews(): void
    {
        $user = User::create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => bcrypt('password'),
        ]);

        $profile = BabysitterProfile::create([
            'user_id' => $user->id,
            'hourly_rate' => 1500,
            'experience_years' => 3,
            'verified_status' => VerifiedStatus::Verified,
        ]);

        $parent = User::create([
            'name' => 'Parent User',
            'email' => 'parent@example.com',
            'password' => bcrypt('password'),
        ]);

        $booking1 = Booking::create([
            'parent_id' => $parent->id,
            'babysitter_id' => $user->id,
            'date' => now()->toDateString(),
            'start_time' => '10:00',
            'duration_hours' => 2,
            'total_fee' => 3000,
            'location' => 'Karachi',
            'status' => BookingStatus::Completed,
        ]);

        $booking2 = Booking::create([
            'parent_id' => $parent->id,
            'babysitter_id' => $user->id,
            'date' => now()->toDateString(),
            'start_time' => '14:00',
            'duration_hours' => 3,
            'total_fee' => 4500,
            'location' => 'Karachi',
            'status' => BookingStatus::Completed,
        ]);

        BabysitterReview::create([
            'booking_id' => $booking1->id,
            'babysitter_id' => $profile->id,
            'parent_id' => $parent->id,
            'rating' => 4,
            'comment' => 'Great service',
        ]);

        BabysitterReview::create([
            'booking_id' => $booking2->id,
            'babysitter_id' => $profile->id,
            'parent_id' => $parent->id,
            'rating' => 5,
            'comment' => 'Excellent!',
        ]);

        $results = $this->service->getAll([]);

        $this->assertCount(1, $results);
        $fetched = $results->first();

        // Check average rating is computed correctly (4 + 5) / 2 = 4.5
        $this->assertEquals(4.5, $fetched->avgRating);

        // Verify reviews relationship was not eager-loaded into memory
        $this->assertFalse($fetched->relationLoaded('reviews'));
    }

    public function test_get_featured_caches_results_and_computes_rating(): void
    {
        $user = User::create([
            'name' => 'Featured Sitter',
            'email' => 'featured@example.com',
            'password' => bcrypt('password'),
        ]);

        $profile = BabysitterProfile::create([
            'user_id' => $user->id,
            'hourly_rate' => 2000,
            'verified_status' => VerifiedStatus::Verified,
        ]);

        $featured = $this->service->getFeatured();
        $this->assertCount(1, $featured);

        // Verify result is cached in Cache facade
        $this->assertTrue(Cache::has('featured_babysitters'));

        // Saving profile should invalidate the cache
        $profile->hourly_rate = 2200;
        $profile->save();

        $this->assertFalse(Cache::has('featured_babysitters'));
    }
}
