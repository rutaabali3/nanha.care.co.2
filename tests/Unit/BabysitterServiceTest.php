<?php

namespace Tests\Unit;

use App\Models\Babysitting\BabysitterReview;
use App\Models\Babysitting\Booking;
use App\Models\Profiles\BabysitterProfile;
use App\Models\User;
use App\Services\BabysitterService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class BabysitterServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_all_calculates_average_rating_without_loading_full_reviews_relation(): void
    {
        $user = User::create([
            'id' => (string) Str::uuid(),
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => bcrypt('password'),
            'city' => 'Lahore',
        ]);

        $profile = BabysitterProfile::create([
            'user_id' => $user->id,
            'hourly_rate' => 1500,
            'experience_years' => 3,
        ]);

        $parent1 = User::create([
            'id' => (string) Str::uuid(),
            'name' => 'Parent 1',
            'email' => 'parent1@example.com',
            'password' => bcrypt('password'),
        ]);

        $parent2 = User::create([
            'id' => (string) Str::uuid(),
            'name' => 'Parent 2',
            'email' => 'parent2@example.com',
            'password' => bcrypt('password'),
        ]);

        $booking1 = Booking::create([
            'parent_id' => $parent1->id,
            'babysitter_id' => $user->id,
            'date' => now()->toDateString(),
            'start_time' => '09:00',
            'end_time' => '11:00',
            'duration_hours' => 2,
            'location' => 'Lahore',
            'total_fee' => 3000,
            'status' => 'completed',
        ]);

        $booking2 = Booking::create([
            'parent_id' => $parent2->id,
            'babysitter_id' => $user->id,
            'date' => now()->toDateString(),
            'start_time' => '12:00',
            'end_time' => '14:00',
            'duration_hours' => 2,
            'location' => 'Lahore',
            'total_fee' => 3000,
            'status' => 'completed',
        ]);

        BabysitterReview::create([
            'booking_id' => $booking1->id,
            'babysitter_id' => $user->id,
            'parent_id' => $parent1->id,
            'rating' => 4,
            'comment' => 'Great experience',
        ]);

        BabysitterReview::create([
            'booking_id' => $booking2->id,
            'babysitter_id' => $user->id,
            'parent_id' => $parent2->id,
            'rating' => 5,
            'comment' => 'Excellent service',
        ]);

        $service = new BabysitterService();
        $results = $service->getAll([]);

        $this->assertCount(1, $results->items());
        $fetchedProfile = $results->items()[0];

        $this->assertEquals(4.5, (float) $fetchedProfile->reviews_avg_rating);
        $this->assertFalse($fetchedProfile->relationLoaded('reviews'));
    }
}
