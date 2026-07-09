@extends('layouts.dashboard')

@section('title', 'Analytics')

@push('scripts')
<script src="{{ asset('js/chart.js') }}"></script>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Analytics</h2>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom-0 pt-3">
                <h5 class="fw-bold mb-0">Views Over Time (Weekly)</h5>
            </div>
            <div class="card-body">
                <canvas id="viewsChart" height="250"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom-0 pt-3">
                <h5 class="fw-bold mb-0">Posts by Category</h5>
            </div>
            <div class="card-body">
                <canvas id="categoriesChart" height="250"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom-0 pt-3">
                <h5 class="fw-bold mb-0">Readers by City</h5>
            </div>
            <div class="card-body">
                <canvas id="citiesChart" height="250"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom-0 pt-3">
                <h5 class="fw-bold mb-0">Your Posts</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Title</th>
                                <th>Views</th>
                                <th>Published</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($posts as $post)
                                <tr>
                                    <td class="text-wrap" style="max-width: 280px;">{{ $post->title }}</td>
                                    <td>{{ number_format($post->views) }}</td>
                                    <td class="text-muted small">{{ $post->created_at->format('M d, Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">No posts yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const colorPalette = [
        'rgba(135, 206, 235, 0.8)',
        'rgba(152, 216, 200, 0.8)',
        'rgba(255, 182, 193, 0.8)',
        'rgba(255, 215, 0, 0.8)',
        'rgba(135, 206, 235, 0.5)',
        'rgba(152, 216, 200, 0.5)',
    ];

    function fetchChart(type, canvasId, chartType, labelCallback) {
        fetch('{{ route('doctor.analytics.chart-data') }}?type=' + type)
            .then(function (res) { return res.json(); })
            .then(function (data) {
                const ctx = document.getElementById(canvasId);
                if (!ctx) return;

                let labels, values, bgColors;
                if (chartType === 'line') {
                    labels = data.map(function (d) { return 'Week ' + d.week; });
                    values = data.map(function (d) { return d.total; });
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Views',
                                data: values,
                                borderColor: 'rgba(135, 206, 235, 1)',
                                backgroundColor: 'rgba(135, 206, 235, 0.2)',
                                fill: true,
                                tension: 0.3,
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: { legend: { display: false } },
                            scales: { y: { beginAtZero: true } }
                        }
                    });
                } else {
                    labels = data.map(function (d) {
                        return labelCallback ? labelCallback(d.category || d.city) : (d.category || d.city);
                    });
                    values = data.map(function (d) { return d.total; });
                    bgColors = labels.map(function (_, i) { return colorPalette[i % colorPalette.length]; });
                    new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: labels,
                            datasets: [{
                                data: values,
                                backgroundColor: bgColors,
                                borderWidth: 0,
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: { position: 'bottom', labels: { boxWidth: 12, padding: 10 } }
                            }
                        }
                    });
                }
            });
    }

    fetchChart('views', 'viewsChart', 'line');
    fetchChart('categories', 'categoriesChart', 'doughnut', function (cat) { return cat.replace(/_/g, ' ').replace(/\b\w/g, function (c) { return c.toUpperCase(); }); });
    fetchChart('cities', 'citiesChart', 'doughnut');
});
</script>
@endpush
