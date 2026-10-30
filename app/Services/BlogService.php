<?php

namespace App\Services;

use App\Contracts\IBlogService;
use App\Enums\ContentStatus;
use App\Helpers\SlugHelper;
use App\Models\Blog\BlogPost;
use App\Models\Blog\Comment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class BlogService implements IBlogService
{
    public function getPosts(array $filters): LengthAwarePaginator
    {
        $query = BlogPost::with('doctor')->where('status', ContentStatus::Published);

        if (! empty($filters['category'])) {
            $query->where('category', $filters['category']);
        }
        if (! empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('title', 'like', '%'.$filters['search'].'%')
                    ->orWhere('content', 'like', '%'.$filters['search'].'%');
            });
        }

        return $query->orderByDesc('published_at')->paginate(9);
    }

    public function getBySlug(string $slug): BlogPost
    {
        return BlogPost::with('doctor.doctorProfile', 'comments.user')
            ->where('slug', $slug)
            ->where('status', ContentStatus::Published)
            ->firstOrFail();
    }

    public function getByDoctor(string $userId, ?string $status): LengthAwarePaginator
    {
        $query = BlogPost::with('doctor')->where('doctor_id', $userId);
        if ($status) {
            $query->where('status', $status);
        }

        return $query->orderByDesc('created_at')->paginate(10);
    }

    public function create(array $data, string $userId): BlogPost
    {
        $data['slug'] = SlugHelper::unique(BlogPost::class, $data['title']);
        $data['doctor_id'] = $userId;

        return BlogPost::create($data);
    }

    public function update(int $id, array $data, string $userId): BlogPost
    {
        $post = BlogPost::where('doctor_id', $userId)->findOrFail($id);
        if (isset($data['title']) && $data['title'] !== $post->title) {
            $data['slug'] = SlugHelper::unique(BlogPost::class, $data['title'], $id);
        }
        $post->update($data);

        return $post->fresh();
    }

    public function addComment(int $postId, string $content, string $userId): Comment
    {
        return Comment::create([
            'blog_post_id' => $postId,
            'user_id' => $userId,
            'content' => $content,
        ]);
    }

    public function getRelatedPosts(BlogPost $post, int $limit = 3): Collection
    {
        return BlogPost::with('doctor')
            ->where('status', ContentStatus::Published)
            ->where('id', '!=', $post->id)
            ->where('category', $post->category)
            ->inRandomOrder()
            ->limit($limit)
            ->get();
    }
}
