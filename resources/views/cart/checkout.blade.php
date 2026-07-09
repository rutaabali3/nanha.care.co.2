@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/cart.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4 text-navy"><i class="bi bi-credit-card"></i> Checkout</h2>

    <form method="POST" action="{{ route('checkout') }}">
        @csrf
        <div class="row g-4">
            <div class="col-md-7">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3 text-navy">Shipping Address</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Street Address</label>
                                <input type="text" name="address" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">City</label>
                                <select name="city" class="form-select" required>
                                    <option value="">Select City</option>
                                    <option value="Lahore">Lahore</option>
                                    <option value="Karachi">Karachi</option>
                                    <option value="Islamabad">Islamabad</option>
                                    <option value="Rawalpindi">Rawalpindi</option>
                                    <option value="Faisalabad">Faisalabad</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Province</label>
                                <select name="province" class="form-select" required>
                                    <option value="">Select Province</option>
                                    <option value="Punjab">Punjab</option>
                                    <option value="Sindh">Sindh</option>
                                    <option value="KPK">KPK</option>
                                    <option value="Balochistan">Balochistan</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Postal Code</label>
                                <input type="text" name="postal_code" class="form-control">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Order Notes <span class="text-muted">(Optional)</span></label>
                                <textarea name="notes" class="form-control" rows="3" placeholder="Any special instructions..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3 text-navy">Order Summary</h5>
                        @foreach($cart as $item)
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <img src="{{ $item['image'] ? asset('storage/' . $item['image']) : 'https://placehold.co/60x60?text=Product' }}" alt="{{ $item['name'] }}" style="width: 50px; height: 50px; object-fit: cover;" class="rounded">
                            <div class="flex-grow-1">
                                <h6 class="mb-0 fw-semibold" style="font-size: 0.9rem;">{{ $item['name'] }}</h6>
                                <small class="text-muted">Qty: {{ $item['qty'] }}</small>
                            </div>
                            <span class="fw-semibold">Rs. {{ number_format($item['price'] * $item['qty']) }}</span>
                        </div>
                        @endforeach
                        <hr>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal</span>
                            <span class="fw-semibold">Rs. {{ number_format($total) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Shipping</span>
                            <span class="fw-semibold text-mint-green">Free</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="fw-bold">Total</span>
                            <span class="fw-bold fs-5 text-navy">Rs. {{ number_format($total) }}</span>
                        </div>

                        <h6 class="fw-bold mb-3 text-navy">Payment Method</h6>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod" checked>
                            <label class="form-check-label" for="cod">Cash on Delivery</label>
                        </div>
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="radio" name="payment_method" id="jazzcash" value="jazzcash">
                            <label class="form-check-label" for="jazzcash">JazzCash / Easypaisa</label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                            <i class="bi bi-check-circle"></i> Place Order
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
