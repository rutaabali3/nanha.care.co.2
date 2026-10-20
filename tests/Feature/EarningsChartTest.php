<?php

namespace Tests\Feature;

use App\Enums\BookingStatus;
use App\Enums\OrderStatus;
use App\Enums\ProductCategory;
use App\Enums\UserStatus;
use App\Models\Babysitting\Booking;
use App\Models\Marketplace\Order;
use App\Models\Marketplace\OrderItem;
use App\Models\Marketplace\Product;
use App\Models\Marketplace\Shop;
use App\Models\Profiles\BabysitterProfile;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EarningsChartTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);
    }

    private function createUser(string $role): User
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => uniqid() . '@example.com',
            'password' => bcrypt('password'),
            'status' => UserStatus::Active,
        ]);
        $user->assignRole($role);
        return $user;
    }

    public function test_babysitter_chart_data_returns_12_months_aggregated_correctly(): void
    {
        $babysitter = $this->createUser('babysitter');
        $parent = $this->createUser('parent');

        BabysitterProfile::create([
            'user_id' => $babysitter->id,
            'cnic' => '12345-6789012-3',
            'experience_years' => 5,
            'hourly_rate' => 50,
            'bio' => 'Experienced babysitter',
            'availability' => ['monday' => true],
        ]);

        $month1 = now()->subMonths(2);
        $month2 = now()->subMonths(1);

        Booking::create([
            'babysitter_id' => $babysitter->id,
            'parent_id' => $parent->id,
            'status' => BookingStatus::Completed,
            'date' => $month1->format('Y-m-d'),
            'start_time' => '09:00',
            'end_time' => '12:00',
            'duration_hours' => 3,
            'hourly_rate' => 50,
            'total_fee' => 150.00,
            'location' => 'Home',
        ]);

        Booking::create([
            'babysitter_id' => $babysitter->id,
            'parent_id' => $parent->id,
            'status' => BookingStatus::Completed,
            'date' => $month1->format('Y-m-d'),
            'start_time' => '13:00',
            'end_time' => '15:00',
            'duration_hours' => 2,
            'hourly_rate' => 50,
            'total_fee' => 100.00,
            'location' => 'Home',
        ]);

        Booking::create([
            'babysitter_id' => $babysitter->id,
            'parent_id' => $parent->id,
            'status' => BookingStatus::Completed,
            'date' => $month2->format('Y-m-d'),
            'start_time' => '10:00',
            'end_time' => '11:00',
            'duration_hours' => 1,
            'hourly_rate' => 50,
            'total_fee' => 50.00,
            'location' => 'Home',
        ]);

        $response = $this->actingAs($babysitter)->getJson(route('babysitter.earnings.chart-data'));

        $response->assertStatus(200);
        $data = $response->json();

        $this->assertCount(12, $data);

        $m1Key = $month1->format('Y-m');
        $m2Key = $month2->format('Y-m');

        $m1Entry = collect($data)->firstWhere('month', $m1Key);
        $m2Entry = collect($data)->firstWhere('month', $m2Key);

        $this->assertNotNull($m1Entry);
        $this->assertEquals(250.00, $m1Entry['total']);

        $this->assertNotNull($m2Entry);
        $this->assertEquals(50.00, $m2Entry['total']);
    }

    public function test_shop_owner_chart_data_returns_12_months_aggregated_correctly(): void
    {
        $shopOwner = $this->createUser('shop_owner');
        $parent = $this->createUser('parent');

        $shop = Shop::create([
            'user_id' => $shopOwner->id,
            'name' => 'Test Shop',
            'slug' => 'test-shop',
            'description' => 'Test',
            'contact_info' => 'test@test.com',
            'category' => ['newborns'],
            'is_active' => true,
        ]);

        $product = Product::create([
            'shop_id' => $shop->id,
            'name' => 'Toy',
            'slug' => 'toy',
            'description' => 'A nice toy',
            'price' => 20.00,
            'stock_qty' => 100,
            'category' => ProductCategory::Newborns,
            'status' => 'published',
        ]);

        $month1 = now()->subMonths(1);

        $order = Order::create([
            'parent_id' => $parent->id,
            'order_number' => 'ORD-12345',
            'shipping_address' => ['street' => '123 Main St'],
            'payment_method' => 'card',
            'status' => OrderStatus::Delivered,
            'total' => 40.00,
        ]);
        $order->created_at = $month1;
        $order->updated_at = $month1;
        $order->save();

        $item = OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'qty' => 2,
            'unit_price' => 20.00,
            'total' => 40.00,
        ]);
        $item->created_at = $month1;
        $item->updated_at = $month1;
        $item->save();

        $response = $this->actingAs($shopOwner)->getJson(route('shop-owner.earnings.chart-data'));

        $response->assertStatus(200);
        $data = $response->json();

        $this->assertCount(12, $data);

        $m1Key = $month1->format('Y-m');
        $m1Entry = collect($data)->firstWhere('month', $m1Key);

        $this->assertNotNull($m1Entry);
        $this->assertEquals(40.00, $m1Entry['total']);
    }
}
