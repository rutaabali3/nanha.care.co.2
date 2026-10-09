<?php

namespace Tests\Unit;

use App\Enums\ContentStatus;
use App\Enums\OrderStatus;
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

    public function test_get_shop_owner_overview_returns_correct_metrics(): void
    {
        $shopOwner = User::create([
            'name' => 'Shop Owner',
            'email' => 'shopowner@example.com',
            'password' => bcrypt('password'),
        ]);

        $shop = Shop::create([
            'user_id' => $shopOwner->id,
            'name' => 'Test Shop',
            'slug' => 'test-shop',
        ]);

        $product1 = Product::create([
            'shop_id' => $shop->id,
            'name' => 'Product 1',
            'price' => 100.00,
            'stock_qty' => 10,
            'category' => 'newborns',
            'status' => ContentStatus::Published->value,
        ]);

        $product2 = Product::create([
            'shop_id' => $shop->id,
            'name' => 'Product 2',
            'price' => 250.00,
            'stock_qty' => 5,
            'category' => 'toddlers',
            'status' => ContentStatus::Published->value,
        ]);

        $parent = User::create([
            'name' => 'Parent User',
            'email' => 'parent@example.com',
            'password' => bcrypt('password'),
        ]);

        // Pending/Processing order
        $order1 = Order::create([
            'parent_id' => $parent->id,
            'shipping_address' => json_encode(['address' => '123 Street']),
            'payment_method' => 'cod',
            'status' => OrderStatus::Processing->value,
            'total' => 100.00,
        ]);

        OrderItem::create([
            'order_id' => $order1->id,
            'product_id' => $product1->id,
            'qty' => 1,
            'unit_price' => 100.00,
            'total' => 100.00,
        ]);

        // Delivered order
        $order2 = Order::create([
            'parent_id' => $parent->id,
            'shipping_address' => json_encode(['address' => '123 Street']),
            'payment_method' => 'cod',
            'status' => OrderStatus::Delivered->value,
            'total' => 250.00,
        ]);

        OrderItem::create([
            'order_id' => $order2->id,
            'product_id' => $product2->id,
            'qty' => 1,
            'unit_price' => 250.00,
            'total' => 250.00,
        ]);

        // Product reviews
        ProductReview::create([
            'product_id' => $product1->id,
            'user_id' => $parent->id,
            'rating' => 4,
            'comment' => 'Great product!',
        ]);

        ProductReview::create([
            'product_id' => $product2->id,
            'user_id' => $parent->id,
            'rating' => 5,
            'comment' => 'Awesome quality!',
        ]);

        $service = new DashboardService();
        $overview = $service->getShopOwnerOverview((string) $shopOwner->id);

        $this->assertEquals($shop->id, $overview['shop']->id);
        $this->assertEquals(2, $overview['total_products']);
        $this->assertEquals(2, $overview['total_orders']);
        $this->assertEquals(1, $overview['pending_orders']);
        $this->assertEquals(250.00, $overview['total_revenue']);
        $this->assertEquals(4.5, $overview['avg_rating']);
        $this->assertEquals(2, $overview['total_reviews']);
        $this->assertCount(2, $overview['recent_orders']);
    }

    public function test_get_shop_owner_overview_with_no_shop_returns_zeros(): void
    {
        $user = User::create([
            'name' => 'User Without Shop',
            'email' => 'noshop@example.com',
            'password' => bcrypt('password'),
        ]);

        $service = new DashboardService();
        $overview = $service->getShopOwnerOverview((string) $user->id);

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
