<?php

namespace Tests\Unit;

use App\Enums\OrderStatus;
use App\Enums\ProductCategory;
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

    public function test_get_shop_owner_overview_with_no_shop(): void
    {
        $user = User::create([
            'name' => 'Owner No Shop',
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

    public function test_get_shop_owner_overview_with_shop_and_products_and_orders(): void
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
            'name' => 'Test Shop',
            'slug' => 'test-shop',
            'status' => 'active',
        ]);

        $product1 = Product::create([
            'shop_id' => $shop->id,
            'name' => 'Product 1',
            'price' => 100,
            'stock_qty' => 10,
            'category' => ProductCategory::Newborns,
            'status' => 'published',
        ]);

        $product2 = Product::create([
            'shop_id' => $shop->id,
            'name' => 'Product 2',
            'price' => 200,
            'stock_qty' => 10,
            'category' => ProductCategory::Newborns,
            'status' => 'published',
        ]);

        // Review
        ProductReview::create([
            'product_id' => $product1->id,
            'user_id' => $parent->id,
            'rating' => 4,
            'comment' => 'Good product',
            'status' => 'approved',
        ]);

        // Order 1: Delivered
        $order1 = Order::create([
            'parent_id' => $parent->id,
            'total' => 150.00,
            'status' => OrderStatus::Delivered->value,
            'shipping_address' => '123 Main St',
            'payment_method' => 'cod',
        ]);
        OrderItem::create([
            'order_id' => $order1->id,
            'product_id' => $product1->id,
            'qty' => 1,
            'unit_price' => 100,
            'total' => 100,
        ]);

        // Order 2: Pending / Processing
        $order2 = Order::create([
            'parent_id' => $parent->id,
            'total' => 200.00,
            'status' => OrderStatus::Processing->value,
            'shipping_address' => '123 Main St',
            'payment_method' => 'cod',
        ]);
        OrderItem::create([
            'order_id' => $order2->id,
            'product_id' => $product2->id,
            'qty' => 1,
            'unit_price' => 200,
            'total' => 200,
        ]);

        $overview = $this->service->getShopOwnerOverview($owner->id);

        $this->assertEquals($shop->id, $overview['shop']->id);
        $this->assertEquals(2, $overview['total_products']);
        $this->assertEquals(2, $overview['total_orders']);
        $this->assertEquals(1, $overview['pending_orders']);
        $this->assertEquals(150.0, $overview['total_revenue']);
        $this->assertEquals(4.0, $overview['avg_rating']);
        $this->assertEquals(1, $overview['total_reviews']);
        $this->assertCount(2, $overview['recent_orders']);
    }
}
