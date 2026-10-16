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

    public function test_get_all_computes_average_rating_without_eager_loading_reviews(): void
    {
        $user = User::create([
            'name' => 'Babysitter One',
            'email' => 'sitter@example.com',
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

        $parent = User::create([
            'name' => 'Parent One',
            'email' => 'parent@example.com',
            'password' => bcrypt('password'),
            'status' => \App\Enums\UserStatus::Active,
        ]);

        $booking1 = Booking::create([
            'parent_id' => $parent->id,
            'babysitter_id' => $user->id,
            'date' => now()->toDateString(),
            'start_time' => '09:00:00',
            'duration_hours' => 3,
            'location' => 'Lahore',
            'total_fee' => 4500,
            'status' => \App\Enums\BookingStatus::Completed,
        ]);

        $booking2 = Booking::create([
            'parent_id' => $parent->id,
            'babysitter_id' => $user->id,
            'date' => now()->addDay()->toDateString(),
            'start_time' => '09:00:00',
            'duration_hours' => 3,
            'location' => 'Lahore',
            'total_fee' => 4500,
            'status' => \App\Enums\BookingStatus::Completed,
        ]);

        BabysitterReview::create([
            'booking_id' => $booking1->id,
            'babysitter_id' => $user->id,
            'parent_id' => $parent->id,
            'rating' => 4,
            'comment' => 'Great sitter!',
        ]);

        BabysitterReview::create([
            'booking_id' => $booking2->id,
            'babysitter_id' => $user->id,
            'parent_id' => $parent->id,
            'rating' => 5,
            'comment' => 'Awesome service!',
        ]);

        $service = new BabysitterService();
        $result = $service->getAll([]);

        $this->assertCount(1, $result->items());
        $sitterItem = $result->items()[0];

        $this->assertEquals(4.5, (float) $sitterItem->reviews_avg_rating);
        $this->assertFalse($sitterItem->relationLoaded('reviews'));
        $this->assertTrue($sitterItem->relationLoaded('user'));
    }
}
