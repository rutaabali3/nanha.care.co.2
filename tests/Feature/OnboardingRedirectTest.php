<?php

namespace Tests\Feature;

use App\Enums\UserStatus;
use App\Models\Marketplace\Shop;
use App\Models\Profiles\DoctorProfile;
use App\Models\Profiles\ParentProfile;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OnboardingRedirectTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);
    }

    public function test_guest_can_access_home_page_without_redirect(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_parent_without_onboarding_is_redirected_from_dashboard(): void
    {
        $user = User::create([
            'name' => 'Test Parent',
            'email' => 'parent@example.com',
            'password' => bcrypt('password'),
            'status' => UserStatus::Active,
        ]);
        $user->assignRole('parent');

        $response = $this->actingAs($user)->get('/dashboard/parent');
        $response->assertRedirect(route('onboarding.parent'));
    }

    public function test_parent_without_onboarding_is_redirected_from_cart_and_checkout(): void
    {
        $user = User::create([
            'name' => 'Test Parent',
            'email' => 'parent@example.com',
            'password' => bcrypt('password'),
            'status' => UserStatus::Active,
        ]);
        $user->assignRole('parent');

        $response = $this->actingAs($user)->get('/cart');
        $response->assertRedirect(route('onboarding.parent'));

        $response2 = $this->actingAs($user)->get('/checkout');
        $response2->assertRedirect(route('onboarding.parent'));
    }

    public function test_parent_with_onboarding_can_access_dashboard_and_cart(): void
    {
        $user = User::create([
            'name' => 'Test Parent',
            'email' => 'parent@example.com',
            'password' => bcrypt('password'),
            'status' => UserStatus::Active,
        ]);
        $user->assignRole('parent');

        ParentProfile::create([
            'user_id' => $user->id,
            'num_children' => 2,
            'emergency_contact_name' => 'Emergency',
            'emergency_contact_phone' => '1234567890',
            'address' => 'Test Address',
        ]);

        $response = $this->actingAs($user)->get('/dashboard/parent');
        $response->assertStatus(200);

        $response2 = $this->actingAs($user)->get('/cart');
        $response2->assertStatus(200);
    }

    public function test_doctor_without_onboarding_is_redirected_from_dashboard(): void
    {
        $user = User::create([
            'name' => 'Test Doctor',
            'email' => 'doctor@example.com',
            'password' => bcrypt('password'),
            'status' => UserStatus::Active,
        ]);
        $user->assignRole('doctor');

        $response = $this->actingAs($user)->get('/dashboard/doctor');
        $response->assertRedirect(route('onboarding.doctor'));
    }

    public function test_doctor_with_onboarding_can_access_dashboard(): void
    {
        $user = User::create([
            'name' => 'Test Doctor',
            'email' => 'doctor@example.com',
            'password' => bcrypt('password'),
            'status' => UserStatus::Active,
        ]);
        $user->assignRole('doctor');

        DoctorProfile::create([
            'user_id' => $user->id,
            'license_number' => 'DOC123',
            'specialization' => 'Pediatrics',
            'hospital' => 'Test Hospital',
            'pmdc_number' => '12345-D',
        ]);

        $response = $this->actingAs($user)->get('/dashboard/doctor');
        $response->assertStatus(200);
    }

    public function test_shop_owner_onboarding_saves_categories_in_json(): void
    {
        $user = User::create([
            'name' => 'Test Shop Owner',
            'email' => 'shopowner@example.com',
            'password' => bcrypt('password'),
            'status' => UserStatus::Active,
        ]);
        $user->assignRole('shop_owner');

        $response = $this->actingAs($user)->post('/onboarding/shop-owner', [
            'full_name' => 'Test Shop Owner',
            'email' => 'shopowner@example.com',
            'phone' => '1234567890',
            'city' => 'Lahore',
            'shop_name' => 'Test Shop',
            'shop_description' => 'Test Shop Description',
            'shop_address' => 'Test Shop Address',
            'categories' => ['toys', 'clothing'],
        ]);

        $response->assertRedirect('/dashboard/shop-owner');

        $shop = Shop::where('user_id', $user->id)->first();
        $this->assertNotNull($shop);
        $this->assertEquals(['toys', 'clothing'], $shop->category);
    }
}
