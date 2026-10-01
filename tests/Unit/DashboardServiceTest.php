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

    public function test_get_shop_owner_overview_returns_empty_when_no_shop(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $service = new DashboardService();

        $overview = $service->getShopOwnerOverview($user->id);

        $this->assertNull($overview['shop']);
        $this->assertEquals(0, $overview['total_products']);
        $this->assertEquals(0, $overview['total_orders']);
        $this->assertEquals(0, $overview['pending_orders']);
        $this->assertEquals(0.0, $overview['total_revenue']);
        $this->assertEquals(0.0, $overview['avg_rating']);
        $this->assertEquals(0, $overview['total_reviews']);
        $this->assertCount(0, $overview['recent_orders']);
    }

    public function test_get_shop_owner_overview_computes_metrics_correctly(): void
    {
        $user = User::create([
            'name' => 'Shop Owner',
            'email' => 'shopowner@example.com',
            'password' => bcrypt('password'),
        ]);

        $parent = User::create([
            'name' => 'Parent User',
            'email' => 'parent@example.com',
            'password' => bcrypt('password'),
        ]);

        $shop = Shop::create([
            'user_id' => $user->id,
            'name' => 'Test Shop',
            'slug' => 'test-shop',
            'status' => 'active',
        ]);

        $product1 = Product::create([
            'shop_id' => $shop->id,
            'name' => 'Product 1',
            'slug' => 'product-1',
            'category' => ProductCategory::Newborns,
            'price' => 20.00,
            'stock_qty' => 10,
            'status' => 'published',
        ]);

        $product2 = Product::create([
            'shop_id' => $shop->id,
            'name' => 'Product 2',
            'slug' => 'product-2',
            'category' => ProductCategory::Toddlers,
            'price' => 30.00,
            'stock_qty' => 10,
            'status' => 'published',
        ]);

        ProductReview::create([
            'product_id' => $product1->id,
            'user_id' => $parent->id,
            'rating' => 4,
            'comment' => 'Great product',
        ]);

        ProductReview::create([
            'product_id' => $product2->id,
            'user_id' => $parent->id,
            'rating' => 5,
            'comment' => 'Excellent quality',
        ]);

        $order1 = Order::create([
            'parent_id' => $parent->id,
            'shipping_address' => ['street' => '123 Main St'],
            'payment_method' => 'card',
            'status' => OrderStatus::Delivered,
            'total' => 100.00,
        ]);

        OrderItem::create([
            'order_id' => $order1->id,
            'product_id' => $product1->id,
            'qty' => 5,
            'unit_price' => 20.00,
            'total' => 100.00,
        ]);

        $order2 = Order::create([
            'parent_id' => $parent->id,
            'shipping_address' => ['street' => '123 Main St'],
            'payment_method' => 'card',
            'status' => OrderStatus::Processing,
            'total' => 30.00,
        ]);

        OrderItem::create([
            'order_id' => $order2->id,
            'product_id' => $product2->id,
            'qty' => 1,
            'unit_price' => 30.00,
            'total' => 30.00,
        ]);

        $service = new DashboardService();
        $overview = $service->getShopOwnerOverview($user->id);

        $this->assertEquals($shop->id, $overview['shop']->id);
        $this->assertEquals(2, $overview['total_products']);
        $this->assertEquals(2, $overview['total_orders']);
        $this->assertEquals(0, $overview['pending_orders']);
        $this->assertEquals(100.00, $overview['total_revenue']);
        $this->assertEquals(4.5, $overview['avg_rating']);
        $this->assertEquals(2, $overview['total_reviews']);
        $this->assertCount(2, $overview['recent_orders']);
    }
}
