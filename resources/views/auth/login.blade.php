@extends('layouts.app')

@section('title', 'Login')

@section('content')

<div class="min-vh-100 d-flex align-items-center justify-content-center py-5">
    <div class="card border-0 shadow-sm p-4" style="max-width: 450px; width: 100%;">
        <div class="card-body">
            <div class="text-center mb-4">
                <i class="bi bi-heart-pulse-fill display-4 text-coral"></i>
                <h4 class="fw-bold mt-2 text-sky-blue">NanhaCare</h4>
            </div>
            <form method="POST" action="{{ route('auth.login') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Email Address</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>
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
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Remember Me</label>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <a href="{{ route('auth.forgot-password') }}" class="text-decoration-none small text-sky-blue">Forgot Password?</a>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Login</button>
            </form>
            <p class="text-center mt-3 mb-0 small">
                Don't have an account? <a href="{{ route('auth.register') }}" class="text-decoration-none fw-semibold text-sky-blue">Register</a>
            </p>
        </div>
    </div>
</div>

@endsection
