<?php

namespace Tests\Unit;

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

    public function test_get_all_computes_reviews_avg_rating_without_loading_reviews_relation(): void
    {
        $user = User::create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => bcrypt('password'),
            'city' => 'Karachi',
            'status' => \App\Enums\UserStatus::Active,
        ]);

        $parent1 = User::create([
            'name' => 'Parent 1',
            'email' => 'parent1@example.com',
            'password' => bcrypt('password'),
            'status' => \App\Enums\UserStatus::Active,
        ]);

        $parent2 = User::create([
            'name' => 'Parent 2',
            'email' => 'parent2@example.com',
            'password' => bcrypt('password'),
            'status' => \App\Enums\UserStatus::Active,
        ]);

        $profile = BabysitterProfile::create([
            'user_id' => $user->id,
            'bio' => 'Experienced babysitter',
            'hourly_rate' => 1500,
            'experience_years' => 5,
            'verified_status' => \App\Enums\VerifiedStatus::Verified,
        ]);

        $booking1 = Booking::create([
            'parent_id' => $parent1->id,
            'babysitter_id' => $user->id,
            'date' => now()->toDateString(),
            'start_time' => '10:00:00',
            'duration_hours' => 2,
            'location' => 'Karachi',
            'total_fee' => 3000,
            'status' => \App\Enums\BookingStatus::Completed,
        ]);

        $booking2 = Booking::create([
            'parent_id' => $parent2->id,
            'babysitter_id' => $user->id,
            'date' => now()->toDateString(),
            'start_time' => '10:00:00',
            'duration_hours' => 2,
            'location' => 'Karachi',
            'total_fee' => 3000,
            'status' => \App\Enums\BookingStatus::Completed,
        ]);

        BabysitterReview::create([
            'booking_id' => $booking1->id,
            'babysitter_id' => $user->id,
            'parent_id' => $parent1->id,
            'rating' => 4,
            'comment' => 'Great service',
        ]);

        BabysitterReview::create([
            'booking_id' => $booking2->id,
            'babysitter_id' => $user->id,
            'parent_id' => $parent2->id,
            'rating' => 5,
            'comment' => 'Wonderful with kids',
        ]);

        $service = new BabysitterService();
        $result = $service->getAll([]);

        $this->assertCount(1, $result->items());
        $fetchedProfile = $result->items()[0];

        $this->assertEquals(4.5, (float) $fetchedProfile->reviews_avg_rating);
        $this->assertFalse($fetchedProfile->relationLoaded('reviews'));
    }
}
