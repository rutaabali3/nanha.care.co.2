@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/notifications.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0" style="color: var(--dark-text);"><i class="bi bi-bell"></i> Notifications</h2>
        @if($notifications->where('is_read', false)->count() > 0)
        <form method="POST" action="{{ route('notifications.mark-all-read') }}">
            @csrf
            <button type="submit" class="btn btn-outline-primary btn-sm"><i class="bi bi-check-all"></i> Mark All as Read</button>
        </form>
        @endif
    </div>

    @if($notifications->count() > 0)
    <div class="d-flex flex-column gap-2">
        @foreach($notifications as $notification)
        <a href="{{ route('notifications.mark-read', $notification->id) }}" class="text-decoration-none">
            <div class="card shadow-sm border-0 notification-item {{ $notification->is_read ? '' : 'border-start border-primary border-4' }}" style="transition: all 0.2s;">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 40px; height: 40px; background-color: {{ $notification->is_read ? 'var(--off-white)' : 'var(--sky-blue)' }};">
                            @if($notification->is_read)
                            <i class="bi bi-bell-check" style="color: var(--mint-green);"></i>
                            @else
                            <i class="bi bi-bell-info" style="color: var(--white);"></i>
                            @endif
                        </div>
                        <div class="flex-grow-1">
                            <p class="mb-0 fw-semibold" style="color: var(--dark-text);">{{ $notification->type }}</p>
                            <small class="text-muted">{{ $notification->message }}</small>
                            <br>
                            <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                        </div>
                        <div>
                            @if($notification->is_read)
                            <i class="bi bi-circle-fill" style="color: #ccc; font-size: 0.5rem;"></i>
                            @else
                            <i class="bi bi-circle-fill" style="color: var(--sky-blue); font-size: 0.5rem;"></i>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    <div class="mt-4">
        @include('partials._pagination', ['paginator' => $notifications])
    </div>
    @else
    <div class="text-center py-5">
        <i class="bi bi-bell-slash" style="font-size: 5rem; color: var(--sky-blue);"></i>
        <h4 class="mt-3 fw-semibold" style="color: var(--dark-text);">No notifications yet</h4>
        <p class="text-muted">You're all caught up!</p>
    </div>
    @endif
</div>
@endsection
