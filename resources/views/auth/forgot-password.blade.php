@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')

<div class="min-vh-100 d-flex align-items-center justify-content-center py-5">
    <div class="card border-0 shadow-sm p-4" style="max-width: 450px; width: 100%;">
        <div class="card-body">
            <div class="text-center mb-4">
                <h4 class="fw-bold text-dark">Forgot Password?</h4>
                <p class="text-muted small">Enter your email and we'll send you a reset link</p>
            </div>

            @if (session('status'))
                <div class="alert alert-success text-center small" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <form method="POST" action="{{ route('auth.forgot-password') }}">
                @csrf
                <div class="mb-4">
                    <label for="email" class="form-label fw-semibold">Email Address</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Send Reset Link</button>
            </form>
            <p class="text-center mt-3 mb-0 small">
                <a href="{{ route('auth.login') }}" class="text-decoration-none text-sky-blue"><i class="bi bi-arrow-left me-1"></i>Back to Login</a>
            </p>
        </div>
    </div>
</div>

@endsection
