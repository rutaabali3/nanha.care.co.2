<?php

namespace Tests\Unit;

use App\Helpers\SlugHelper;
use App\Models\Blog\BlogPost;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SlugHelperTest extends TestCase
{
    use RefreshDatabase;

    public function test_generate_from_title_returns_slugified_string(): void
    {
        $slug = SlugHelper::generateFromTitle('Hello World 123!');
        $this->assertEquals('hello-world-123', $slug);
    }

    public function test_unique_generates_unique_slug_without_collision(): void
    {
        $slug = SlugHelper::unique(BlogPost::class, 'Unique Post Title');
        $this->assertEquals('unique-post-title', $slug);
    }

    public function test_unique_resolves_collisions_with_counter_in_single_query(): void
    {
        $user = User::create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'name' => 'Doctor User',
            'email' => 'doctor@example.com',
            'password' => 'password',
        ]);

        BlogPost::create([
            'doctor_id' => $user->id,
            'title' => 'Sample Post',
            'slug' => 'sample-post',
            'content' => 'Content',
            'category' => 'newborn_care',
            'status' => 'published',
        ]);

        BlogPost::create([
            'doctor_id' => $user->id,
            'title' => 'Sample Post',
            'slug' => 'sample-post-1',
            'content' => 'Content',
            'category' => 'newborn_care',
            'status' => 'published',
        ]);

        $slug = SlugHelper::unique(BlogPost::class, 'Sample Post');
        $this->assertEquals('sample-post-2', $slug);
    }

    public function test_unique_ignores_current_id_when_updating(): void
    {
        $user = User::create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'name' => 'Doctor User',
            'email' => 'doctor2@example.com',
            'password' => 'password',
        ]);

        $post = BlogPost::create([
            'doctor_id' => $user->id,
            'title' => 'Existing Post',
            'slug' => 'existing-post',
            'content' => 'Content',
            'category' => 'newborn_care',
            'status' => 'published',
        ]);

        $slug = SlugHelper::unique(BlogPost::class, 'Existing Post', $post->id);
        $this->assertEquals('existing-post', $slug);
    }

    public function test_generate_helper_using_db_table(): void
    {
        $user = User::create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'name' => 'Doctor User 3',
            'email' => 'doctor3@example.com',
            'password' => 'password',
        ]);

        BlogPost::create([
            'doctor_id' => $user->id,
            'title' => 'Table Post',
            'slug' => 'table-post',
            'content' => 'Content',
            'category' => 'newborn_care',
            'status' => 'published',
        ]);

        $slug = SlugHelper::generate('Table Post', 'blog_posts');
        $this->assertEquals('table-post-1', $slug);
    }
}
