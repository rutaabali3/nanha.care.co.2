<?php

namespace Tests\Feature;

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

    public function test_get_all_calculates_avg_rating_without_loading_reviews_relation(): void
    {
        $user = User::create([
            'name' => 'Babysitter One',
            'email' => 'babysitter1@example.com',
            'password' => bcrypt('password'),
            'city' => 'Lahore',
            'status' => \App\Enums\UserStatus::Active,
        ]);

        $parent = User::create([
            'name' => 'Parent One',
            'email' => 'parent1@example.com',
            'password' => bcrypt('password'),
            'status' => \App\Enums\UserStatus::Active,
        ]);

        $profile = BabysitterProfile::create([
            'user_id' => $user->id,
            'hourly_rate' => 1500,
            'verified_status' => \App\Enums\VerifiedStatus::Verified,
        ]);

        $booking = Booking::create([
            'parent_id' => $parent->id,
            'babysitter_id' => $user->id,
            'date' => now()->toDateString(),
            'start_time' => '10:00',
            'duration_hours' => 2,
            'location' => 'Test Location',
            'total_fee' => 3000,
            'status' => \App\Enums\BookingStatus::Completed,
        ]);

        BabysitterReview::create([
            'booking_id' => $booking->id,
            'babysitter_id' => $profile->id,
            'parent_id' => $parent->id,
            'rating' => 4,
            'comment' => 'Great babysitter!',
        ]);

        BabysitterReview::create([
            'booking_id' => $booking->id,
            'babysitter_id' => $profile->id,
            'parent_id' => $parent->id,
            'rating' => 5,
            'comment' => 'Awesome service!',
        ]);

        $service = new BabysitterService();
        $result = $service->getAll([]);

        $this->assertCount(1, $result);
        $babysitter = $result->first();

        // Verify avgRating attribute computes 4.5 using withAvg
        $this->assertEquals(4.5, $babysitter->avgRating);

        // Verify reviews relation was NOT eager loaded into memory
        $this->assertFalse($babysitter->relationLoaded('reviews'));
    }

    public function test_get_featured_calculates_avg_rating_using_with_avg(): void
    {
        $user = User::create([
            'name' => 'Babysitter Two',
            'email' => 'babysitter2@example.com',
            'password' => bcrypt('password'),
            'city' => 'Karachi',
            'status' => \App\Enums\UserStatus::Active,
        ]);

        $parent = User::create([
            'name' => 'Parent Two',
            'email' => 'parent2@example.com',
            'password' => bcrypt('password'),
            'status' => \App\Enums\UserStatus::Active,
        ]);

        $profile = BabysitterProfile::create([
            'user_id' => $user->id,
            'hourly_rate' => 2000,
            'verified_status' => \App\Enums\VerifiedStatus::Verified,
        ]);

        $booking = Booking::create([
            'parent_id' => $parent->id,
            'babysitter_id' => $user->id,
            'date' => now()->toDateString(),
            'start_time' => '10:00',
            'duration_hours' => 2,
            'location' => 'Test Location',
            'total_fee' => 4000,
            'status' => \App\Enums\BookingStatus::Completed,
        ]);

        BabysitterReview::create([
            'booking_id' => $booking->id,
            'babysitter_id' => $profile->id,
            'parent_id' => $parent->id,
            'rating' => 3,
            'comment' => 'Good',
        ]);

        BabysitterReview::create([
            'booking_id' => $booking->id,
            'babysitter_id' => $profile->id,
            'parent_id' => $parent->id,
            'rating' => 5,
            'comment' => 'Excellent',
        ]);

        $service = new BabysitterService();
        $featured = $service->getFeatured();

        $this->assertCount(1, $featured);
        $babysitter = $featured->first();

        $this->assertEquals(4.0, $babysitter->avgRating);
        $this->assertFalse($babysitter->relationLoaded('reviews'));
    }
}
