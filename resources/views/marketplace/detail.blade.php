@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/marketplace.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-sky-blue">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('marketplace.index') }}" class="text-sky-blue">Marketplace</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row g-5">
        <div class="col-md-6">
            <div id="productImageCarousel" class="carousel slide mb-3" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    @foreach($product->images as $index => $image)
                    <button type="button" data-bs-target="#productImageCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}" aria-current="{{ $index === 0 ? 'true' : 'false' }}" aria-label="Slide {{ $index + 1 }}"></button>
                    @endforeach
                </div>
                <div class="carousel-inner rounded shadow-sm">
                    @forelse($product->images as $index => $image)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $product->name }}" class="d-block w-100" style="object-fit: cover; max-height: 500px;">
                    </div>
                    @empty
                    <div class="carousel-item active">
                        <img src="https://placehold.co/600x600?text=Product" alt="No image" class="d-block w-100" style="object-fit: cover; max-height: 500px;">
                    </div>
                    @endforelse
                </div>
                @if(count($product->images) > 1)
                <button class="carousel-control-prev" type="button" data-bs-target="#productImageCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#productImageCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
                @endif
            </div>
            @if(count($product->images) > 1)
            <div class="row g-2">
                @foreach($product->images as $index => $image)
                <div class="col-3">
                    <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $product->name }}" class="img-fluid rounded border" style="cursor: pointer; object-fit: cover; height: 100px; width: 100%;" data-bs-target="#productImageCarousel" data-bs-slide-to="{{ $index }}">
                </div>
                @endforeach
            </div>
            @endif
        </div>

        <div class="col-md-6">
            <h2 class="fw-bold text-dark">{{ $product->name }}</h2>

            <p class="mb-2">
                <a href="{{ route('shop.show', $product->shop->slug) }}" class="text-decoration-none text-sky-blue">
                    <i class="bi bi-shop"></i> {{ $product->shop->name }}
                </a>
            </p>

            <div class="mb-3">
                @if($product->sale_price)
                <span class="fs-3 fw-bold text-coral">Rs. {{ number_format($product->sale_price) }}</span>
                <span class="fs-5 text-decoration-line-through text-muted ms-2">Rs. {{ number_format($product->price) }}</span>
                @else
                <span class="fs-3 fw-bold text-dark">Rs. {{ number_format($product->price) }}</span>
                @endif
            </div>

            <div class="mb-3">
                @include('partials._star-rating', ['rating' => $product->averageRating()])
                <span class="text-muted ms-2">({{ $product->reviews->count() }} reviews)</span>
            </div>

            <p class="mb-4 text-dark">{{ $product->description }}</p>

            @auth
                @if(auth()->user()->hasRole('parent'))
                    @if(auth()->user()->hasCompletedOnboarding())
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="input-group" style="max-width: 140px;">
                            <form method="POST" action="{{ route('cart.update') }}" class="d-flex align-items-center" id="quantity-form">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button type="button" class="btn btn-outline-secondary" onclick="document.getElementById('qty').stepDown(); document.getElementById('quantity-form').submit();">-</button>
                                <input type="number" name="qty" id="qty" class="form-control text-center" value="1" min="1">
                                <button type="button" class="btn btn-outline-secondary" onclick="document.getElementById('qty').stepUp(); document.getElementById('quantity-form').submit();">+</button>
                            </form>
                        </div>

                        <form method="POST" action="{{ route('cart.add') }}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="qty" value="1">
                            <button type="submit" class="btn btn-primary btn-lg px-4">
                                <i class="bi bi-cart-plus"></i> Add to Cart
                            </button>
                        </form>
                    </div>
                    @else
                    <div class="mb-4">
                        <a href="{{ auth()->user()->onboardingRoute() }}" class="btn btn-primary btn-lg px-4">
                            Complete registration
                        </a>
                    </div>
                    @endif
                @else
                <div class="mb-4 p-3 rounded" style="background-color: #fff3cd; border: 1px solid #ffc107;">
                    <i class="bi bi-exclamation-triangle me-1"></i> Only parents can purchase products.
                </div>
                @endif
            @else
                <div class="mb-4">
                    <a href="{{ route('auth.login') }}" class="btn btn-primary btn-lg px-4">
                        <i class="bi bi-box-arrow-in-right"></i> Login to Add to Cart
                    </a>
                </div>
            @endauth

            <span class="badge rounded-pill px-3 py-2 bg-mint-green text-dark">
                <i class="bi bi-tag"></i> {{ $product->category }}
            </span>
        </div>
    </div>

    <div class="mt-5">
        <h4 class="fw-bold mb-4 text-dark">Reviews</h4>
        @if($product->reviews->count() > 0)
        <div class="row g-4">
            @foreach($product->reviews as $review)
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="fw-semibold mb-0">{{ $review->user->name ?? 'Anonymous' }}</h6>
                            <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                        </div>
                        <div class="mb-2">
                            @include('partials._star-rating', ['rating' => $review->rating])
                        </div>
                        <p class="mb-0">{{ $review->comment }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-4">
            <i class="bi bi-chat-square-text text-sky-blue" style="font-size: 3rem;"></i>
            <p class="mt-2 text-muted">No reviews yet. Be the first to review this product!</p>
        </div>
        @endif
    </div>
</div>
@endsection
