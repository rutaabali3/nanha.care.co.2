<?php

namespace Tests\Unit;

use App\Enums\ContentStatus;
use App\Enums\ProductCategory;
use App\Enums\BlogCategory;
use App\Models\Blog\BlogPost;
use App\Models\Marketplace\Product;
use App\Models\Marketplace\Shop;
use App\Models\User;
use App\Services\ModerationService;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModerationServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);
    }

    public function test_get_queue_eager_loads_relations(): void
    {
        $user = User::create([
            'name' => 'Doctor User',
            'email' => 'doctor@example.com',
            'password' => bcrypt('password'),
            'status' => \App\Enums\UserStatus::Active,
        ]);

        $shopOwner = User::create([
            'name' => 'Shop Owner User',
            'email' => 'shopowner@example.com',
            'password' => bcrypt('password'),
            'status' => \App\Enums\UserStatus::Active,
        ]);

        $shop = Shop::create([
            'user_id' => $shopOwner->id,
            'name' => 'Test Shop',
            'slug' => 'test-shop',
        ]);

        BlogPost::create([
            'doctor_id' => $user->id,
            'title' => 'Blog Post Under Review 1',
            'slug' => 'blog-post-under-review-1',
            'content' => 'Content here',
            'category' => BlogCategory::NewbornCare,
            'status' => ContentStatus::UnderReview,
        ]);

        Product::create([
            'shop_id' => $shop->id,
            'name' => 'Product Under Review 1',
            'price' => 10.00,
            'stock_qty' => 10,
            'category' => ProductCategory::Newborns,
            'status' => ContentStatus::UnderReview,
        ]);

        $service = app(ModerationService::class);

        // Test product queue eager loading
        $productQueue = $service->getQueue('product');
        $this->assertCount(1, $productQueue);
        $firstProduct = $productQueue->first()['item'];
        $this->assertTrue($firstProduct->relationLoaded('shop'));

        // Test blog post queue eager loading
        $blogQueue = $service->getQueue('blog_post');
        $this->assertCount(1, $blogQueue);
        $firstBlog = $blogQueue->first()['item'];
        $this->assertTrue($firstBlog->relationLoaded('doctor'));
    }

    public function test_get_published_eager_loads_relations(): void
    {
        $user = User::create([
            'name' => 'Doctor User 2',
            'email' => 'doctor2@example.com',
            'password' => bcrypt('password'),
            'status' => \App\Enums\UserStatus::Active,
        ]);

        BlogPost::create([
            'doctor_id' => $user->id,
            'title' => 'Published Blog Post',
            'slug' => 'published-blog-post',
            'content' => 'Content here',
            'category' => BlogCategory::NewbornCare,
            'status' => ContentStatus::Published,
        ]);

        $service = app(ModerationService::class);

        $publishedBlogPosts = $service->getPublished('blog_post');
        $this->assertCount(1, $publishedBlogPosts);
        $firstBlog = $publishedBlogPosts->first();
        $this->assertTrue($firstBlog->relationLoaded('doctor'));
    }
}
