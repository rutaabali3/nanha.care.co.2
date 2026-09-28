<div class="card h-100 border-0 shadow-sm">
    <div class="card-body text-center">
        <div class="position-relative d-inline-block">
            <img src="{{ $babysitter->avatar ? asset('storage/' . $babysitter->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($babysitter->user->name).'&background=4A9BD5&color=FFFFFF' }}"
                 alt="{{ $babysitter->user->name }}"
                 class="rounded-circle mb-3"
                 style="width: 100px; height: 100px; object-fit: cover;">
        </div>
        <span class="badge rounded-pill mb-2 bg-mint-green text-on-gradient">
            NC-{{ $babysitter->city ?? 'Unknown' }}-{{ $babysitter->id }}
        </span>
        <h5 class="card-title mb-1 text-navy">{{ $babysitter->user->name }}</h5>
        <p class="text-muted small mb-2">
            <i class="bi bi-geo-alt-fill me-1"></i>{{ $babysitter->city ?? 'N/A' }}
        </p>
        @include('partials._star-rating', ['rating' => $babysitter->avgRating])
        <div class="mt-2 mb-3">
            @if(isset($babysitter->specializations) && count($babysitter->specializations))
                @foreach(array_slice($babysitter->specializations, 0, 3) as $spec)
                    <span class="badge me-1 mb-1 bg-sky-blue text-on-gradient">{{ $spec }}</span>
                @endforeach
                @if(count($babysitter->specializations) > 3)
                    <span class="badge bg-secondary">+{{ count($babysitter->specializations) - 3 }}</span>
                @endif
            @endif
        </div>
        <p class="fw-bold mb-3 text-dark" style="font-size: 1.1rem;">
            PKR {{ number_format($babysitter->hourly_rate, 0) }}/hr
        </p>
        <a href="{{ route('babysitters.profile', $babysitter->id) }}" class="btn btn-primary w-100">
            View Profile
        </a>
    </div>
</div>
