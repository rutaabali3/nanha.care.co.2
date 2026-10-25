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

    public function test_get_all_uses_with_avg_for_reviews_rating(): void
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

        $profile = BabysitterProfile::create([
            'user_id' => $babysitter->id,
            'bio' => 'Experienced babysitter',
            'hourly_rate' => 1500,
            'verified_status' => VerifiedStatus::Verified,
        ]);

        $booking = Booking::create([
            'parent_id' => $parent->id,
            'babysitter_id' => $babysitter->id,
            'date' => now()->subDays(2),
            'start_time' => '10:00',
            'duration_hours' => 2,
            'location' => 'Karachi',
            'total_fee' => 3000,
            'status' => \App\Enums\BookingStatus::Completed,
        ]);

        BabysitterReview::create([
            'booking_id' => $booking->id,
            'parent_id' => $parent->id,
            'babysitter_id' => $babysitter->id,
            'rating' => 5,
            'comment' => 'Great service!',
        ]);

        BabysitterReview::create([
            'booking_id' => $booking->id,
            'parent_id' => $parent->id,
            'babysitter_id' => $babysitter->id,
            'rating' => 3,
            'comment' => 'Good job.',
        ]);

        $service = new BabysitterService();
        $result = $service->getAll([]);

        $this->assertCount(1, $result->items());
        $retrievedProfile = $result->items()[0];

        // Verify that full 'reviews' collection is NOT eager loaded into memory
        $this->assertFalse($retrievedProfile->relationLoaded('reviews'));

        // Verify that reviews_avg_rating is computed via SQL withAvg
        $this->assertEquals(4.0, (float) $retrievedProfile->reviews_avg_rating);
        $this->assertEquals(4.0, $retrievedProfile->avgRating);
    }
}
