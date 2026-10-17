<?php

namespace Tests\Feature;

use App\Enums\BookingStatus;
use App\Enums\UserStatus;
use App\Enums\VerifiedStatus;
use App\Models\Babysitting\BabysitterReview;
use App\Models\Babysitting\Booking;
use App\Models\Profiles\BabysitterProfile;
use App\Models\User;
use App\Services\BabysitterService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BabysitterListingTest extends TestCase
{
    use RefreshDatabase;

    public function test_babysitter_listing_uses_aggregated_avg_rating_without_loading_reviews_relation(): void
    {
        $user = User::create([
            'name' => 'Saba Noor',
            'email' => 'saba@example.com',
            'password' => bcrypt('password'),
            'city' => 'Lahore',
            'status' => UserStatus::Active,
        ]);

        $parent = User::create([
            'name' => 'Parent User',
            'email' => 'parent1@example.com',
            'password' => bcrypt('password'),
            'status' => UserStatus::Active,
        ]);

        $profile = BabysitterProfile::create([
            'user_id' => $user->id,
            'bio' => 'Experienced babysitter',
            'hourly_rate' => 1200,
            'experience_years' => 5,
            'verified_status' => VerifiedStatus::Verified,
        ]);

        $booking = Booking::create([
            'parent_id' => $parent->id,
            'babysitter_id' => $user->id,
            'date' => now()->toDateString(),
            'start_time' => '10:00:00',
            'duration_hours' => 2,
            'location' => 'Lahore',
            'status' => BookingStatus::Completed,
            'total_fee' => 2400,
        ]);

        BabysitterReview::create([
            'babysitter_id' => $profile->id,
            'parent_id' => $parent->id,
            'booking_id' => $booking->id,
            'rating' => 4,
            'comment' => 'Great babysitter!',
        ]);

        BabysitterReview::create([
            'babysitter_id' => $profile->id,
            'parent_id' => $parent->id,
            'booking_id' => $booking->id,
            'rating' => 5,
            'comment' => 'Excellent service!',
        ]);

        $service = new BabysitterService();
        $results = $service->getAll([]);

        $this->assertCount(1, $results->items());
        $fetchedProfile = $results->items()[0];

        // Ensure reviews relation was NOT eager loaded as models
        $this->assertFalse($fetchedProfile->relationLoaded('reviews'));

        // Ensure avgRating accessor computes correctly from reviews_avg_rating
        $this->assertEquals(4.5, $fetchedProfile->avgRating);
        $this->assertEquals('Lahore', $fetchedProfile->city);

        // Verify web route renders successfully
        $response = $this->get(route('babysitters.index'));
        $response->assertStatus(200);
        $response->assertSee('Saba Noor');
        $response->assertSee('Lahore');
    }

    public function test_featured_babysitters_use_aggregated_avg_rating(): void
    {
        $user = User::create([
            'name' => 'Ayesha Khan',
            'email' => 'ayesha@example.com',
            'password' => bcrypt('password'),
            'city' => 'Karachi',
            'status' => UserStatus::Active,
        ]);

        $parent = User::create([
            'name' => 'Parent Two',
            'email' => 'parent2@example.com',
            'password' => bcrypt('password'),
            'status' => UserStatus::Active,
        ]);

        $profile = BabysitterProfile::create([
            'user_id' => $user->id,
            'bio' => 'Top rated babysitter',
            'hourly_rate' => 1500,
            'experience_years' => 7,
            'verified_status' => VerifiedStatus::Verified,
        ]);

        $booking = Booking::create([
            'parent_id' => $parent->id,
            'babysitter_id' => $user->id,
            'date' => now()->toDateString(),
            'start_time' => '14:00:00',
            'duration_hours' => 2,
            'location' => 'Karachi',
            'status' => BookingStatus::Completed,
            'total_fee' => 3000,
        ]);

        BabysitterReview::create([
            'babysitter_id' => $profile->id,
            'parent_id' => $parent->id,
            'booking_id' => $booking->id,
            'rating' => 5,
            'comment' => 'Superb!',
        ]);

        $service = new BabysitterService();
        $featured = $service->getFeatured();

        $this->assertCount(1, $featured);
        $fetchedProfile = $featured->first();

        $this->assertFalse($fetchedProfile->relationLoaded('reviews'));
        $this->assertEquals(5.0, $fetchedProfile->avgRating);
    }
}
