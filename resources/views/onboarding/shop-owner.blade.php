@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/onboarding.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0" style="background-color: var(--off-white);">
                <div class="card-body p-4 p-md-5">
                    <h2 class="fw-bold mb-1" style="color: var(--dark-text);">Open Your Shop</h2>
                    <p class="text-muted mb-4">List your baby products on NanhaCare</p>

                    <form method="POST" action="{{ route('onboarding.shop-owner') }}" enctype="multipart/form-data">
                        @csrf

                        @if ($errors->any())
                            <div class="alert alert-danger mb-4">
                                <strong>Please fix the following errors:</strong>
                                <ul class="mb-0 mt-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div id="step-indicators" class="d-flex justify-content-between mb-4">
                            <div class="text-center flex-fill">
                                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-1" style="width: 36px; height: 36px; background-color: var(--sky-blue); color: var(--white); font-weight: 700;" id="step1-indicator">1</div>
                                <p class="small mb-0 fw-medium" id="step1-label">Personal Info</p>
                            </div>
                            <div class="text-center flex-fill">
                                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-1" style="width: 36px; height: 36px; background-color: #dee2e6; color: #6c757d; font-weight: 700;" id="step2-indicator">2</div>
                                <p class="small mb-0 text-muted" id="step2-label">Shop Details</p>
                            </div>
                        </div>

                        <div class="progress mb-4" style="height: 6px;">
                            <div class="progress-bar" id="progress-bar" role="progressbar" style="width: 50%; background-color: var(--sky-blue);" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                        <div id="step-1">
                            <h5 class="fw-semibold mb-3" style="color: var(--dark-text);">Step 1: Personal Information</h5>

                            <div class="mb-3">
                                <label for="full_name" class="form-label fw-medium">Full Name</label>
                                <input type="text" class="form-control @error('full_name') is-invalid @enderror" id="full_name" name="full_name" value="{{ old('full_name') }}" required>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-medium">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label fw-medium">Phone</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="city" class="form-label fw-medium">City</label>
                                <select class="form-select @error('city') is-invalid @enderror" id="city" name="city" required>
                                    <option value="" disabled {{ old('city') ? '' : 'selected' }}>Select city</option>
                                    <option value="Karachi" {{ old('city') == 'Karachi' ? 'selected' : '' }}>Karachi</option>
                                    <option value="Lahore" {{ old('city') == 'Lahore' ? 'selected' : '' }}>Lahore</option>
                                    <option value="Islamabad" {{ old('city') == 'Islamabad' ? 'selected' : '' }}>Islamabad</option>
                                    <option value="Rawalpindi" {{ old('city') == 'Rawalpindi' ? 'selected' : '' }}>Rawalpindi</option>
                                    <option value="Faisalabad" {{ old('city') == 'Faisalabad' ? 'selected' : '' }}>Faisalabad</option>
                                    <option value="Multan" {{ old('city') == 'Multan' ? 'selected' : '' }}>Multan</option>
                                    <option value="Peshawar" {{ old('city') == 'Peshawar' ? 'selected' : '' }}>Peshawar</option>
                                    <option value="Quetta" {{ old('city') == 'Quetta' ? 'selected' : '' }}>Quetta</option>
                                    <option value="Sialkot" {{ old('city') == 'Sialkot' ? 'selected' : '' }}>Sialkot</option>
                                    <option value="Gujranwala" {{ old('city') == 'Gujranwala' ? 'selected' : '' }}>Gujranwala</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="profile_photo" class="form-label fw-medium">Profile Photo</label>
                                <input type="file" class="form-control" id="profile_photo" name="profile_photo" accept="image/*" onchange="previewImage(this, 'profile-preview')">
                                <div class="mt-2">
                                    <img id="profile-preview" src="#" alt="Preview" class="rounded" style="max-width: 150px; max-height: 150px; display: none;">
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="button" class="btn btn-primary px-4" id="step1-next" onclick="goToStep(2)">
                                    Next <i class="bi bi-arrow-right ms-1"></i>
                                </button>
                            </div>
                        </div>

                        <div id="step-2" style="display: none;">
                            <h5 class="fw-semibold mb-3" style="color: var(--dark-text);">Step 2: Shop Details</h5>

                            <div class="mb-3">
                                <label for="shop_name" class="form-label fw-medium">Shop Name</label>
                                <input type="text" class="form-control @error('shop_name') is-invalid @enderror" id="shop_name" name="shop_name" value="{{ old('shop_name') }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="shop_description" class="form-label fw-medium">Shop Description</label>
                                <textarea class="form-control @error('shop_description') is-invalid @enderror" id="shop_description" name="shop_description" rows="3" required>{{ old('shop_description') }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="shop_address" class="form-label fw-medium">Shop Address</label>
                                <textarea class="form-control @error('shop_address') is-invalid @enderror" id="shop_address" name="shop_address" rows="2" required>{{ old('shop_address') }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="business_license" class="form-label fw-medium">Business License</label>
                                <input type="file" class="form-control" id="business_license" name="business_license" accept="image/*,.pdf" onchange="previewImage(this, 'license-preview')">
                                <div class="mt-2">
                                    <img id="license-preview" src="#" alt="Preview" class="rounded" style="max-width: 150px; max-height: 150px; display: none;">
                                </div>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="shop_logo" class="form-label fw-medium">Shop Logo</label>
                                    <input type="file" class="form-control" id="shop_logo" name="shop_logo" accept="image/*" onchange="previewImage(this, 'logo-preview')">
                                    <div class="mt-2">
                                        <img id="logo-preview" src="#" alt="Preview" class="rounded" style="max-width: 150px; max-height: 150px; display: none;">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="shop_banner" class="form-label fw-medium">Shop Banner</label>
                                    <input type="file" class="form-control" id="shop_banner" name="shop_banner" accept="image/*" onchange="previewImage(this, 'banner-preview')">
                                    <div class="mt-2">
                                        <img id="banner-preview" src="#" alt="Preview" class="rounded" style="max-width: 150px; max-height: 150px; display: none;">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-medium">Categories</label>
                                <div class="d-flex flex-wrap gap-3">
                                    @foreach(\App\Enums\ShopCategory::labels() as $val => $label)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $val }}" id="cat-{{ $val }}">
                                        <label class="form-check-label" for="cat-{{ $val }}">{{ $label }}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-outline-secondary px-4" id="step2-prev" onclick="goToStep(1)">
                                    <i class="bi bi-arrow-left me-1"></i> Previous
                                </button>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bi bi-check-lg me-1"></i> Register Shop
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) { preview.src = e.target.result; preview.style.display = 'block'; }
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.src = '#'; preview.style.display = 'none';
    }
}

