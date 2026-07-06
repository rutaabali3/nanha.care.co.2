@extends('layouts.dashboard')

@section('title', 'User Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">User Details</h2>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm text-center">
            <div class="card-body py-4">
                <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&size=120&background=87CEEB&color=2D3436' }}"
                     alt="{{ $user->name }}" class="rounded-circle mb-3" width="120" height="120">
                <h5 class="fw-bold">{{ $user->name }}</h5>
                <p class="text-muted small mb-2">{{ $user->email }}</p>
                @foreach($user->roles as $role)
                    <span class="badge me-1" style="background-color: var(--mint-green); color: var(--dark-text);">{{ $role->name }}</span>
                @endforeach
                <div class="mt-3">
                    @php
                        $statusColors = ['active' => 'var(--mint-green)', 'suspended' => 'var(--sunshine-yellow)', 'banned' => 'var(--baby-pink)'];
                    @endphp
                    <span class="badge fs-6" style="background-color: {{ $statusColors[$user->status->value] ?? '#ccc' }}; color: var(--dark-text);">
                        {{ ucfirst($user->status->value) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom-0 pt-3">
                <h5 class="fw-bold mb-0">Account Information</h5>
            </div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-4">Phone</dt>
                    <dd class="col-sm-8">{{ $user->phone ?? '—' }}</dd>

                    <dt class="col-sm-4">City</dt>
                    <dd class="col-sm-8">{{ $user->city ?? '—' }}</dd>

                    <dt class="col-sm-4">Member Since</dt>
                    <dd class="col-sm-8">{{ $user->created_at->format('M d, Y') }}</dd>

                    <dt class="col-sm-4">Last Updated</dt>
                    <dd class="col-sm-8">{{ $user->updated_at->format('M d, Y') }}</dd>

                    <dt class="col-sm-4">Email Verified</dt>
                    <dd class="col-sm-8">
                        @if($user->email_verified_at)
                            <i class="bi bi-check-circle-fill text-success"></i> {{ $user->email_verified_at->format('M d, Y') }}
                        @else
                            <i class="bi bi-x-circle-fill text-danger"></i> Not verified
                        @endif
                    </dd>
                </dl>
            </div>
        </div>

        @if($user->babysitterProfile)
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-white border-bottom-0 pt-3">
                    <h5 class="fw-bold mb-0">Babysitter Profile</h5>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Experience</dt>
                        <dd class="col-sm-8">{{ $user->babysitterProfile->experience_years ?? '—' }} years</dd>
                        <dt class="col-sm-4">Hourly Rate</dt>
                        <dd class="col-sm-8">${{ number_format($user->babysitterProfile->hourly_rate ?? 0, 2) }}</dd>
                        <dt class="col-sm-4">Bio</dt>
                        <dd class="col-sm-8">{{ $user->babysitterProfile->bio ?? '—' }}</dd>
                    </dl>
                </div>
            </div>
        @endif

        @if($user->doctorProfile)
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-white border-bottom-0 pt-3">
                    <h5 class="fw-bold mb-0">Doctor Profile</h5>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Specialization</dt>
                        <dd class="col-sm-8">{{ $user->doctorProfile->specialization ?? '—' }}</dd>
                        <dt class="col-sm-4">License</dt>
                        <dd class="col-sm-8">{{ $user->doctorProfile->license_number ?? '—' }}</dd>
                        <dt class="col-sm-4">Bio</dt>
                        <dd class="col-sm-8">{{ $user->doctorProfile->bio ?? '—' }}</dd>
                        <dt class="col-sm-4">Medical License</dt>
                        <dd class="col-sm-8">
                            @if($user->doctorProfile->medical_license)
                                <a href="{{ asset('storage/' . $user->doctorProfile->medical_license) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <a href="{{ asset('storage/' . $user->doctorProfile->medical_license) }}" download class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-download"></i> Download
                                </a>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </dd>
                        <dt class="col-sm-4">PMDC Certificate</dt>
                        <dd class="col-sm-8">
                            @if($user->doctorProfile->pmdc_cert)
                                <a href="{{ asset('storage/' . $user->doctorProfile->pmdc_cert) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <a href="{{ asset('storage/' . $user->doctorProfile->pmdc_cert) }}" download class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-download"></i> Download
                                </a>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </dd>
                        <dt class="col-sm-4">CV/Resume</dt>
                        <dd class="col-sm-8">
                            @if($user->doctorProfile->cv)
                                <a href="{{ asset('storage/' . $user->doctorProfile->cv) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <a href="{{ asset('storage/' . $user->doctorProfile->cv) }}" download class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-download"></i> Download
                                </a>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </dd>
                    </dl>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
