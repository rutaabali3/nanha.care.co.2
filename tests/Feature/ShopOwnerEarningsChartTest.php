<?php

namespace Tests\Feature;

use App\Enums\OrderStatus;
use App\Enums\ProductCategory;
use App\Models\Marketplace\Order;
use App\Models\Marketplace\OrderItem;
use App\Models\Marketplace\Product;
use App\Models\Marketplace\Shop;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShopOwnerEarningsChartTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);
    }

    public function test_shop_owner_chart_data_returns_12_months_and_correct_totals(): void
    {
        $user = User::create([
            'name' => 'Shop Owner',
            'email' => 'shopowner@example.com',
            'password' => bcrypt('password'),
            'status' => \App\Enums\UserStatus::Active,
        ]);
        $user->assignRole('shop_owner');

        $shop = Shop::create([
            'user_id' => $user->id,
            'name' => 'Test Shop',
            'slug' => 'test-shop',
            'contact_email' => 'shop@example.com',
            'contact_phone' => '1234567890',
        ]);

        $product = Product::create([
            'shop_id' => $shop->id,
            'name' => 'Test Product',
            'slug' => 'test-product',
            'description' => 'A test product',
            'category' => ProductCategory::Toddlers,
            'price' => 100.00,
            'stock_qty' => 10,
            'status' => \App\Enums\ContentStatus::Published,
        ]);

        $parent = User::create([
            'name' => 'Parent User',
            'email' => 'parent@example.com',
            'password' => bcrypt('password'),
            'status' => \App\Enums\UserStatus::Active,
        ]);

        $now = now()->startOfMonth()->addDays(5);
        $prevMonthDate = now()->subMonth()->startOfMonth()->addDays(5);

        // Create an order in current month
        $orderCurrentMonth = Order::create([
            'parent_id' => $parent->id,
            'shipping_address' => ['address' => '123 St'],
            'payment_method' => 'card',
            'status' => OrderStatus::Delivered,
            'total' => 200.00,
        ]);
        $orderCurrentMonth->timestamps = false;
        $orderCurrentMonth->created_at = $now;
        $orderCurrentMonth->save();

        OrderItem::create([
            'order_id' => $orderCurrentMonth->id,
            'product_id' => $product->id,
            'qty' => 2,
            'unit_price' => 100.00,
            'total' => 200.00,
        ]);

        // Create an order in previous month
        $orderPrevMonth = Order::create([
            'parent_id' => $parent->id,
            'shipping_address' => ['address' => '123 St'],
            'payment_method' => 'card',
            'status' => OrderStatus::Delivered,
            'total' => 150.00,
        ]);
        $orderPrevMonth->timestamps = false;
        $orderPrevMonth->created_at = $prevMonthDate;
        $orderPrevMonth->save();

        OrderItem::create([
            'order_id' => $orderPrevMonth->id,
            'product_id' => $product->id,
            'qty' => 1,
            'unit_price' => 150.00,
            'total' => 150.00,
        ]);

        $response = $this->actingAs($user)->getJson('/dashboard/shop-owner/earnings/chart-data');

        $response->assertStatus(200)
            ->assertJsonCount(12);

        $currentMonthKey = $now->format('Y-m');
        $prevMonthKey = $prevMonthDate->format('Y-m');

        $responseData = $response->json();

        $currentMonthEntry = collect($responseData)->firstWhere('month', $currentMonthKey);
        $prevMonthEntry = collect($responseData)->firstWhere('month', $prevMonthKey);

        $this->assertNotNull($currentMonthEntry);
        $this->assertEquals(200.00, $currentMonthEntry['total']);

        $this->assertNotNull($prevMonthEntry);
        $this->assertEquals(150.00, $prevMonthEntry['total']);
    }
}
