<?php

namespace Tests\Unit;

use App\Enums\OrderStatus;
use App\Enums\ProductCategory;
use App\Enums\UserStatus;
use App\Models\Marketplace\Order;
use App\Models\Marketplace\Product;
use App\Models\Marketplace\ProductReview;
use App\Models\Marketplace\Shop;
use App\Models\User;
use App\Services\DashboardService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_shop_owner_overview_returns_correct_consolidated_metrics()
    {
        // Create shop owner user and shop
        $user = User::create([
            'name' => 'Shop Owner',
            'email' => 'shopowner@example.com',
            'password' => bcrypt('password'),
            'status' => UserStatus::Active,
        ]);

        $shop = Shop::create([
            'user_id' => $user->id,
            'name' => 'Test Shop',
            'slug' => 'test-shop',
            'contact_email' => 'shop@test.com',
        ]);

        // Create product
        $product = Product::create([
            'shop_id' => $shop->id,
            'name' => 'Test Product',
            'price' => 100.00,
            'status' => 'published',
            'category' => ProductCategory::Newborns,
            'stock_qty' => 10,
        ]);

        // Create orders
        $order1 = Order::create([
            'parent_id' => $user->id,
            'shipping_address' => '123 Main St',
            'payment_method' => 'card',
            'status' => OrderStatus::Processing,
            'total' => 100.00,
        ]);
        $order1->items()->create([
            'product_id' => $product->id,
            'qty' => 1,
            'unit_price' => 100.00,
            'total' => 100.00,
        ]);

        $order2 = Order::create([
            'parent_id' => $user->id,
            'shipping_address' => '123 Main St',
            'payment_method' => 'card',
            'status' => OrderStatus::Delivered,
            'total' => 200.00,
        ]);
        $order2->items()->create([
            'product_id' => $product->id,
            'qty' => 2,
            'unit_price' => 100.00,
            'total' => 200.00,
        ]);

        // Create reviews
        ProductReview::create([
            'product_id' => $product->id,
            'user_id' => $user->id,
            'rating' => 4,
            'comment' => 'Great product',
        ]);

        ProductReview::create([
            'product_id' => $product->id,
            'user_id' => $user->id,
            'rating' => 5,
            'comment' => 'Awesome product',
        ]);

        $dashboardService = new DashboardService;
        $overview = $dashboardService->getShopOwnerOverview($user->id);

        $this->assertEquals($shop->id, $overview['shop']->id);
        $this->assertEquals(1, $overview['total_products']);
        $this->assertEquals(2, $overview['total_orders']);
        $this->assertEquals(1, $overview['pending_orders']);
        $this->assertEquals(200.00, $overview['total_revenue']);
        $this->assertEquals(4.5, $overview['avg_rating']);
        $this->assertEquals(2, $overview['total_reviews']);
        $this->assertCount(2, $overview['recent_orders']);
    }

    public function test_get_shop_owner_overview_returns_empty_defaults_for_user_without_shop()
    {
        $user = User::create([
            'name' => 'User Without Shop',
            'email' => 'noshop@example.com',
            'password' => bcrypt('password'),
            'status' => UserStatus::Active,
        ]);

        $dashboardService = new DashboardService;
        $overview = $dashboardService->getShopOwnerOverview($user->id);

        $this->assertNull($overview['shop']);
        $this->assertEquals(0, $overview['total_products']);
        $this->assertEquals(0, $overview['total_orders']);
        $this->assertEquals(0, $overview['pending_orders']);
        $this->assertEquals(0.0, $overview['total_revenue']);
        $this->assertEquals(0.0, $overview['avg_rating']);
        $this->assertEquals(0, $overview['total_reviews']);
        $this->assertCount(0, $overview['recent_orders']);
    }
}
