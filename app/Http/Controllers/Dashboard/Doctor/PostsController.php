<?php

namespace App\Http\Controllers\Dashboard\Doctor;

use App\Contracts\IBlogService;
use App\Contracts\IFileUploadService;
use App\Contracts\INotificationService;
use App\Enums\ContentStatus;
use App\Http\Requests\Blog\CreateBlogPostRequest;
use App\Models\Blog\BlogPost;
use Illuminate\Http\Request;

class PostsController
{
    public function __construct(
        protected IBlogService $blogService,
        protected IFileUploadService $fileUploadService,
        protected INotificationService $notificationService,
    ) {}

    public function index(Request $request)
    {
        $status = $request->get('status');
        $posts = $this->blogService->getByDoctor(auth()->id(), $status);

        return view('dashboard.doctor.posts.index', compact('posts', 'status'));
    }

    public function create()
    {
        return view('dashboard.doctor.posts.create');
    }

    public function store(CreateBlogPostRequest $request)
    {
        $userId = auth()->id();

        $coverImage = $this->fileUploadService->save($request->file('cover_image'), 'blog_covers');

        $status = $request->input('action') === 'submit'
            ? ContentStatus::UnderReview
            : ContentStatus::Draft;

        $data = $request->validated();
        $data['cover_image'] = $coverImage;
        $data['status'] = $status;

        $post = $this->blogService->create($data, $userId);

        if ($status === ContentStatus::UnderReview) {
            $this->notificationService->broadcast(
                ['moderator'],
                'New blog post submitted for review: '.$post->title,
                route('moderator.queue.index', ['type' => 'blog_post'])
            );
        }

        $message = $status === ContentStatus::UnderReview
            ? 'Post submitted for review successfully.'
            : 'Post saved as draft successfully.';

        return redirect()->route('doctor.posts.index')->with('success', $message);
    }

    public function edit($id)
    {
        $post = BlogPost::where('doctor_id', auth()->id())->findOrFail($id);

        return view('dashboard.doctor.posts.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $userId = auth()->id();

        if ($request->has('excerpt')) {
            $request->merge(['excerpt' => trim($request->input('excerpt'))]);
        }

        if ($request->has('tags') && is_string($request->input('tags'))) {
            $request->merge([
                'tags' => array_values(array_filter(array_map('trim', explode(',', $request->input('tags'))))),
            ]);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'content' => 'required|string|min:200',
            'excerpt' => 'required|string|max:200',
            'category' => 'required|string',
            'tags' => 'nullable|array|max:10',
        ]);

        if ($request->hasFile('cover_image')) {
            $request->validate(['cover_image' => 'image|mimes:jpeg,png,webp|max:3072']);
            $validated['cover_image'] = $this->fileUploadService->save($request->file('cover_image'), 'blog_covers');
        }

        if ($request->has('action')) {
            $validated['status'] = $request->input('action') === 'submit'
                ? ContentStatus::UnderReview
                : ContentStatus::Draft;
        }

        $this->blogService->update((int) $id, $validated, $userId);

        return redirect()->route('doctor.posts.index')->with('success', 'Post updated successfully.');
    }

    public function destroy($id)
    {
        $post = BlogPost::where('doctor_id', auth()->id())->findOrFail($id);

        if ($post->status !== ContentStatus::Draft) {
            return redirect()->route('doctor.posts.index')
                ->with('error', 'Only draft posts can be deleted.');
        }

        $post->delete();

        return redirect()->route('doctor.posts.index')->with('success', 'Post deleted successfully.');
    }
}
