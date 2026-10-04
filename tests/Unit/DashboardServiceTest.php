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
use Illuminate\Support\Str;
use Tests\TestCase;

class DashboardServiceTest extends TestCase
{
    use RefreshDatabase;

    private function createUser(): User
    {
        return User::create([
            'id' => (string) Str::uuid(),
            'name' => 'Test User',
            'email' => 'test' . Str::random(5) . '@example.com',
            'password' => bcrypt('password'),
        ]);
    }

    public function test_get_shop_owner_overview_returns_correct_data()
    {
        $user = $this->createUser();
        $shop = Shop::create([
            'user_id' => $user->id,
            'name' => 'Test Shop',
            'slug' => 'test-shop',
        ]);

        $product1 = Product::create([
            'shop_id' => $shop->id,
            'name' => 'Product 1',
            'category' => ProductCategory::Newborns,
            'price' => 100,
            'stock_qty' => 10,
        ]);

        $product2 = Product::create([
            'shop_id' => $shop->id,
            'name' => 'Product 2',
            'category' => ProductCategory::Toddlers,
            'price' => 200,
            'stock_qty' => 10,
        ]);

        $parent = $this->createUser();

        $order1 = Order::create([
            'parent_id' => $parent->id,
            'status' => OrderStatus::Processing,
            'total' => 100,
            'shipping_address' => ['street' => '123 St'],
            'payment_method' => 'cod',
        ]);

        OrderItem::create([
            'order_id' => $order1->id,
            'product_id' => $product1->id,
            'qty' => 1,
            'unit_price' => 100,
            'total' => 100,
        ]);

        $order2 = Order::create([
            'parent_id' => $parent->id,
            'status' => OrderStatus::Delivered,
            'total' => 200,
            'shipping_address' => ['street' => '123 St'],
            'payment_method' => 'cod',
        ]);

        OrderItem::create([
            'order_id' => $order2->id,
            'product_id' => $product2->id,
            'qty' => 1,
            'unit_price' => 200,
            'total' => 200,
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
            'comment' => 'Awesome',
        ]);

        $service = new DashboardService();
        $overview = $service->getShopOwnerOverview($user->id);

        $this->assertEquals($shop->id, $overview['shop']->id);
        $this->assertEquals(2, $overview['total_products']);
        $this->assertEquals(2, $overview['total_orders']);
        $this->assertEquals(0, $overview['pending_orders']);
        $this->assertEquals(200.0, $overview['total_revenue']);
        $this->assertEquals(4.5, $overview['avg_rating']);
        $this->assertEquals(2, $overview['total_reviews']);
        $this->assertCount(2, $overview['recent_orders']);
    }

    public function test_get_shop_owner_overview_when_no_shop()
    {
        $user = $this->createUser();
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
}
