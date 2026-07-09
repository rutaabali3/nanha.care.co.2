@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/babysitters.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold text-dark">Find a Babysitter</h2>
            <p class="text-muted">Browse trusted babysitters in your area</p>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4 bg-off-white">
        <div class="card-body p-4">
            <form method="GET" action="{{ route('babysitters.index') }}">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="search" class="form-label fw-medium">Search</label>
                        <input type="text" class="form-control" id="search" name="search" placeholder="Search by name..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="city" class="form-label fw-medium">City</label>
                        <select class="form-select" id="city" name="city">
                            <option value="">All Cities</option>
                            @foreach($cities as $city)
                            <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="specialization" class="form-label fw-medium">Specialization</label>
                        <select class="form-select" id="specialization" name="specialization">
                            <option value="">All Specializations</option>
                            @foreach($specializations as $spec)
                            <option value="{{ $spec }}" {{ request('specialization') == $spec ? 'selected' : '' }}>{{ $spec }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="sort" class="form-label fw-medium">Sort By</label>
                        <select class="form-select" id="sort" name="sort">
                            <option value="newest" {{ request('sort', 'newest') == 'newest' ? 'selected' : '' }}>Newest</option>
                            <option value="rate_asc" {{ request('sort') == 'rate_asc' ? 'selected' : '' }}>Rate: Low-High</option>
                            <option value="rate_desc" {{ request('sort') == 'rate_desc' ? 'selected' : '' }}>Rate: High-Low</option>
                            <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12 d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4" style="font-weight: 600;">
                            <i class="bi bi-funnel me-1"></i> Filter
                        </button>
                        <a href="{{ route('babysitters.index') }}" class="btn btn-outline-secondary px-4">
                            <i class="bi bi-x-circle me-1"></i> Clear
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <p class="mb-0 fw-medium text-dark">
            Showing {{ $babysitters->count() }} babysitter{{ $babysitters->count() !== 1 ? 's' : '' }}
        </p>
    </div>

    @if($babysitters->count() > 0)
    <div class="row g-4">
        @foreach($babysitters as $babysitter)
        <div class="col-md-4">
            @include('partials._babysitter-card', ['babysitter' => $babysitter])
        </div>
        @endforeach
    </div>

    <div class="mt-4 d-flex justify-content-center">
        @include('partials._pagination', ['paginator' => $babysitters])
    </div>
    @else
    <div class="text-center py-5">
        <i class="bi bi-people" style="font-size: 4rem; color: #dee2e6;"></i>
        <h5 class="mt-3 fw-semibold text-dark">No babysitters found matching your criteria</h5>
        <p class="text-muted">Try adjusting your filters or search terms.</p>
<a href="{{ route('babysitters.index') }}" class="btn btn-primary px-4" style="font-weight: 600;">
                            <i class="bi bi-x-circle me-1"></i> Clear Filters
        </a>
    </div>
    @endif
</div>
@endsection