function goToStep(step) {
    document.getElementById('step-1').style.display = step === 1 ? 'block' : 'none';
    document.getElementById('step-2').style.display = step === 2 ? 'block' : 'none';
    const p1 = document.getElementById('step1-indicator'), p2 = document.getElementById('step2-indicator');
    const l1 = document.getElementById('step1-label'), l2 = document.getElementById('step2-label');
    const bar = document.getElementById('progress-bar');
    if (step === 1) {
        p1.style.backgroundColor = 'var(--sky-blue)'; p1.style.color = 'var(--white)';
        p2.style.backgroundColor = '#dee2e6'; p2.style.color = '#6c757d';
        l1.classList.remove('text-muted'); l2.classList.add('text-muted');
        bar.style.width = '50%'; bar.setAttribute('aria-valuenow', '50');
    } else {
        p1.style.backgroundColor = '#dee2e6'; p1.style.color = '#6c757d';
        p2.style.backgroundColor = 'var(--sky-blue)'; p2.style.color = 'var(--white)';
        l1.classList.add('text-muted'); l2.classList.remove('text-muted');
        bar.style.width = '100%'; bar.setAttribute('aria-valuenow', '100');
    }
}

// On page load, jump to the correct step if there are validation errors
document.addEventListener('DOMContentLoaded', function () {
    @if ($errors->any())
        const step2Fields = ['shop_name', 'shop_description', 'shop_address', 'shop_logo', 'shop_banner', 'business_license', 'categories'];
        const hasStep2Error = step2Fields.some(field => document.querySelector('[name="' + field + '"]')?.classList.contains('is-invalid'));
        const step1Fields = ['full_name', 'email', 'phone', 'city', 'profile_photo'];
        const hasStep1Error = step1Fields.some(field => document.querySelector('[name="' + field + '"]')?.classList.contains('is-invalid'));
        if (hasStep2Error && !hasStep1Error) {
            goToStep(2);
        }
    @endif
});
</script>
@endpush
