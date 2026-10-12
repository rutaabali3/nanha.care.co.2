<?php

namespace Tests\Feature;

use App\Enums\BookingStatus;
use App\Enums\VerifiedStatus;
use App\Models\Babysitting\Booking;
use App\Models\Babysitting\BabysitterReview;
use App\Models\Profiles\BabysitterProfile;
use App\Models\User;
use App\Services\BabysitterService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class BabysitterServiceTest extends TestCase
{
    use RefreshDatabase;

    protected BabysitterService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new BabysitterService();
    }

    private function createUser(array $attributes = []): User
    {
        return User::create(array_merge([
            'name' => 'Test User',
            'email' => 'user_' . Str::random(8) . '@example.com',
            'password' => bcrypt('password'),
            'city' => 'Karachi',
        ], $attributes));
    }

    private function createBooking(User $parent, User $babysitter): Booking
    {
        return Booking::create([
            'parent_id' => $parent->id,
            'babysitter_id' => $babysitter->id,
            'date' => now()->toDateString(),
            'start_time' => '10:00:00',
            'duration_hours' => 2,
            'location' => 'Karachi',
            'total_fee' => 2000,
            'status' => BookingStatus::Completed,
        ]);
    }

    public function test_get_all_uses_with_avg_and_does_not_eager_load_reviews_relation(): void
    {
        $user1 = $this->createUser(['name' => 'Alice', 'city' => 'Karachi']);
        $user2 = $this->createUser(['name' => 'Bob', 'city' => 'Karachi']);

        $profile1 = BabysitterProfile::create([
            'user_id' => $user1->id,
            'hourly_rate' => 1000,
            'verified_status' => VerifiedStatus::Verified,
        ]);

        $profile2 = BabysitterProfile::create([
            'user_id' => $user2->id,
            'hourly_rate' => 1500,
            'verified_status' => VerifiedStatus::Verified,
        ]);

        $booking1 = $this->createBooking($user2, $user1);
        $booking2 = $this->createBooking($user2, $user1);
        $booking3 = $this->createBooking($user1, $user2);

        BabysitterReview::create([
            'booking_id' => $booking1->id,
            'babysitter_id' => $profile1->id,
            'parent_id' => $user2->id,
            'rating' => 5,
            'comment' => 'Great!',
        ]);

        BabysitterReview::create([
            'booking_id' => $booking2->id,
            'babysitter_id' => $profile1->id,
            'parent_id' => $user2->id,
            'rating' => 3,
            'comment' => 'Okay!',
        ]);

        BabysitterReview::create([
            'booking_id' => $booking3->id,
            'babysitter_id' => $profile2->id,
            'parent_id' => $user1->id,
            'rating' => 4,
            'comment' => 'Good!',
        ]);

        $paginated = $this->service->getAll(['city' => 'Karachi']);

        $this->assertCount(2, $paginated->items());

        $first = $paginated->items()[0]->id === $profile1->id ? $paginated->items()[0] : $paginated->items()[1];

        // Verify reviews relation is NOT loaded into memory
        $this->assertFalse($first->relationLoaded('reviews'));

        // Verify avgRating accessor accurately returns average rating from withAvg attribute
        $this->assertEquals(4.0, $first->avgRating);
    }

    public function test_get_all_sort_by_rating(): void
    {
        $user1 = $this->createUser();
        $user2 = $this->createUser();

        $profileLowRating = BabysitterProfile::create([
            'user_id' => $user1->id,
            'hourly_rate' => 1000,
            'verified_status' => VerifiedStatus::Verified,
        ]);

        $profileHighRating = BabysitterProfile::create([
            'user_id' => $user2->id,
            'hourly_rate' => 1200,
            'verified_status' => VerifiedStatus::Verified,
        ]);

        $booking1 = $this->createBooking($user2, $user1);
        $booking2 = $this->createBooking($user1, $user2);

        BabysitterReview::create([
            'booking_id' => $booking1->id,
            'babysitter_id' => $profileLowRating->id,
            'parent_id' => $user2->id,
            'rating' => 2,
            'comment' => 'Low rating review',
        ]);

        BabysitterReview::create([
            'booking_id' => $booking2->id,
            'babysitter_id' => $profileHighRating->id,
            'parent_id' => $user1->id,
            'rating' => 5,
            'comment' => 'High rating review',
        ]);

        $result = $this->service->getAll(['sort' => 'rating']);

        $items = $result->items();
        $this->assertEquals($profileHighRating->id, $items[0]->id);
        $this->assertEquals(5.0, $items[0]->avgRating);
        $this->assertEquals(2.0, $items[1]->avgRating);
    }

    public function test_get_featured_returns_avg_rating_without_eager_loading_reviews(): void
    {
        $user1 = $this->createUser();
        $user2 = $this->createUser();
        $profile = BabysitterProfile::create([
            'user_id' => $user1->id,
            'hourly_rate' => 1000,
            'verified_status' => VerifiedStatus::Verified,
        ]);

        $booking = $this->createBooking($user2, $user1);

        BabysitterReview::create([
            'booking_id' => $booking->id,
            'babysitter_id' => $profile->id,
            'parent_id' => $user2->id,
            'rating' => 5,
            'comment' => 'Awesome babysitter',
        ]);

        $featured = $this->service->getFeatured();

        $this->assertCount(1, $featured);
        $this->assertFalse($featured->first()->relationLoaded('reviews'));
        $this->assertEquals(5.0, $featured->first()->avgRating);
    }

    public function test_unreviewed_babysitter_returns_zero_avg_rating_without_extra_query(): void
    {
        $user = $this->createUser();
        BabysitterProfile::create([
            'user_id' => $user->id,
            'hourly_rate' => 1000,
            'verified_status' => VerifiedStatus::Verified,
        ]);

        $paginated = $this->service->getAll([]);
        $unreviewed = $paginated->items()[0];

        $this->assertFalse($unreviewed->relationLoaded('reviews'));
        $this->assertEquals(0.0, $unreviewed->avgRating);
    }
}
