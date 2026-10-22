<?php

namespace Tests\Unit;

use App\Contracts\INotificationService;
use App\Enums\BlogCategory;
use App\Enums\ContentStatus;
use App\Enums\ProductCategory;
use App\Models\Blog\BlogPost;
use App\Models\Marketplace\Product;
use App\Models\Marketplace\Shop;
use App\Models\Profiles\BabysitterProfile;
use App\Models\User;
use App\Services\ModerationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModerationServiceTest extends TestCase
{
    use RefreshDatabase;

    private ModerationService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $notificationMock = $this->createMock(INotificationService::class);
        $this->service = new ModerationService($notificationMock);
    }

    public function test_get_queue_eager_loads_relations_for_under_review_content(): void
    {
        $user = User::create([
            'name' => 'Doctor User',
            'email' => 'doctor@example.com',
            'password' => bcrypt('password'),
        ]);

        $post = BlogPost::create([
            'doctor_id' => $user->id,
            'title' => 'Test Post',
            'slug' => 'test-post',
            'content' => 'Content',
            'category' => BlogCategory::NewbornCare,
            'status' => ContentStatus::UnderReview,
        ]);

        $shop = Shop::create([
            'user_id' => $user->id,
            'name' => 'Test Shop',
            'slug' => 'test-shop',
        ]);

        $product = Product::create([
            'shop_id' => $shop->id,
            'name' => 'Test Product',
            'description' => 'Desc',
            'price' => 100,
            'stock_qty' => 10,
            'category' => ProductCategory::Newborns,
            'status' => ContentStatus::UnderReview,
        ]);

        $queue = $this->service->getQueue();

        $this->assertCount(2, $queue);

        $productItem = $queue->firstWhere('type', 'product')['item'];
        $postItem = $queue->firstWhere('type', 'blog_post')['item'];

        $this->assertTrue($productItem->relationLoaded('shop'));
        $this->assertTrue($productItem->shop->relationLoaded('owner'));
        $this->assertTrue($postItem->relationLoaded('doctor'));
    }

    public function test_get_published_eager_loads_relations(): void
    {
        $user = User::create([
            'name' => 'Doctor User',
            'email' => 'doctor2@example.com',
            'password' => bcrypt('password'),
        ]);

        $post = BlogPost::create([
            'doctor_id' => $user->id,
            'title' => 'Published Post',
            'slug' => 'published-post',
            'content' => 'Content',
            'category' => BlogCategory::NewbornCare,
            'status' => ContentStatus::Published,
            'published_at' => now(),
        ]);

        $published = $this->service->getPublished('blog_post');

        $this->assertCount(1, $published);
        $item = $published->first();

        $this->assertTrue($item->relationLoaded('doctor'));
        $this->assertEquals('Doctor User', $item->doctor->name);
    }
}
