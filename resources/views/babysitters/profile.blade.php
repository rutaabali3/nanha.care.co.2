@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/babysitters.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container py-5">
    <a href="{{ route('babysitters.index') }}" class="btn btn-outline-secondary mb-4">
        <i class="bi bi-arrow-left me-1"></i> Back to Babysitters
    </a>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card shadow-sm border-0" style="background-color: var(--off-white);">
                <div class="card-body text-center p-4">
                    <div class="mx-auto mb-3 rounded-circle overflow-hidden" style="width: 150px; height: 150px; background-color: #dee2e6;">
                        @if($babysitter->user && $babysitter->user->avatar)
                        <img src="{{ asset('storage/' . $babysitter->user->avatar) }}" alt="{{ $babysitter->user->name }}" class="w-100 h-100" style="object-fit: cover;">
                        @else
                        <div class="d-flex align-items-center justify-content-center h-100">
                            <i class="bi bi-person" style="font-size: 4rem; color: #adb5bd;"></i>
                        </div>
                        @endif
                    </div>
                    <h4 class="fw-bold mb-0 text-navy">{{ $babysitter->user->name ?? 'Babysitter' }}</h4>
                    <p class="text-muted mb-2">
                        <i class="bi bi-geo-alt me-1"></i> {{ $babysitter->city ?? 'N/A' }}
                    </p>
                    <span class="badge rounded-pill px-3 py-2 mb-3 bg-mint-green text-on-gradient">
                        NC-{{ $babysitter->city ?? 'N/A' }}-{{ $babysitter->id }}
                    </span>
                    <h5 class="fw-bold mt-2 text-navy">
                        Rs. {{ number_format($babysitter->hourly_rate, 0) }}/hr
                    </h5>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-4" style="background-color: var(--off-white);">
                <div class="card-body p-4">
                    <div class="row text-center g-3">
                        <div class="col-6 col-md-3">
                            <h5 class="fw-bold mb-0 text-navy">{{ $babysitter->experience_years ?? 'N/A' }}</h5>
                            <small class="text-muted">Years Exp.</small>
                        </div>
                        <div class="col-6 col-md-3">
                            <h5 class="fw-bold mb-0 text-navy">{{ $babysitter->bookings_count ?? 0 }}</h5>
                            <small class="text-muted">Bookings</small>
                        </div>
                        <div class="col-6 col-md-3">
                            <h5 class="fw-bold mb-0 text-navy">
                                @if($babysitter->response_time)
                                {{ $babysitter->response_time }}
                                @else
                                &lt; 1hr
                                @endif
                            </h5>
                            <small class="text-muted">Response Time</small>
                        </div>
                        <div class="col-6 col-md-3">
                            <h5 class="fw-bold mb-0 text-navy">
                                @if($babysitter->created_at)
                                {{ $babysitter->created_at->format('M Y') }}
                                @else
                                N/A
                                @endif
                            </h5>
                            <small class="text-muted">Member Since</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-4" style="background-color: var(--off-white);">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3 text-navy">About</h5>
                    <p class="text-dark">{{ $babysitter->experience ?? 'No description provided.' }}</p>
                </div>
            </div>

            @if($babysitter->specializations && count($babysitter->specializations) > 0)
            <div class="card shadow-sm border-0 mb-4" style="background-color: var(--off-white);">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3 text-navy">Specializations</h5>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($babysitter->specializations as $spec)
                        <span class="badge rounded-pill px-3 py-2 bg-sky-blue text-on-gradient">
                            {{ $spec->name ?? $spec }}
                        </span>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <div class="card shadow-sm border-0 mb-4" style="background-color: var(--off-white);">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3 text-navy">Reviews from Parents</h5>
                    @php $reviews = $babysitter->reviews ?? $reviews ?? collect(); @endphp
                    @if($reviews->count() > 0)
                        @foreach($reviews as $review)
                        <div class="border-bottom pb-3 mb-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="fw-semibold mb-0 text-navy">{{ $review->reviewer_name ?? 'Anonymous' }}</h6>
                                    <small class="text-muted">{{ $review->created_at ? $review->created_at->format('M d, Y') : '' }}</small>
                                </div>
                                @include('partials._star-rating', ['rating' => $review->rating])
                            </div>
                            <p class="mt-2 mb-0">{{ $review->comment ?? '' }}</p>
                        </div>
                        @endforeach
                    @else
                        <p class="text-muted mb-0">No reviews yet</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="d-md-none fixed-bottom p-3" style="background-color: var(--white); border-top: 1px solid #dee2e6;">
    @auth
        @if(!auth()->user()->hasCompletedOnboarding())
        <a href="{{ auth()->user()->onboardingRoute() }}" class="btn btn-primary w-100 py-2" style="font-weight: 600;">
            Complete registration
        </a>
        @else
        <a href="#" class="btn btn-primary w-100 py-2" style="font-weight: 600;">
            <i class="bi bi-calendar-check me-1"></i> Book Now
        </a>
        @endif
    @else
    <a href="#" class="btn btn-primary w-100 py-2" style="font-weight: 600;">
        <i class="bi bi-calendar-check me-1"></i> Book Now
    </a>
    @endauth
</div>

<div class="d-none d-md-block text-center mt-3 mb-5">
    @auth
        @if(!auth()->user()->hasCompletedOnboarding())
        <a href="{{ auth()->user()->onboardingRoute() }}" class="btn btn-primary btn-lg px-5 py-2" style="font-weight: 600;">
            Complete registration
        </a>
        @else
        <a href="#" class="btn btn-primary btn-lg px-5 py-2" style="font-weight: 600;">
            <i class="bi bi-calendar-check me-1"></i> Book Now
        </a>
        @endif
    @else
    <a href="#" class="btn btn-primary btn-lg px-5 py-2" style="font-weight: 600;">
        <i class="bi bi-calendar-check me-1"></i> Book Now
    </a>
    @endauth
</div>
@endsection
