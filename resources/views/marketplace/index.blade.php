@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/marketplace.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container-fluid py-5 bg-gradient-hero text-on-gradient">
    <div class="container text-center">
        <h1 class="display-4 fw-bold">Baby Products Marketplace</h1>
        <p class="lead mb-0">Everything your little one needs, from trusted shops across Pakistan</p>
    </div>
</div>

<div class="container py-4">
    <form method="GET" action="{{ route('marketplace.index') }}" class="row g-3 mb-4 p-3 rounded shadow-sm bg-off-white">
        <div class="col-md-3">
            <input type="text" name="search" class="form-control" placeholder="Search products..." value="{{ request('search') }}">
        </div>
        <div class="col-md-2">
            <select name="category" class="form-select">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="shop" class="form-select">
                <option value="">All Shops</option>
                @foreach($shops as $shop)
                <option value="{{ $shop->id }}" {{ request('shop') == $shop->id ? 'selected' : '' }}>{{ $shop->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="sort" class="form-select">
                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price Low-High</option>
                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price High-Low</option>
            </select>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-primary flex-fill">Filter</button>
            <a href="{{ route('marketplace.index') }}" class="btn btn-outline-secondary flex-fill">Clear</a>
        </div>
    </form>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-semibold mb-0">Showing {{ $products->total() }} products</h5>
    </div>

    @if($products->count() > 0)
    <div class="row g-4">
        @foreach($products as $product)
        <div class="col-md-3 col-sm-6">
            @include('partials._product-card', ['product' => $product])
        </div>
        @endforeach
    </div>
    <div class="mt-4">
        @include('partials._pagination', ['paginator' => $products])
    </div>
    @else
    <div class="text-center py-5">
        <i class="bi bi-box-seam text-sky-blue" style="font-size: 4rem;"></i>
        <h4 class="mt-3 fw-semibold text-dark">No products found</h4>
        <p class="text-muted">Try adjusting your search or filter criteria.</p>
        <a href="{{ route('marketplace.index') }}" class="btn btn-primary">View All Products</a>
    </div>
    @endif
</div>
@endsection
