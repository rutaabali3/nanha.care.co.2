<?php

namespace Tests\Feature;

use App\Models\Babysitting\Booking;
use App\Models\Babysitting\BabysitterReview;
use App\Models\Profiles\BabysitterProfile;
use App\Models\User;
use App\Services\BabysitterService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BabysitterServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_all_computes_avg_rating_without_loading_reviews_relation(): void
    {
        $user = User::create([
            'name' => 'John Babysitter',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
            'city' => 'Lahore',
            'status' => \App\Enums\UserStatus::Active,
        ]);

        $profile = BabysitterProfile::create([
            'user_id' => $user->id,
            'hourly_rate' => 1500,
            'experience_years' => 5,
            'verified_status' => \App\Enums\VerifiedStatus::Verified,
        ]);

        $booking = Booking::create([
            'parent_id' => $user->id,
            'babysitter_id' => $user->id,
            'date' => now()->toDateString(),
            'start_time' => '10:00',
            'duration_hours' => 2,
            'location' => 'Test Location',
            'total_fee' => 3000,
            'status' => 'completed',
        ]);

        BabysitterReview::create([
            'booking_id' => $booking->id,
            'babysitter_id' => $user->id,
            'parent_id' => $user->id,
            'rating' => 5,
            'comment' => 'Great babysitter!',
        ]);

        BabysitterReview::create([
            'booking_id' => $booking->id,
            'babysitter_id' => $user->id,
            'parent_id' => $user->id,
            'rating' => 3,
            'comment' => 'Good service.',
        ]);

        $service = new BabysitterService();
        $result = $service->getAll([]);

        $this->assertCount(1, $result);
        $fetched = $result->first();

        // Ensure reviews relation is not loaded into memory
        $this->assertFalse($fetched->relationLoaded('reviews'));

        // Ensure avgRating accessor computes rating efficiently via withAvg
        $this->assertEquals(4.0, $fetched->avgRating);
    }

    public function test_get_all_supports_sorting_by_rating(): void
    {
        $user1 = User::create([
            'name' => 'Low Rating Sitter',
            'email' => 'sitter1@example.com',
            'password' => bcrypt('password'),
            'status' => \App\Enums\UserStatus::Active,
        ]);

        $profile1 = BabysitterProfile::create([
            'user_id' => $user1->id,
            'hourly_rate' => 1000,
            'verified_status' => \App\Enums\VerifiedStatus::Verified,
        ]);

        $booking1 = Booking::create([
            'parent_id' => $user1->id,
            'babysitter_id' => $user1->id,
            'date' => now()->toDateString(),
            'start_time' => '10:00',
            'duration_hours' => 2,
            'location' => 'Test Location',
            'total_fee' => 2000,
            'status' => 'completed',
        ]);

        BabysitterReview::create([
            'booking_id' => $booking1->id,
            'babysitter_id' => $user1->id,
            'parent_id' => $user1->id,
            'rating' => 2,
            'comment' => 'Ok',
        ]);

        $user2 = User::create([
            'name' => 'High Rating Sitter',
            'email' => 'sitter2@example.com',
            'password' => bcrypt('password'),
            'status' => \App\Enums\UserStatus::Active,
        ]);

        $profile2 = BabysitterProfile::create([
            'user_id' => $user2->id,
            'hourly_rate' => 2000,
            'verified_status' => \App\Enums\VerifiedStatus::Verified,
        ]);

        $booking2 = Booking::create([
            'parent_id' => $user2->id,
            'babysitter_id' => $user2->id,
            'date' => now()->toDateString(),
            'start_time' => '10:00',
            'duration_hours' => 2,
            'location' => 'Test Location',
            'total_fee' => 4000,
            'status' => 'completed',
        ]);

        BabysitterReview::create([
            'booking_id' => $booking2->id,
            'babysitter_id' => $user2->id,
            'parent_id' => $user2->id,
            'rating' => 5,
            'comment' => 'Awesome',
        ]);

        $service = new BabysitterService();
        $sortedByRating = $service->getAll(['sort' => 'rating']);

        $this->assertEquals($profile2->id, $sortedByRating->first()->id);
        $this->assertEquals(5.0, $sortedByRating->first()->avgRating);
    }
}
