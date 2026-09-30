<?php

namespace Tests\Unit;

use App\Models\Babysitting\BabysitterReview;
use App\Models\Babysitting\Booking;
use App\Models\Profiles\BabysitterProfile;
use App\Models\User;
use App\Services\BabysitterService;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BabysitterServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);
    }

    public function test_get_all_computes_avg_rating_via_subquery_without_hydrating_reviews(): void
    {
        $babysitterUser = User::create([
            'name' => 'Babysitter Mary',
            'email' => 'mary@example.com',
            'password' => bcrypt('password'),
            'city' => 'Lahore',
            'status' => \App\Enums\UserStatus::Active,
        ]);
        $babysitterUser->assignRole('babysitter');

        $profile = BabysitterProfile::create([
            'user_id' => $babysitterUser->id,
            'hourly_rate' => 1500,
            'experience_years' => 5,
            'verified_status' => \App\Enums\VerifiedStatus::Verified,
        ]);

        $parentUser = User::create([
            'name' => 'Parent John',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
            'status' => \App\Enums\UserStatus::Active,
        ]);

        $booking = Booking::create([
            'parent_id' => $parentUser->id,
            'babysitter_id' => $babysitterUser->id,
            'date' => now()->toDateString(),
            'start_time' => '09:00',
            'duration_hours' => 3,
            'location' => 'Test Street',
            'total_fee' => 4500,
            'status' => 'completed',
        ]);

        BabysitterReview::create([
            'booking_id' => $booking->id,
            'parent_id' => $parentUser->id,
            'babysitter_id' => $babysitterUser->id,
            'rating' => 5,
            'comment' => 'Great babysitter!',
        ]);

        BabysitterReview::create([
            'booking_id' => $booking->id,
            'parent_id' => $parentUser->id,
            'babysitter_id' => $babysitterUser->id,
            'rating' => 3,
            'comment' => 'Decent babysitter.',
        ]);

        $service = new BabysitterService();
        $results = $service->getAll([]);

        $this->assertCount(1, $results->items());
        $fetched = $results->items()[0];

        // Ensure reviews relation was NOT loaded into memory as models
        $this->assertFalse($fetched->relationLoaded('reviews'));

        // Ensure avgRating accessor computes correctly from subquery ( (5 + 3) / 2 = 4.0 )
        $this->assertEquals(4.0, $fetched->avgRating);
    }

    public function test_get_all_handles_babysitter_with_zero_reviews_without_extra_queries(): void
    {
        $babysitterUser = User::create([
            'name' => 'Babysitter NoReviews',
            'email' => 'noreviews@example.com',
            'password' => bcrypt('password'),
            'city' => 'Islamabad',
            'status' => \App\Enums\UserStatus::Active,
        ]);
        $babysitterUser->assignRole('babysitter');

        BabysitterProfile::create([
            'user_id' => $babysitterUser->id,
            'hourly_rate' => 1200,
            'experience_years' => 2,
            'verified_status' => \App\Enums\VerifiedStatus::Verified,
        ]);

        $service = new BabysitterService();

        \Illuminate\Support\Facades\DB::enableQueryLog();
        $results = $service->getAll([]);
        $fetched = $results->items()[0];

        // Accessing avgRating should not execute any additional queries when reviews_avg_rating attribute is key-present
        $queryCountBefore = count(\Illuminate\Support\Facades\DB::getQueryLog());
        $this->assertEquals(0.0, $fetched->avgRating);
        $queryCountAfter = count(\Illuminate\Support\Facades\DB::getQueryLog());

        $this->assertEquals($queryCountBefore, $queryCountAfter);
    }

    public function test_get_featured_computes_avg_rating_via_subquery(): void
    {
        $babysitterUser = User::create([
            'name' => 'Babysitter Sarah',
            'email' => 'sarah@example.com',
            'password' => bcrypt('password'),
            'city' => 'Karachi',
            'status' => \App\Enums\UserStatus::Active,
        ]);
        $babysitterUser->assignRole('babysitter');

        $profile = BabysitterProfile::create([
            'user_id' => $babysitterUser->id,
            'hourly_rate' => 2000,
            'experience_years' => 3,
            'verified_status' => \App\Enums\VerifiedStatus::Verified,
        ]);

        $parentUser = User::create([
            'name' => 'Parent Fatima',
            'email' => 'fatima@example.com',
            'password' => bcrypt('password'),
            'status' => \App\Enums\UserStatus::Active,
        ]);

        $booking = Booking::create([
            'parent_id' => $parentUser->id,
            'babysitter_id' => $babysitterUser->id,
            'date' => now()->toDateString(),
            'start_time' => '10:00',
            'duration_hours' => 4,
            'location' => 'Test Street 2',
            'total_fee' => 8000,
            'status' => 'completed',
        ]);

        BabysitterReview::create([
            'booking_id' => $booking->id,
            'parent_id' => $parentUser->id,
            'babysitter_id' => $babysitterUser->id,
            'rating' => 5,
            'comment' => 'Awesome service!',
        ]);

        $service = new BabysitterService();
        $featured = $service->getFeatured();

        $this->assertGreaterThanOrEqual(1, $featured->count());
        $first = $featured->first();

        $this->assertFalse($first->relationLoaded('reviews'));
        $this->assertEquals(5.0, $first->avgRating);
    }
}
