@extends('layouts.dashboard')

@section('title', 'Comments')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Comments</h2>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Comment</th>
                        <th>User</th>
                        <th>Post</th>
                        <th>Date</th>
                        <th>Reply</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($comments as $comment)
                        <tr>
                            <td>
                                <p class="mb-0 text-wrap" style="max-width: 300px;">{{ \Illuminate\Support\Str::limit($comment->content, 100) }}</p>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-person-circle fs-5"></i>
                                    <span>{{ $comment->user->name }}</span>
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('doctor.posts.edit', $comment->blogPost->id) }}" class="text-decoration-none small">
                                    {{ \Illuminate\Support\Str::limit($comment->blogPost->title, 40) }}
                                </a>
                            </td>
                            <td class="text-muted small">{{ $comment->created_at->diffForHumans() }}</td>
                            <td>
                                @if($comment->reply)
                                    <span class="badge bg-success">Replied</span>
                                @else
                                    <span class="badge bg-secondary">Pending</span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        Actions
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#replyModal"
                                                    data-comment-id="{{ $comment->id }}"
                                                    data-comment-content="{{ $comment->content }}"
                                                    data-existing-reply="{{ $comment->reply ?? '' }}">
                                                <i class="bi bi-reply me-2"></i>Reply
                                            </button>
                                        </li>
                                        <li>
                                            <form method="POST" action="{{ route('doctor.comments.flag', $comment->id) }}">
                                                @csrf
                                                <button type="submit" class="dropdown-item text-warning">
                                                    <i class="bi bi-flag me-2"></i>Flag
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">No comments yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($comments->hasPages())
        <div class="card-footer bg-white">
            {{ $comments->links() }}
        </div>
    @endif
</div>

<div class="modal fade" id="replyModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="">
                @csrf
                <input type="hidden" name="reply_comment_id" id="reply_comment_id" value="{{ old('reply_comment_id') }}">
                <input type="hidden" name="reply_comment_content" id="reply_comment_content" value="{{ old('reply_comment_content') }}">
                <div class="modal-header">
                    <h5 class="modal-title">Reply to Comment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @if(old('reply_comment_id') && $errors->any())
                        <div class="alert alert-danger py-2">
                            <ul class="mb-0 small">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="mb-3 p-3 bg-light rounded">
                        <p class="mb-0 fw-semibold" id="modalCommentContent"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Your Reply</label>
                        <textarea name="reply" class="form-control @error('reply') is-invalid @enderror" rows="4" required>{{ old('reply') }}</textarea>
                        @error('reply') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-send"></i> Post Reply
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const replyModal = document.getElementById('replyModal');
    replyModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        if (!button) return; // Guard for manual bootstrap show calls
        const commentId = button.getAttribute('data-comment-id');
        const commentContent = button.getAttribute('data-comment-content');
        const existingReply = button.getAttribute('data-existing-reply');
        const form = this.querySelector('form');
        form.action = '{{ route('doctor.comments.reply', 'REPLACE_ID') }}'.replace('REPLACE_ID', commentId);
        document.getElementById('reply_comment_id').value = commentId;
        document.getElementById('reply_comment_content').value = commentContent;
        document.getElementById('modalCommentContent').textContent = commentContent;
        if (existingReply) {
            form.querySelector('textarea[name="reply"]').value = existingReply;
        } else {
            form.querySelector('textarea[name="reply"]').value = '';
        }
    });

    // Reopen modal if validation failed
    @if(old('reply_comment_id'))
        const form = replyModal.querySelector('form');
        form.action = '{{ route('doctor.comments.reply', 'REPLACE_ID') }}'.replace('REPLACE_ID', '{{ old('reply_comment_id') }}');
        document.getElementById('modalCommentContent').textContent = {!! json_encode(old('reply_comment_content')) !!};
        const modal = new bootstrap.Modal(replyModal);
        modal.show();
    @endif
});
</script>
@endpush
