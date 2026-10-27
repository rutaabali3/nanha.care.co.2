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

class DashboardServiceTest extends \Tests\TestCase
{
    use RefreshDatabase;

    private function createUser(array $attributes = []): User
    {
        return User::create(array_merge([
            'name' => 'Test User',
            'email' => 'user_' . uniqid() . '@example.com',
            'password' => bcrypt('password'),
        ], $attributes));
    }

    public function test_get_shop_owner_overview_returns_correct_stats(): void
    {
        $user = $this->createUser(['name' => 'Shop Owner']);
        $shop = Shop::create([
            'user_id' => $user->id,
            'name' => 'Test Shop',
            'slug' => 'test-shop',
            'description' => 'A test shop',
        ]);

        $product1 = Product::create([
            'shop_id' => $shop->id,
            'name' => 'Product 1',
            'price' => 10.00,
            'stock_qty' => 50,
            'category' => ProductCategory::Newborns->value,
            'status' => 'published',
        ]);

        $product2 = Product::create([
            'shop_id' => $shop->id,
            'name' => 'Product 2',
            'price' => 20.00,
            'stock_qty' => 30,
            'category' => ProductCategory::Toddlers->value,
            'status' => 'published',
        ]);

        $parent = $this->createUser(['name' => 'Parent User']);

        // Order 1: Delivered
        $order1 = Order::create([
            'parent_id' => $parent->id,
            'shipping_address' => '123 Main St',
            'payment_method' => 'card',
            'status' => OrderStatus::Delivered->value,
            'total' => 30.00,
        ]);
        OrderItem::create([
            'order_id' => $order1->id,
            'product_id' => $product1->id,
            'qty' => 1,
            'unit_price' => 10.00,
            'total' => 10.00,
        ]);

        // Order 2: Pending
        $order2 = Order::create([
            'parent_id' => $parent->id,
            'shipping_address' => '123 Main St',
            'payment_method' => 'card',
            'status' => OrderStatus::Processing->value,
            'total' => 20.00,
        ]);
        OrderItem::create([
            'order_id' => $order2->id,
            'product_id' => $product2->id,
            'qty' => 1,
            'unit_price' => 20.00,
            'total' => 20.00,
        ]);

        // Force order 2 status in DB to 'pending' as expected by getShopOwnerOverview
        \Illuminate\Support\Facades\DB::table('orders')->where('id', $order2->id)->update(['status' => 'pending']);

        // Product reviews
        ProductReview::create([
            'product_id' => $product1->id,
            'user_id' => $parent->id,
            'rating' => 4,
            'comment' => 'Great product',
            'status' => 'approved',
        ]);
        ProductReview::create([
            'product_id' => $product2->id,
            'user_id' => $parent->id,
            'rating' => 5,
            'comment' => 'Excellent',
            'status' => 'approved',
        ]);

        $service = new DashboardService();
        $overview = $service->getShopOwnerOverview((string) $user->id);

        $this->assertEquals($shop->id, $overview['shop']->id);
        $this->assertEquals(2, $overview['total_products']);
        $this->assertEquals(2, $overview['total_orders']);
        $this->assertEquals(1, $overview['pending_orders']);
        $this->assertEquals(30.00, $overview['total_revenue']);
        $this->assertEquals(4.5, $overview['avg_rating']);
        $this->assertEquals(2, $overview['total_reviews']);
        $this->assertCount(2, $overview['recent_orders']);
    }
}
