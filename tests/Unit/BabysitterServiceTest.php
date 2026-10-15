<?php

namespace Tests\Unit;

use App\Enums\UserStatus;
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

    public function test_get_all_uses_with_avg_and_calculates_avg_rating_correctly(): void
    {
        $user = User::create([
            'name' => 'Babysitter One',
            'email' => 'babysitter1@example.com',
            'password' => bcrypt('password'),
            'status' => UserStatus::Active,
            'city' => 'Karachi',
        ]);

        BabysitterProfile::create([
            'user_id' => $user->id,
            'bio' => 'Experienced babysitter',
            'hourly_rate' => 1500,
            'verified_status' => VerifiedStatus::Verified,
        ]);

        $parent = User::create([
            'name' => 'Parent One',
            'email' => 'parent1@example.com',
            'password' => bcrypt('password'),
            'status' => UserStatus::Active,
        ]);

        $booking = Booking::create([
            'parent_id' => $parent->id,
            'babysitter_id' => $user->id,
            'date' => now()->toDateString(),
            'start_time' => '10:00',
            'duration_hours' => 3,
            'location' => 'Karachi',
            'total_fee' => 4500,
            'status' => 'completed',
        ]);

        BabysitterReview::create([
            'booking_id' => $booking->id,
            'parent_id' => $parent->id,
            'babysitter_id' => $user->id,
            'rating' => 4,
            'comment' => 'Great!',
        ]);

        BabysitterReview::create([
            'booking_id' => $booking->id,
            'parent_id' => $parent->id,
            'babysitter_id' => $user->id,
            'rating' => 5,
            'comment' => 'Awesome!',
        ]);

        $service = new BabysitterService();
        $results = $service->getAll([]);

        $this->assertCount(1, $results->items());
        $fetchedProfile = $results->items()[0];

        // Ensure reviews relation is not eager-loaded (saving memory)
        $this->assertFalse($fetchedProfile->relationLoaded('reviews'));

        // Ensure avgRating accessor computes 4.5 from reviews_avg_rating attribute
        $this->assertEquals(4.5, $fetchedProfile->avgRating);
    }

    public function test_get_featured_uses_with_avg_and_calculates_avg_rating_correctly(): void
    {
        $user = User::create([
            'name' => 'Babysitter Two',
            'email' => 'babysitter2@example.com',
            'password' => bcrypt('password'),
            'status' => UserStatus::Active,
            'city' => 'Lahore',
        ]);

        BabysitterProfile::create([
            'user_id' => $user->id,
            'bio' => 'Top babysitter',
            'hourly_rate' => 2000,
            'verified_status' => VerifiedStatus::Verified,
        ]);

        $parent = User::create([
            'name' => 'Parent Two',
            'email' => 'parent2@example.com',
            'password' => bcrypt('password'),
            'status' => UserStatus::Active,
        ]);

        $booking = Booking::create([
            'parent_id' => $parent->id,
            'babysitter_id' => $user->id,
            'date' => now()->toDateString(),
            'start_time' => '14:00',
            'duration_hours' => 2,
            'location' => 'Lahore',
            'total_fee' => 4000,
            'status' => 'completed',
        ]);

        BabysitterReview::create([
            'booking_id' => $booking->id,
            'parent_id' => $parent->id,
            'babysitter_id' => $user->id,
            'rating' => 5,
            'comment' => 'Excellent!',
        ]);

        $service = new BabysitterService();
        $featured = $service->getFeatured();

        $this->assertCount(1, $featured);
        $fetchedProfile = $featured->first();

        // Ensure reviews relation is not eager-loaded
        $this->assertFalse($fetchedProfile->relationLoaded('reviews'));

        // Ensure avgRating is calculated accurately
        $this->assertEquals(5.0, $fetchedProfile->avgRating);
    }
}
