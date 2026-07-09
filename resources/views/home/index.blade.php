@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
@endpush

@section('title', 'Home')

@section('content')

<section class="bg-gradient-hero text-on-gradient py-5">
    <div class="container text-center py-4">
        <h1 class="fw-bold display-5 mb-3 text-on-gradient">Find Trusted & Verified Babysitters in Pakistan</h1>
        <p class="lead mb-4" style="color: rgba(255,255,255,0.85);">Safe, reliable childcare at your fingertips</p>
        <div class="d-flex justify-content-center gap-3">
            <a href="{{ route('babysitters.index') }}" class="btn btn-primary btn-lg px-4">Find a Babysitter</a>
            <a href="{{ route('auth.register') }}" class="btn btn-outline-light btn-lg px-4">Become a Babysitter</a>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <h2 class="text-center fw-bold mb-5 text-navy">Why NanhaCare is Trusted</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <div class="card-body">
                        <i class="bi bi-shield-check display-4 mb-3 text-mint-green"></i>
                        <h5 class="fw-bold text-navy">Triple-Verified</h5>
                        <p class="text-muted mb-0">Every babysitter passes CNIC, police clearance, and in-person interview verification.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <div class="card-body">
                        <i class="bi bi-star display-4 mb-3 text-sunshine-yellow"></i>
                        <h5 class="fw-bold text-navy">Ratings & Reviews</h5>
                        <p class="text-muted mb-0">Real feedback from real families helps you choose with confidence.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <div class="card-body">
                        <i class="bi bi-telephone display-4 mb-3 text-baby-pink"></i>
                        <h5 class="fw-bold text-navy">Emergency Response System</h5>
                        <p class="text-muted mb-0">24/7 emergency hotline and in-app support for immediate assistance.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-light-bg">
    <div class="container">
        <h2 class="text-center fw-bold mb-5 text-navy">How It Works</h2>
        <div class="row g-4">
            <div class="col-md-4 text-center">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3 bg-sky-blue text-on-gradient" style="width: 60px; height: 60px; font-size: 1.5rem; font-weight: 700;">
                    <i class="bi bi-search"></i>
                </div>
                <h5 class="fw-bold text-navy">Search</h5>
                <p class="text-muted">Browse verified babysitters near you with detailed profiles and reviews.</p>
            </div>
            <div class="col-md-4 text-center">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3 bg-mint-green text-on-gradient" style="width: 60px; height: 60px; font-size: 1.5rem; font-weight: 700;">
                    <i class="bi bi-check2-circle"></i>
                </div>
                <h5 class="fw-bold text-navy">Verify</h5>
                <p class="text-muted">Check their ratings, background checks, and read parent reviews.</p>
            </div>
            <div class="col-md-4 text-center">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3 bg-coral text-on-gradient" style="width: 60px; height: 60px; font-size: 1.5rem; font-weight: 700;">
                    <i class="bi bi-calendar-check"></i>
                </div>
                <h5 class="fw-bold text-navy">Book</h5>
                <p class="text-muted">Book instantly or schedule for later with secure online payment.</p>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <h2 class="text-center fw-bold mb-5 text-navy">Our Verification Process</h2>
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm text-center p-3">
                    <div class="card-body">
                        <i class="bi bi-person-badge display-5 mb-3 text-sky-blue"></i>
                        <h6 class="fw-bold text-navy">CNIC Check</h6>
                        <p class="text-muted small mb-0">National ID verified against government records.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm text-center p-3">
                    <div class="card-body">
                        <i class="bi bi-file-earmark-text display-5 mb-3 text-mint-green"></i>
                        <h6 class="fw-bold text-navy">Police Clearance</h6>
                        <p class="text-muted small mb-0">Official criminal record check conducted.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm text-center p-3">
                    <div class="card-body">
                        <i class="bi bi-chat-dots display-5 mb-3 text-baby-pink"></i>
                        <h6 class="fw-bold text-navy">Interview</h6>
                        <p class="text-muted small mb-0">In-person or video interview by our team.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm text-center p-3">
                    <div class="card-body">
                        <i class="bi bi-award display-5 mb-3 text-sunshine-yellow"></i>
                        <h6 class="fw-bold text-navy">Training & Certification</h6>
                        <p class="text-muted small mb-0">Certified in first aid, safety, and childcare.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-light-bg">
    <div class="container">
        <h2 class="text-center fw-bold mb-5 text-navy">Featured Babysitters</h2>
        <div class="overflow-x-auto pb-3">
            <div class="d-flex flex-nowrap gap-4">
                @forelse($featuredBabysitters as $b)
                    <div class="flex-shrink-0" style="width: 280px;">
                        @include('partials._babysitter-card', ['babysitter' => $b])
                    </div>
                @empty
                    <p class="text-muted text-center w-100">No featured babysitters available yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <h2 class="text-center fw-bold mb-5 text-navy">Coming Soon</h2>
        <div class="row g-4">
            <div class="col-md-6 col-lg-4 text-center">
                <i class="bi bi-fingerprint display-5 mb-2 text-sky-blue"></i>
                <p class="fw-bold mb-1 text-navy">Background Checks</p>
                <p class="small text-muted mb-0">We conduct comprehensive background checks including criminal records, employment history, and reference verification for every babysitter.</p>
            </div>
            <div class="col-md-6 col-lg-4 text-center">
                <i class="bi bi-file-text display-5 mb-2 text-mint-green"></i>
                <p class="fw-bold mb-1 text-navy">Activity Reports</p>
                <p class="small text-muted mb-0">Receive detailed reports of your child's activities, meals, and milestones during each babysitting session through our mobile app.</p>
            </div>
            <div class="col-md-6 col-lg-4 text-center">
                <i class="bi bi-people display-5 mb-2 text-baby-pink"></i>
                <p class="fw-bold mb-1 text-navy">Parent Community</p>
                <p class="small text-muted mb-0">Connect with other parents in our secure community forum to share experiences, recommendations, and childcare tips.</p>
            </div>
            <div class="col-md-6 col-lg-4 text-center">
                <i class="bi bi-geo-alt display-5 mb-2 text-sunshine-yellow"></i>
                <p class="fw-bold mb-1 text-navy">Real-Time Location Tracking</p>
                <p class="small text-muted mb-0">Track your babysitter's location throughout the booking period with our secure GPS technology for complete peace of mind.</p>
            </div>
            <div class="col-md-6 col-lg-4 text-center">
                <i class="bi bi-camera-video display-5 mb-2 text-sky-blue"></i>
                <p class="fw-bold mb-1 text-navy">Personal Video Profiles</p>
                <p class="small text-muted mb-0">Watch introductory videos where babysitters showcase their personality, experience, and childcare philosophy.</p>
            </div>
            <div class="col-md-6 col-lg-4 text-center">
                <i class="bi bi-globe display-5 mb-2 text-mint-green"></i>
                <p class="fw-bold mb-1 text-navy">Multilingual Platform</p>
                <p class="small text-muted mb-0">Access our platform in Urdu and English to ensure all Pakistani families can use our service comfortably.</p>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-light-bg">
    <div class="container">
        <h2 class="text-center fw-bold mb-5 text-navy">What Parents Say</h2>
        <div class="row g-4">
            @forelse($testimonials as $testimonial)
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <i class="bi bi-chat-square-quote display-6 mb-3 text-sky-blue" style="opacity: 0.5;"></i>
                            <p class="mb-3 fst-italic">"{{ $testimonial['quote'] }}"</p>
                            @include('partials._star-rating', ['rating' => $testimonial['rating']])
                            <p class="fw-bold mb-0 mt-2 text-navy">{{ $testimonial['name'] }}</p>
                            <p class="text-muted small mb-0">{{ $testimonial['city'] }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted text-center w-100">No testimonials available yet.</p>
            @endforelse
        </div>
    </div>
</section>

<section class="bg-gradient-accent text-on-gradient py-4">
    <div class="container text-center">
        <h4 class="fw-bold mb-3">Need a Babysitter Right Now? Call our emergency line for immediate assistance.</h4>
        <a href="tel:+921234567890" class="btn btn-light btn-lg px-4 text-coral fw-bold">
            <i class="bi bi-telephone-fill me-2"></i>Call Emergency Line
        </a>
    </div>
</section>

@endsection
