@extends('layouts.dashboard')

@section('title', 'Reports & Analytics')

@push('scripts')
<script src="{{ asset('js/chart.js') }}"></script>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Reports & Analytics</h2>
    <a href="{{ route('admin.reports.export') }}" class="btn btn-primary">
        <i class="bi bi-download"></i> Export CSV
    </a>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom-0 pt-3">
                <h6 class="fw-bold mb-0">Users Per Week (Last 12 Weeks)</h6>
            </div>
            <div class="card-body">
                <canvas id="usersPerWeekChart" height="200"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom-0 pt-3">
                <h6 class="fw-bold mb-0">Bookings Per Day (Last 30 Days)</h6>
            </div>
            <div class="card-body">
                <canvas id="bookingsPerDayChart" height="200"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom-0 pt-3">
                <h6 class="fw-bold mb-0">Top Products (By Quantity Sold)</h6>
            </div>
            <div class="card-body">
                <canvas id="topProductsChart" height="200"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom-0 pt-3">
                <h6 class="fw-bold mb-0">City Usage (User Distribution)</h6>
            </div>
            <div class="card-body">
                <canvas id="cityUsageChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const chartDefaults = { responsive: true, maintainAspectRatio: false };

    async function fetchChart(url, canvasId, transform) {
        try {
            const res = await fetch(url);
            const data = await res.json();
            const ctx = document.getElementById(canvasId)?.getContext('2d');
            if (ctx) new Chart(ctx, transform(data));
        } catch (e) { console.error('Chart load error:', e); }
    }

    fetchChart('{{ route("admin.reports.users-per-week") }}', 'usersPerWeekChart', (data) => ({
        type: 'bar',
        data: { labels: data.labels, datasets: [{ label: 'Users', data: data.values, backgroundColor: 'var(--sky-blue)' }] },
        options: chartDefaults
    }));

    fetchChart('{{ route("admin.reports.bookings-per-day") }}', 'bookingsPerDayChart', (data) => ({
        type: 'line',
        data: { labels: data.labels, datasets: [{ label: 'Bookings', data: data.values, borderColor: 'var(--mint-green)', fill: false }] },
        options: chartDefaults
    }));

    fetchChart('{{ route("admin.reports.top-products") }}', 'topProductsChart', (data) => ({
        type: 'bar',
        data: { labels: data.labels, datasets: [{ label: 'Sold', data: data.values, backgroundColor: 'var(--sunshine-yellow)' }] },
        options: { ...chartDefaults, indexAxis: 'y' }
    }));

    fetchChart('{{ route("admin.reports.city-usage") }}', 'cityUsageChart', (data) => ({
        type: 'doughnut',
        data: { labels: data.labels, datasets: [{ data: data.values, backgroundColor: ['var(--sky-blue)', 'var(--baby-pink)', 'var(--mint-green)', 'var(--sunshine-yellow)', '#ccc'] }] },
        options: chartDefaults
    }));
});
</script>
@endpush
