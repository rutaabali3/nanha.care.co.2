@extends('layouts.app')

@section('title', 'Register')

@section('content')

<div class="min-vh-100 d-flex align-items-center justify-content-center py-5">
    <div class="card border-0 shadow-sm p-4" style="max-width: 500px; width: 100%;">
        <div class="card-body">
            <div class="text-center mb-4">
                <i class="bi bi-heart-pulse-fill display-4 text-coral"></i>
                <h4 class="fw-bold mt-2 text-sky-blue">Create Account</h4>
            </div>
            <form method="POST" action="{{ route('auth.register') }}">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Full Name</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Email Address</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Password</label>
                    <div class="input-group has-validation">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                        <button class="btn btn-outline-secondary toggle-password" type="button" tabindex="-1"><i class="bi bi-eye"></i></button>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label fw-semibold">Confirm Password</label>
                    <div class="input-group">
                        <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                        <button class="btn btn-outline-secondary toggle-password" type="button" tabindex="-1"><i class="bi bi-eye"></i></button>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold mt-2">Register</button>
            </form>
            <p class="text-center mt-3 mb-0 small">
                Already have an account? <a href="{{ route('auth.login') }}" class="text-decoration-none fw-semibold text-sky-blue">Login</a>
            </p>
        </div>
    </div>
</div>

@endsection
