@extends('layouts.dashboard')

@section('title', 'Earnings')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="mb-0">Earnings</h4>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            @include('components.stats-card', ['icon' => 'currency-dollar', 'value' => '$' . number_format($earnings->sum('total_fee'), 2), 'label' => 'Total Earned', 'color' => 'var(--mint-green)'])
        </div>
        <div class="col-md-4">
            @include('components.stats-card', ['icon' => 'check-circle', 'value' => $earnings->count(), 'label' => 'Completed Jobs', 'color' => 'var(--sky-blue)'])
        </div>
        <div class="col-md-4">
            @include('components.stats-card', ['icon' => 'cash-stack', 'value' => $earnings->avg('total_fee') ? '$' . number_format($earnings->avg('total_fee'), 2) : '$0', 'label' => 'Avg Per Job', 'color' => 'var(--baby-pink)'])
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="mb-0">Earnings Chart (12 Months)</h5>
        </div>
        <div class="card-body">
            <canvas id="earningsChart" height="100"></canvas>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">Transaction History</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Parent</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($earnings as $earning)
                                    <tr>
                                        <td>{{ $earning->date->format('M d, Y') }}</td>
                                        <td>{{ $earning->parent->name ?? 'N/A' }}</td>
                                        <td>${{ number_format($earning->total_fee, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4">No completed bookings yet</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">Payout History</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($payoutHistory as $payout)
                                    <tr>
                                        <td>{{ $payout->created_at->format('M d, Y') }}</td>
                                        <td>${{ number_format($payout->amount, 2) }}</td>
                                        <td>
                                            <span class="badge rounded-pill text-bg-{{ $payout->status === 'completed' ? 'success' : ($payout->status === 'pending' ? 'warning' : 'secondary') }}">
                                                {{ ucfirst($payout->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4">No payout requests yet</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h5 class="mb-3">Request Payout</h5>
            <form method="POST" action="{{ route('babysitter.earnings.payout') }}" class="row g-3">
                @csrf
                <div class="col-md-4">
                    <label for="amount" class="form-label">Amount ($) — Min $500</label>
                    <input type="number" name="amount" id="amount" class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount') }}" step="0.01" min="500" max="{{ $earnings->sum('total_fee') }}" required>
                    @error('amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-send"></i> Submit Payout Request</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script src="{{ asset('js/chart.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        fetch('{{ route('babysitter.earnings.chart-data') }}')
            .then(res => res.json())
            .then(data => {
                new Chart(document.getElementById('earningsChart'), {
                    type: 'bar',
                    data: {
                        labels: data.map(d => d.month),
                        datasets: [{
                            label: 'Earnings ($)',
                            data: data.map(d => d.total),
                            backgroundColor: 'rgba(135, 206, 235, 0.6)',
                            borderColor: 'rgba(135, 206, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: { beginAtZero: true }
                        }
                    }
                });
            });
    });
</script>
@endpush
