@extends('layouts.dashboard')

@section('title', 'Reviews')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="mb-0">Reviews</h4>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <ul class="list-group list-group-flush">
                @forelse($reviews as $review)
                    <li class="list-group-item py-4">
                        <div class="d-flex align-items-start justify-content-between">
                            <div>
                                <p class="mb-0 fw-semibold">{{ $review->parent->name ?? 'Anonymous' }}</p>
                                <small class="text-muted">{{ $review->created_at->format('M d, Y') }}</small>
                                <div class="mt-1">
                                    @include('partials._star-rating', ['rating' => $review->rating])
                                </div>
                            </div>
                            @if(!$review->reply)
                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#replyModal{{ $review->id }}">
                                    <i class="bi bi-reply"></i> Reply
                                </button>
                            @else
                                <span class="badge bg-light text-muted"><i class="bi bi-check2"></i> Replied</span>
                            @endif
                        </div>
                        @if($review->comment)
                            <p class="mb-0 mt-2">{{ $review->comment }}</p>
                        @endif
                        @if($review->reply)
                            <div class="mt-2 p-3 rounded" style="background-color: var(--off-white);">
                                <small class="fw-semibold">Your Reply:</small>
                                <p class="mb-0 small">{{ $review->reply }}</p>
                            </div>
                        @endif
                    </li>

                    <div class="modal fade" id="replyModal{{ $review->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <form method="POST" action="{{ route('babysitter.reviews.reply', $review->id) }}">
                                @csrf
                                <input type="hidden" name="reply_review_id" value="{{ $review->id }}">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Reply to Review</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        @if(old('reply_review_id') == $review->id && $errors->any())
                                            <div class="alert alert-danger py-2">
                                                <ul class="mb-0 small">
                                                    @foreach($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        <div class="mb-3">
                                            @include('partials._star-rating', ['rating' => $review->rating])
                                            <p class="mt-1 mb-0 text-muted">{{ $review->comment }}</p>
                                        </div>
                                        <label for="reply" class="form-label">Your Reply</label>
                                        <textarea name="reply" id="reply" class="form-control @if(old('reply_review_id') == $review->id) @error('reply') is-invalid @enderror @endif" rows="4" required>{{ old('reply_review_id') == $review->id ? old('reply') : '' }}</textarea>
                                        @if(old('reply_review_id') == $review->id)
                                            @error('reply') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        @endif
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Submit Reply</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @empty
                    <li class="list-group-item text-center py-5">
                        <i class="bi bi-star fs-1 text-muted"></i>
                        <p class="text-muted mt-2 mb-0">No reviews yet</p>
                    </li>
                @endforelse
            </ul>
        </div>
        @if($reviews->hasPages())
            <div class="card-footer bg-white border-0">
                {{ $reviews->links() }}
            </div>
        @endif
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(old('reply_review_id'))
            var replyModal = new bootstrap.Modal('#replyModal' + '{{ old('reply_review_id') }}');
            replyModal.show();
        @endif
    });
</script>
@endpush
