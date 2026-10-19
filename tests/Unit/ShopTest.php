<?php

namespace Tests\Unit;

use App\Enums\ContentStatus;
use App\Enums\ProductCategory;
use App\Models\Marketplace\Product;
use App\Models\Marketplace\ProductReview;
use App\Models\Marketplace\Shop;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShopTest extends TestCase
{
    use RefreshDatabase;

    public function test_average_rating_returns_zero_when_no_reviews(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $shop = Shop::create([
            'user_id' => $user->id,
            'name' => 'Test Shop',
            'slug' => 'test-shop',
        ]);

        $this->assertEquals(0, $shop->averageRating());
    }

    public function test_average_rating_calculates_correctly(): void
    {
        $user = User::create([
            'name' => 'Test User 2',
            'email' => 'test2@example.com',
            'password' => bcrypt('password'),
        ]);

        $shop = Shop::create([
            'user_id' => $user->id,
            'name' => 'Test Shop 2',
            'slug' => 'test-shop-2',
        ]);

        $product1 = Product::create([
            'shop_id' => $shop->id,
            'name' => 'Product 1',
            'price' => 100,
            'stock_qty' => 10,
            'category' => ProductCategory::Newborns,
            'status' => ContentStatus::Published,
        ]);

        $product2 = Product::create([
            'shop_id' => $shop->id,
            'name' => 'Product 2',
            'price' => 200,
            'stock_qty' => 5,
            'category' => ProductCategory::Toddlers,
            'status' => ContentStatus::Published,
        ]);

        ProductReview::create([
            'product_id' => $product1->id,
            'user_id' => $user->id,
            'rating' => 5,
            'comment' => 'Great product!',
            'status' => 'approved',
        ]);

        ProductReview::create([
            'product_id' => $product2->id,
            'user_id' => $user->id,
            'rating' => 3,
            'comment' => 'Okay product.',
            'status' => 'approved',
        ]);

        $this->assertEquals(4.0, $shop->averageRating());
    }
}
