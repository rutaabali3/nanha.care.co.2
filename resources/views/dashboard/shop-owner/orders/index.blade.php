@extends('layouts.dashboard')

@section('title', 'Orders')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Orders</h2>
</div>

<form method="GET" class="row g-2 mb-4">
    <div class="col-auto">
        <select name="status" class="form-select" onchange="this.form.submit()">
            <option value="">All Statuses</option>
            @foreach(['processing', 'shipped', 'delivered', 'cancelled', 'returned'] as $s)
                <option value="{{ $s }}" @selected(request('status') === $s)>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-auto">
        <input type="date" name="from" class="form-control" value="{{ request('from') }}" placeholder="From">
    </div>
    <div class="col-auto">
        <input type="date" name="to" class="form-control" value="{{ request('to') }}" placeholder="To">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-outline-secondary">Filter</button>
        <a href="{{ route('shop-owner.orders.index') }}" class="btn btn-outline-danger">Clear</a>
    </div>
</form>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Order ID</th>
                        <th>Customer</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th class="pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td class="ps-4 fw-semibold">#{{ $order->id }}</td>
                        <td>{{ $order->parent->name ?? 'N/A' }}</td>
                        <td>{{ $order->items->count() }}</td>
                        <td>PKR {{ number_format($order->total, 2) }}</td>
                        <td>{{ ucfirst($order->payment_method) }}</td>
                        <td>
                            @php
                                $statusVal = $order->status->value ?? $order->status;
                                $badgeColors = ['processing' => 'primary', 'shipped' => 'warning', 'delivered' => 'success', 'cancelled' => 'danger', 'returned' => 'purple'];
                            @endphp
                            <span class="badge bg-{{ $badgeColors[$statusVal] ?? 'secondary' }}">
                                {{ ucfirst($statusVal) }}
                            </span>
                        </td>
                        <td>{{ $order->created_at->format('d M Y') }}</td>
                        <td class="pe-4">
                            <div class="d-flex gap-2">
                                <form method="POST" action="{{ route('shop-owner.orders.status', $order->id) }}" class="d-inline">
                                    @csrf
                                    <select name="status" class="form-select form-select-sm d-inline w-auto" onchange="this.form.submit()">
                                        @foreach(['processing', 'shipped', 'delivered', 'cancelled', 'returned'] as $s)
                                            <option value="{{ $s }}" @selected(($order->status->value ?? $order->status) === $s)>{{ ucfirst($s) }}</option>
                                        @endforeach
                                    </select>
                                </form>
                                @if(($order->status->value ?? $order->status) !== 'cancelled' && ($order->status->value ?? $order->status) !== 'delivered')
                                <form method="POST" action="{{ route('shop-owner.orders.cancel', $order->id) }}" id="cancel-order-{{ $order->id }}" class="d-inline">
                                    @csrf
                                    <button type="button" class="btn btn-sm btn-outline-danger" data-confirm-form="cancel-order-{{ $order->id }}">
                                        <i class="bi bi-x-circle"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">No orders found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('partials._pagination', ['paginator' => $orders])
@endsection
