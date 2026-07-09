@extends('layouts.dashboard')

@section('title', 'Settings')

@section('content')
    <h4 class="mb-4">Settings</h4>

    <ul class="nav nav-tabs mb-4" id="settingsTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab">Profile</button>
        </li>

        <li class="nav-item" role="presentation">
            <button class="nav-link" id="notifications-tab" data-bs-toggle="tab" data-bs-target="#notifications" type="button" role="tab">Notifications</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="delete-tab" data-bs-toggle="tab" data-bs-target="#delete" type="button" role="tab">Delete Account</button>
        </li>
    </ul>

    <div class="tab-content">
        {{-- Profile --}}
        <div class="tab-pane fade show active" id="profile" role="tabpanel">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h6 class="mb-0 fw-semibold">Profile Information</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('parent.settings.profile') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                                @error('name', 'profile') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                                <small class="text-muted">Email cannot be changed.</small>
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                                @error('phone', 'profile') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="city" class="form-label">City</label>
                                <input type="text" name="city" id="city" class="form-control" value="{{ old('city', $user->city) }}">
                                @error('city', 'profile') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12">
                                <label for="avatar" class="form-label">Avatar</label>
                                <input type="file" name="avatar" id="avatar" class="form-control" accept="image/*">
                                @error('avatar', 'profile') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                @if($user->avatar)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="rounded-circle" style="width: 64px; height: 64px; object-fit: cover;">
                                    </div>
                                @endif
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        {{-- Notifications --}}
        <div class="tab-pane fade" id="notifications" role="tabpanel">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h6 class="mb-0 fw-semibold">Notification Preferences</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('parent.settings.notifications') }}">
                        @csrf
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" name="email_notifications" id="email_notifications" value="1" {{ $notificationPrefs?->email_notifications ? 'checked' : '' }}>
                            <label class="form-check-label" for="email_notifications">Email Notifications</label>
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" name="sms_notifications" id="sms_notifications" value="1" {{ $notificationPrefs?->sms_notifications ? 'checked' : '' }}>
                            <label class="form-check-label" for="sms_notifications">SMS Notifications</label>
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" name="in_app_notifications" id="in_app_notifications" value="1" {{ $notificationPrefs?->in_app_notifications ? 'checked' : '' }}>
                            <label class="form-check-label" for="in_app_notifications">In-App Notifications</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Preferences</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Delete Account --}}
        <div class="tab-pane fade" id="delete" role="tabpanel">
            <div class="card border-0 shadow-sm border-danger">
                <div class="card-header bg-white text-danger">
                    <h6 class="mb-0 fw-semibold">Delete Account</h6>
                </div>
                <div class="card-body">
                    <p class="text-muted">Once you delete your account, there is no going back. Please be certain.</p>
                    <form method="POST" action="{{ route('parent.settings.delete-account') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="delete_reason" class="form-label">Reason for deletion</label>
                            <textarea name="reason" id="delete_reason" class="form-control" rows="3" required></textarea>
                            @error('reason') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you absolutely sure? This cannot be undone.')">Request Account Deletion</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
