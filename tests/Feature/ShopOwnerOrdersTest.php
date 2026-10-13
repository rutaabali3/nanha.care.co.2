<?php

namespace Tests\Feature;

use App\Enums\OrderStatus;
use App\Enums\ProductCategory;
use App\Enums\UserStatus;
use App\Models\Marketplace\Order;
use App\Models\Marketplace\Product;
use App\Models\Marketplace\Shop;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ShopOwnerOrdersTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);
    }

    public function test_shop_owner_can_filter_orders_by_status_and_date_at_database_level(): void
    {
        $shopOwner = User::create([
            'name' => 'Shop Owner',
            'email' => 'shop@example.com',
            'password' => bcrypt('password'),
            'status' => UserStatus::Active,
        ]);
        $shopOwner->assignRole('shop_owner');

        $parent = User::create([
            'name' => 'Parent User',
            'email' => 'parent@example.com',
            'password' => bcrypt('password'),
            'status' => UserStatus::Active,
        ]);
        $parent->assignRole('parent');

        $shop = Shop::create([
            'user_id' => $shopOwner->id,
            'name' => 'Test Shop',
            'slug' => 'test-shop',
            'description' => 'Test shop description',
            'category' => ['toys'],
            'address' => 'Test Address',
            'phone' => '1234567890',
            'is_approved' => true,
        ]);

        $product = Product::create([
            'shop_id' => $shop->id,
            'name' => 'Test Toy',
            'category' => ProductCategory::Newborns,
            'description' => 'Toy description',
            'price' => 100,
            'stock_qty' => 10,
            'status' => 'published',
        ]);

        $orderProcessing = Order::create([
            'parent_id' => $parent->id,
            'shipping_address' => 'Address 1',
            'payment_method' => 'cod',
            'status' => OrderStatus::Processing->value,
            'total' => 100,
        ]);
        $orderProcessing->items()->create([
            'product_id' => $product->id,
            'qty' => 1,
            'unit_price' => 100,
            'total' => 100,
        ]);
        DB::table('orders')->where('id', $orderProcessing->id)->update([
            'created_at' => now()->subDays(5)->toDateTimeString(),
        ]);

        $orderDelivered = Order::create([
            'parent_id' => $parent->id,
            'shipping_address' => 'Address 2',
            'payment_method' => 'cod',
            'status' => OrderStatus::Delivered->value,
            'total' => 200,
        ]);
        $orderDelivered->items()->create([
            'product_id' => $product->id,
            'qty' => 2,
            'unit_price' => 100,
            'total' => 200,
        ]);

        // Filter by status=delivered
        $response = $this->actingAs($shopOwner)->get('/dashboard/shop-owner/orders?status=delivered');
        $response->assertStatus(200);
        $response->assertSee('#' . $orderDelivered->id);
        $response->assertDontSee('#' . $orderProcessing->id);

        // Filter by date range (today only)
        $todayStr = now()->format('Y-m-d');
        $responseDate = $this->actingAs($shopOwner)->get('/dashboard/shop-owner/orders?from=' . $todayStr . '&to=' . $todayStr);
        $responseDate->assertStatus(200);
        $responseDate->assertSee('#' . $orderDelivered->id);
        $responseDate->assertDontSee('#' . $orderProcessing->id);
    }
}
