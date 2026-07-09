@php
    $userId = auth()->id();
    $unreadCount = \Illuminate\Support\Facades\Cache::remember("notifications.unread.$userId", 60, function () use ($userId) {
        return \App\Models\Notification::where('user_id', $userId)->where('is_read', false)->count();
    });
    $recentNotifications = \Illuminate\Support\Facades\Cache::remember("notifications.recent.$userId", 60, function () use ($userId) {
        return \App\Models\Notification::where('user_id', $userId)->where('is_read', false)->latest()->take(10)->get();
    });
@endphp
<div class="dropdown">
    <button class="btn position-relative" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="background: transparent; border: none;">
        <i class="bi bi-bell fs-5 text-dark"></i>
        @if($unreadCount > 0)
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                {{ $unreadCount > 99 ? '99+' : $unreadCount }}
            </span>
        @endif
    </button>
    <ul class="dropdown-menu dropdown-menu-end" style="width: 320px;">
        <li><h6 class="dropdown-header">Notifications</h6></li>
        @forelse($recentNotifications as $notification)
            <li>
                <a class="dropdown-item d-flex align-items-start gap-2" href="{{ route('notifications.mark-read', $notification->id) }}" style="white-space: normal;">
                    <span class="mt-1">
                        <span class="badge rounded-pill bg-sky-blue" style="width: 8px; height: 8px; display: inline-block; padding: 0;"></span>
                    </span>
                    <div>
                        <p class="mb-0 small">{{ $notification->message }}</p>
                        <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                    </div>
                </a>
            </li>
        @empty
            <li><span class="dropdown-item-text text-muted small">No new notifications</span></li>
        @endforelse
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item text-center small" href="{{ route('notifications.index') }}">View all notifications</a></li>
    </ul>
</div>
