@extends('layouts.app')

@section('title', 'Choose Your Role')

@section('content')
<div class="min-vh-100 d-flex align-items-center justify-content-center py-5">
    <div class="card border-0 shadow-sm p-4" style="max-width: 500px; width: 100%;">
        <div class="card-body">
            <div class="text-center mb-4">
                <i class="bi bi-person-badge display-4 text-coral"></i>
                <h4 class="fw-bold mt-2 text-sky-blue">Choose Your Role</h4>
                <p class="text-muted">How would you like to use Nanha Care?</p>
            </div>
            
            <form method="POST" action="{{ route('auth.choose-role') }}">
                @csrf
                <div class="mb-4">
                    <label for="role" class="form-label fw-semibold">I want to join as</label>
                    <select id="role" class="form-select @error('role') is-invalid @enderror" name="role" required>
                        <option value="" disabled selected>Select your role</option>
                        <option value="parent" {{ old('role') == 'parent' ? 'selected' : '' }}>Parent</option>
                        <option value="babysitter" {{ old('role') == 'babysitter' ? 'selected' : '' }}>Babysitter</option>
                        <option value="shop_owner" {{ old('role') == 'shop_owner' ? 'selected' : '' }}>Shop Owner</option>
                        <option value="doctor" {{ old('role') == 'doctor' ? 'selected' : '' }}>Doctor</option>
                    </select>
                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Continue</button>
            </form>
        </div>
    </div>
</div>
@endsection
