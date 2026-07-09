@extends('layouts.dashboard')

@section('title', 'My Bookings')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="mb-0">My Bookings</h4>
    </div>

    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link {{ $tab === 'pending' ? 'active' : '' }}" href="{{ route('babysitter.bookings.index', ['tab' => 'pending']) }}">Pending</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $tab === 'confirmed' ? 'active' : '' }}" href="{{ route('babysitter.bookings.index', ['tab' => 'confirmed']) }}">Confirmed</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $tab === 'completed' ? 'active' : '' }}" href="{{ route('babysitter.bookings.index', ['tab' => 'completed']) }}">Completed</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $tab === 'cancelled' ? 'active' : '' }}" href="{{ route('babysitter.bookings.index', ['tab' => 'cancelled']) }}">Cancelled</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $tab === 'all' ? 'active' : '' }}" href="{{ route('babysitter.bookings.index', ['tab' => 'all']) }}">All</a>
        </li>
    </ul>

    <div class="row g-3">
        @forelse($bookings as $booking)
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between mb-2">
                            <div>
                                <h5 class="card-title mb-1">{{ $booking->parent->name ?? 'Unknown Parent' }}</h5>
                                <span class="badge rounded-pill text-bg-{{ $booking->status->value === 'completed' ? 'success' : ($booking->status->value === 'pending' ? 'warning' : ($booking->status->value === 'confirmed' ? 'primary' : 'secondary')) }}">
                                    {{ $booking->status->label() }}
                                </span>
                            </div>
                        </div>
                        <p class="mb-1"><i class="bi bi-calendar me-1"></i> {{ $booking->date->format('M d, Y') }}</p>
                        <p class="mb-1"><i class="bi bi-clock me-1"></i> {{ \Carbon\Carbon::parse($booking->start_time)->format('h:i A') }} ({{ $booking->duration_hours }}h)</p>
                        @if($booking->location)
                            <p class="mb-1"><i class="bi bi-geo-alt me-1"></i> {{ $booking->location }}</p>
                        @endif
                        <p class="mb-0"><i class="bi bi-currency-dollar me-1"></i> ${{ number_format($booking->total_fee, 2) }}</p>
                        @if($booking->notes)
                            <p class="mb-0 mt-2 small text-muted"><em>{{ $booking->notes }}</em></p>
                        @endif
                        @if($booking->decline_reason)
                            <p class="mb-0 mt-2 small text-danger"><strong>Reason:</strong> {{ $booking->decline_reason }}</p>
                        @endif
                    </div>
                    @if($booking->status->value === 'pending')
                        <div class="card-footer bg-white border-0 d-flex gap-2 pt-0">
                            <form method="POST" action="{{ route('babysitter.bookings.accept', $booking->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm"><i class="bi bi-check-circle"></i> Accept</button>
                            </form>
                            <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#declineModal{{ $booking->id }}">
                                <i class="bi bi-x-circle"></i> Decline
                            </button>
                        </div>

                        <div class="modal fade" id="declineModal{{ $booking->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <form method="POST" action="{{ route('babysitter.bookings.decline', $booking->id) }}">
                                    @csrf
                                    <input type="hidden" name="decline_booking_id" value="{{ $booking->id }}">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Decline Booking</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            @if(old('decline_booking_id') == $booking->id && $errors->any())
                                                <div class="alert alert-danger py-2">
                                                    <ul class="mb-0 small">
                                                        @foreach($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                            <label for="reason" class="form-label">Reason for declining</label>
                                            <textarea name="reason" id="reason" class="form-control @if(old('decline_booking_id') == $booking->id) @error('reason') is-invalid @enderror @endif" rows="3" required>{{ old('decline_booking_id') == $booking->id ? old('reason') : '' }}</textarea>
                                            @if(old('decline_booking_id') == $booking->id)
                                                @error('reason') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-danger">Decline</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                    @if($booking->status->value === 'confirmed')
                        <div class="card-footer bg-white border-0 pt-0">
                            <form method="POST" action="{{ route('babysitter.bookings.complete', $booking->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-check-all"></i> Mark as Completed</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-calendar-x fs-1 text-muted"></i>
                        <p class="text-muted mt-2 mb-0">No {{ $tab !== 'all' ? $tab : '' }} bookings found</p>
                    </div>
                </div>
            </div>
        @endforelse
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(old('decline_booking_id'))
            var declineModal = new bootstrap.Modal('#declineModal' + '{{ old('decline_booking_id') }}');
            declineModal.show();
        @endif
    });
</script>
@endpush
