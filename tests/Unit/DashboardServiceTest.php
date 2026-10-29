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

    public function test_get_shop_owner_overview_returns_correct_data(): void
    {
        $user = User::create([
            'name' => 'Owner',
            'email' => 'owner@example.com',
            'password' => bcrypt('password'),
        ]);

        $shop = Shop::create([
            'user_id' => $user->id,
            'name' => 'Test Shop',
            'slug' => 'test-shop',
            'status' => 'approved',
        ]);

        $product1 = Product::create([
            'shop_id' => $shop->id,
            'name' => 'Product 1',
            'slug' => 'product-1',
            'price' => 100,
            'stock_qty' => 10,
            'status' => 'published',
            'category' => ProductCategory::Newborns,
        ]);

        $product2 = Product::create([
            'shop_id' => $shop->id,
            'name' => 'Product 2',
            'slug' => 'product-2',
            'price' => 50,
            'stock_qty' => 5,
            'status' => 'published',
            'category' => ProductCategory::Toddlers,
        ]);

        $buyer = User::create([
            'name' => 'Buyer',
            'email' => 'buyer@example.com',
            'password' => bcrypt('password'),
        ]);

        // Order 1: delivered
        $order1 = Order::create([
            'parent_id' => $buyer->id,
            'order_number' => 'ORD-101',
            'total' => 150,
            'status' => OrderStatus::Delivered,
            'shipping_address' => '123 St',
            'payment_method' => 'cod',
            'payment_status' => 'paid',
        ]);
        OrderItem::create([
            'order_id' => $order1->id,
            'product_id' => $product1->id,
            'qty' => 1,
            'unit_price' => 100,
            'total' => 100,
        ]);
        OrderItem::create([
            'order_id' => $order1->id,
            'product_id' => $product2->id,
            'qty' => 1,
            'unit_price' => 50,
            'total' => 50,
        ]);

        // Order 2: processing
        $order2 = Order::create([
            'parent_id' => $buyer->id,
            'order_number' => 'ORD-102',
            'total' => 100,
            'status' => OrderStatus::Processing,
            'shipping_address' => '123 St',
            'payment_method' => 'cod',
            'payment_status' => 'pending',
        ]);
        OrderItem::create([
            'order_id' => $order2->id,
            'product_id' => $product1->id,
            'qty' => 1,
            'unit_price' => 100,
            'total' => 100,
        ]);

        // Reviews
        ProductReview::create([
            'product_id' => $product1->id,
            'user_id' => $buyer->id,
            'rating' => 5,
            'comment' => 'Great product!',
        ]);
        ProductReview::create([
            'product_id' => $product2->id,
            'user_id' => $buyer->id,
            'rating' => 3,
            'comment' => 'Average product.',
        ]);

        $service = new DashboardService;
        $overview = $service->getShopOwnerOverview((string) $user->id);

        $this->assertEquals($shop->id, $overview['shop']->id);
        $this->assertEquals(2, $overview['total_products']);
        $this->assertEquals(2, $overview['total_orders']);
        $this->assertEquals(0, $overview['pending_orders']); // status 'pending' is what original code checked
        $this->assertEquals(150.0, $overview['total_revenue']);
        $this->assertEquals(4.0, $overview['avg_rating']);
        $this->assertEquals(2, $overview['total_reviews']);
        $this->assertCount(2, $overview['recent_orders']);
    }

    public function test_get_shop_owner_overview_when_no_shop(): void
    {
        $user = User::create([
            'name' => 'Owner',
            'email' => 'owner2@example.com',
            'password' => bcrypt('password'),
        ]);

        $service = new DashboardService;
        $overview = $service->getShopOwnerOverview((string) $user->id);

        $this->assertNull($overview['shop']);
        $this->assertEquals(0, $overview['total_products']);
        $this->assertEquals(0, $overview['total_orders']);
        $this->assertEquals(0, $overview['pending_orders']);
        $this->assertEquals(0, $overview['total_revenue']);
        $this->assertEquals(0, $overview['avg_rating']);
        $this->assertEquals(0, $overview['total_reviews']);
        $this->assertEmpty($overview['recent_orders']);
    }
}
