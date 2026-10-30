<?php

namespace App\Contracts;

use App\Models\Blog\BlogPost;
use App\Models\Blog\Comment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface IBlogService
{
    public function getPosts(array $filters): LengthAwarePaginator;

    public function getBySlug(string $slug): BlogPost;

    public function getByDoctor(string $userId, ?string $status): LengthAwarePaginator;

    public function create(array $data, string $userId): BlogPost;

    public function update(int $id, array $data, string $userId): BlogPost;

    public function addComment(int $postId, string $content, string $userId): Comment;

    public function getRelatedPosts(BlogPost $post, int $limit = 3): Collection;
}
