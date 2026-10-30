<?php

namespace App\Http\Controllers;

use App\Contracts\IBlogService;
use App\Models\Blog\PostViewLog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function __construct(
        private readonly IBlogService $blogService,
    ) {}

    public function index(Request $request)
    {
        $filters = $request->only(['category', 'search']);
        $posts = $this->blogService->getPosts($filters);

        return view('blog.index', compact('posts', 'filters'));
    }

    public function detail($slug)
    {
        $post = $this->blogService->getBySlug($slug);

        abort_if(! $post, 404);

        PostViewLog::create([
            'blog_post_id' => $post->id,
            'user_id' => auth()->id(),
            'ip_address' => request()->ip(),
            'viewed_at' => now(),
        ]);

        $post->increment('views');

        $relatedPosts = $this->blogService->getRelatedPosts($post);

        return view('blog.detail', compact('post', 'relatedPosts'));
    }

    public function addComment(Request $request, $id)
    {
        abort_if(! auth()->check(), 401);
        abort_if(! auth()->user()->hasRole('parent'), 403);

        $request->validate(['content' => 'required|string|min:3|max:500']);

        $this->blogService->addComment((int) $id, $request->content, auth()->id());

        return back()->with('success', 'Comment posted');
    }
}
