<?php

namespace Tests\Unit;

use App\Models\Marketplace\Order;
use App\Models\Marketplace\OrderItem;
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

    private DashboardService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new DashboardService();
    }

    public function test_get_shop_owner_overview_when_user_has_no_shop(): void
    {
        $user = User::create([
            'name' => 'No Shop Owner',
            'email' => 'noshop@example.com',
            'password' => bcrypt('password'),
        ]);

        $overview = $this->service->getShopOwnerOverview($user->id);

        $this->assertNull($overview['shop']);
        $this->assertEquals(0, $overview['total_products']);
        $this->assertEquals(0, $overview['total_orders']);
        $this->assertEquals(0, $overview['pending_orders']);
        $this->assertEquals(0.0, $overview['total_revenue']);
        $this->assertEquals(0, $overview['avg_rating']);
        $this->assertEquals(0, $overview['total_reviews']);
        $this->assertCount(0, $overview['recent_orders']);
    }

    public function test_get_shop_owner_overview_when_shop_has_no_products(): void
    {
        $user = User::create([
            'name' => 'Empty Shop Owner',
            'email' => 'emptyshop@example.com',
            'password' => bcrypt('password'),
        ]);

        $shop = Shop::create([
            'user_id' => $user->id,
            'name' => 'Empty Shop',
            'slug' => 'empty-shop',
            'description' => 'A shop with no products',
        ]);

        $overview = $this->service->getShopOwnerOverview($user->id);

        $this->assertEquals($shop->id, $overview['shop']->id);
        $this->assertEquals(0, $overview['total_products']);
        $this->assertEquals(0, $overview['total_orders']);
        $this->assertEquals(0, $overview['pending_orders']);
        $this->assertEquals(0.0, $overview['total_revenue']);
        $this->assertEquals(0, $overview['avg_rating']);
        $this->assertEquals(0, $overview['total_reviews']);
        $this->assertCount(0, $overview['recent_orders']);
    }

    public function test_get_shop_owner_overview_returns_correct_metrics(): void
    {
        $owner = User::create([
            'name' => 'Shop Owner',
            'email' => 'owner@example.com',
            'password' => bcrypt('password'),
        ]);

        $parent = User::create([
            'name' => 'Parent User',
            'email' => 'parent@example.com',
            'password' => bcrypt('password'),
        ]);

        $shop = Shop::create([
            'user_id' => $owner->id,
            'name' => 'Active Shop',
            'slug' => 'active-shop',
            'description' => 'A shop with products and orders',
        ]);

        $product1 = Product::create([
            'shop_id' => $shop->id,
            'name' => 'Product 1',
            'category' => \App\Enums\ProductCategory::Toddlers,
            'price' => 100,
            'stock_qty' => 10,
            'status' => 'published',
        ]);

        $product2 = Product::create([
            'shop_id' => $shop->id,
            'name' => 'Product 2',
            'category' => \App\Enums\ProductCategory::Toddlers,
            'price' => 50,
            'stock_qty' => 5,
            'status' => 'published',
        ]);

        // Create reviews
        ProductReview::create([
            'product_id' => $product1->id,
            'user_id' => $parent->id,
            'rating' => 4,
            'comment' => 'Great!',
        ]);

        ProductReview::create([
            'product_id' => $product2->id,
            'user_id' => $parent->id,
            'rating' => 5,
            'comment' => 'Excellent!',
        ]);

        // Create orders
        $deliveredOrder = Order::create([
            'parent_id' => $parent->id,
            'shipping_address' => '123 Street',
            'payment_method' => 'card',
            'status' => \App\Enums\OrderStatus::Delivered,
            'total' => 150,
        ]);

        OrderItem::create([
            'order_id' => $deliveredOrder->id,
            'product_id' => $product1->id,
            'qty' => 1,
            'unit_price' => 100,
            'total' => 100,
        ]);

        $pendingOrder = Order::create([
            'parent_id' => $parent->id,
            'shipping_address' => '123 Street',
            'payment_method' => 'card',
            'status' => \App\Enums\OrderStatus::Processing,
            'total' => 50,
        ]);

        OrderItem::create([
            'order_id' => $pendingOrder->id,
            'product_id' => $product2->id,
            'qty' => 1,
            'unit_price' => 50,
            'total' => 50,
        ]);

        $overview = $this->service->getShopOwnerOverview($owner->id);

        $this->assertEquals(2, $overview['total_products']);
        $this->assertEquals(2, $overview['total_orders']);
        $this->assertEquals(0, $overview['pending_orders']);
        $this->assertEquals(150.0, $overview['total_revenue']);
        $this->assertEquals(4.5, $overview['avg_rating']);
        $this->assertEquals(2, $overview['total_reviews']);
        $this->assertCount(2, $overview['recent_orders']);
    }
}
