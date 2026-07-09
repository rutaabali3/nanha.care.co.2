@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/blog.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container-fluid py-5 bg-gradient-hero text-on-gradient">
    <div class="container text-center">
        <h1 class="display-4 fw-bold text-on-gradient">NanhaCare Blog</h1>
        <p class="lead mb-0 text-on-gradient">Expert advice on childcare, parenting, and child health from Pakistan's top pediatricians</p>
    </div>
</div>

<div class="container py-4">
    <div class="d-flex flex-wrap gap-2 mb-4 justify-content-center">
        <a href="{{ route('blog.index') }}" class="btn rounded-pill px-3 {{ request('category') ? 'btn-outline-secondary' : 'btn-primary' }}">All</a>
        <a href="{{ route('blog.index', ['category' => 'child-health']) }}" class="btn rounded-pill px-3 {{ request('category') == 'child-health' ? 'btn-primary' : 'btn-outline-secondary' }}">Child Health</a>
        <a href="{{ route('blog.index', ['category' => 'parenting-tips']) }}" class="btn rounded-pill px-3 {{ request('category') == 'parenting-tips' ? 'btn-primary' : 'btn-outline-secondary' }}">Parenting Tips</a>
        <a href="{{ route('blog.index', ['category' => 'nutrition']) }}" class="btn rounded-pill px-3 {{ request('category') == 'nutrition' ? 'btn-primary' : 'btn-outline-secondary' }}">Nutrition</a>
        <a href="{{ route('blog.index', ['category' => 'safety']) }}" class="btn rounded-pill px-3 {{ request('category') == 'safety' ? 'btn-primary' : 'btn-outline-secondary' }}">Safety</a>
        <a href="{{ route('blog.index', ['category' => 'development']) }}" class="btn rounded-pill px-3 {{ request('category') == 'development' ? 'btn-primary' : 'btn-outline-secondary' }}">Development</a>
    </div>

    @if($posts->count() > 0)
    <div class="row g-4">
        @foreach($posts as $post)
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0">
                <img src="{{ $post->cover_image ? asset('storage/' . $post->cover_image) : 'https://placehold.co/600x400?text=Blog' }}" alt="{{ $post->title }}" class="card-img-top rounded-top" style="height: 200px; object-fit: cover;">
                <div class="card-body d-flex flex-column">
                    <span class="badge rounded-pill px-3 py-1 align-self-start mb-2 bg-mint-green text-on-gradient">{{ $post->category }}</span>
                    <h5 class="fw-bold text-navy">{{ $post->title }}</h5>
                    <p class="text-muted flex-grow-1" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $post->excerpt }}</p>
                    <div class="d-flex justify-content-between align-items-center mt-auto">
                        <small class="text-muted"><i class="bi bi-person"></i> {{ $post->doctor->name ?? 'Dr. Expert' }} &middot; {{ optional($post->published_at)->format('M d, Y') ?? 'N/A' }}</small>
                        <a href="{{ route('blog.detail', $post->slug) }}" class="btn btn-sm btn-primary">Read More</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="mt-4">
        @include('partials._pagination', ['paginator' => $posts])
    </div>
    @else
    <div class="text-center py-5">
        <i class="bi bi-newspaper text-sky-blue" style="font-size: 4rem;"></i>
        <h4 class="mt-3 fw-semibold text-navy">No posts yet</h4>
        <p class="text-muted">Check back soon for new articles.</p>
    </div>
    @endif
</div>
@endsection
