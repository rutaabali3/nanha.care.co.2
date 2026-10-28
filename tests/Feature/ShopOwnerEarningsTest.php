<?php

namespace Tests\Feature;

use App\Enums\OrderStatus;
use App\Enums\ProductCategory;
use App\Enums\UserStatus;
use App\Models\Marketplace\Order;
use App\Models\Marketplace\OrderItem;
use App\Models\Marketplace\Product;
use App\Models\Marketplace\Shop;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShopOwnerEarningsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);
    }

    public function test_shop_owner_chart_data_returns_monthly_totals_correctly(): void
    {
        $user = User::create([
            'name' => 'Shop Owner',
            'email' => 'shop@example.com',
            'password' => bcrypt('password'),
            'status' => UserStatus::Active,
        ]);
        $user->assignRole('shop_owner');

        $shop = Shop::create([
            'user_id' => $user->id,
            'name' => 'Test Shop',
            'slug' => 'test-shop',
            'category' => ['newborns'],
            'address' => '123 Street',
            'is_verified' => true,
        ]);

        $product = Product::create([
            'shop_id' => $shop->id,
            'name' => 'Test Product',
            'category' => ProductCategory::Newborns->value,
            'price' => 100.00,
            'stock_qty' => 10,
            'status' => 'published',
        ]);

        $parent = User::create([
            'name' => 'Parent User',
            'email' => 'parent@example.com',
            'password' => bcrypt('password'),
            'status' => UserStatus::Active,
        ]);

        $defaultAddress = [
            'street' => '123 Main St',
            'city' => 'Lahore',
            'phone' => '1234567890',
        ];

        // Order 1: Current month, delivered
        $order1 = Order::create([
            'parent_id' => $parent->id,
            'status' => OrderStatus::Delivered,
            'total' => 200.00,
            'shipping_address' => $defaultAddress,
            'payment_method' => 'cod',
            'created_at' => now(),
        ]);
        OrderItem::create([
            'order_id' => $order1->id,
            'product_id' => $product->id,
            'qty' => 2,
            'unit_price' => 100.00,
            'total' => 200.00,
        ]);

        // Order 2: 2 months ago, delivered
        $order2 = Order::create([
            'parent_id' => $parent->id,
            'status' => OrderStatus::Delivered,
            'total' => 150.00,
            'shipping_address' => $defaultAddress,
            'payment_method' => 'cod',
            'created_at' => now()->subMonths(2),
        ]);
        OrderItem::create([
            'order_id' => $order2->id,
            'product_id' => $product->id,
            'qty' => 1,
            'unit_price' => 150.00,
            'total' => 150.00,
        ]);

        // Order 3: 2 months ago, processing (should NOT be included)
        $order3 = Order::create([
            'parent_id' => $parent->id,
            'status' => OrderStatus::Processing,
            'total' => 300.00,
            'shipping_address' => $defaultAddress,
            'payment_method' => 'cod',
            'created_at' => now()->subMonths(2),
        ]);
        OrderItem::create([
            'order_id' => $order3->id,
            'product_id' => $product->id,
            'qty' => 3,
            'unit_price' => 100.00,
            'total' => 300.00,
        ]);

        $response = $this->actingAs($user)->getJson('/dashboard/shop-owner/earnings/chart-data');

        $response->assertStatus(200);
        $data = $response->json();

        $this->assertCount(12, $data);

        $currentMonthKey = now()->format('Y-m');
        $twoMonthsAgoKey = now()->subMonths(2)->format('Y-m');

        $currentMonthData = collect($data)->firstWhere('month', $currentMonthKey);
        $twoMonthsAgoData = collect($data)->firstWhere('month', $twoMonthsAgoKey);

        $this->assertNotNull($currentMonthData);

        $this->assertNotNull($twoMonthsAgoData);
    }
}
