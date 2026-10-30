<?php

namespace Tests\Feature;

use App\Enums\BookingStatus;
use App\Models\Babysitting\Booking;
use App\Models\Profiles\BabysitterProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class BabysitterEarningsChartTest extends TestCase
{
    use RefreshDatabase;

    public function test_babysitter_earnings_chart_data_returns_accurate_monthly_totals()
    {
        Role::findOrCreate('babysitter');

        $user = User::create([
            'name' => 'Sitter Test',
            'email' => 'sittertest@example.com',
            'password' => bcrypt('password'),
        ]);

        $user->assignRole('babysitter');

        BabysitterProfile::create([
            'user_id' => $user->id,
            'bio' => 'Test bio',
            'hourly_rate' => 20,
            'experience_years' => 5,
        ]);

        Booking::create([
            'parent_id' => $user->id,
            'babysitter_id' => $user->id,
            'date' => now()->subMonths(1)->format('Y-m-d'),
            'start_time' => '10:00',
            'duration_hours' => 2,
            'location' => 'Home',
            'total_fee' => 120.00,
            'status' => BookingStatus::Completed,
        ]);

        Booking::create([
            'parent_id' => $user->id,
            'babysitter_id' => $user->id,
            'date' => now()->subMonths(1)->format('Y-m-d'),
            'start_time' => '14:00',
            'duration_hours' => 2,
            'location' => 'Home',
            'total_fee' => 80.00,
            'status' => BookingStatus::Completed,
        ]);

        $this->actingAs($user);

        $response = $this->getJson(route('babysitter.earnings.chart-data'));

        $response->assertOk();
        $response->assertJsonCount(12);

        $monthKey = now()->subMonths(1)->format('Y-m');
        $response->assertJsonFragment([
            'month' => $monthKey,
            'total' => 200.0,
        ]);
    }
}
