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
                    <h2 class="fw-bold mb-1" style="color: var(--dark-text);">Register as a Doctor</h2>
                    <p class="text-muted mb-4">Join NanhaCare's healthcare network</p>

                    @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong><i class="bi bi-exclamation-triangle-fill me-2"></i>Please fix the following errors:</strong>
                        <ul class="mb-0 mt-1">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('onboarding.doctor') }}" enctype="multipart/form-data">
                        @csrf

                        <div id="step-indicators" class="d-flex justify-content-between mb-4">
                            <div class="text-center flex-fill">
                                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-1" style="width: 36px; height: 36px; background-color: var(--baby-pink); color: var(--white); font-weight: 700;" id="step1-indicator">1</div>
                                <p class="small mb-0 fw-medium" id="step1-label">Personal Info</p>
                            </div>
                            <div class="text-center flex-fill">
                                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-1" style="width: 36px; height: 36px; background-color: #dee2e6; color: #6c757d; font-weight: 700;" id="step2-indicator">2</div>
                                <p class="small mb-0 text-muted" id="step2-label">Professional Details</p>
                            </div>
                        </div>

                        <div class="progress mb-4" style="height: 6px;">
                            <div class="progress-bar" id="progress-bar" role="progressbar" style="width: 50%; background-color: var(--baby-pink);" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                        <div id="step-1">
                            <h5 class="fw-semibold mb-3" style="color: var(--dark-text);">Step 1: Personal Information</h5>

                            <div class="mb-3">
                                <label for="full_name" class="form-label fw-medium">Full Name</label>
                                <input type="text" class="form-control @error('full_name') is-invalid @enderror" id="full_name" name="full_name" value="{{ old('full_name') }}" required>
                                @error('full_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-medium">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label fw-medium">Phone</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" required>
                                    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
                                </select>
                                @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="profile_photo" class="form-label fw-medium">Profile Photo <span class="text-danger">*</span></label>
                                <input type="file" class="form-control @error('profile_photo') is-invalid @enderror" id="profile_photo" name="profile_photo" accept="image/*" onchange="previewImage(this, 'profile-preview')">
                                @error('profile_photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
                            <h5 class="fw-semibold mb-3" style="color: var(--dark-text);">Step 2: Professional Details</h5>

                            <div class="mb-3">
                                <label for="pmdc_number" class="form-label fw-medium">PMDC Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('pmdc_number') is-invalid @enderror" id="pmdc_number" name="pmdc_number" value="{{ old('pmdc_number') }}" required>
                                @error('pmdc_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="specialization" class="form-label fw-medium">Specialization</label>
                                <select class="form-select @error('specialization') is-invalid @enderror" id="specialization" name="specialization" required>
                                    <option value="" disabled {{ old('specialization') ? '' : 'selected' }}>Select specialization</option>
                                    <option value="Pediatrician" {{ old('specialization') == 'Pediatrician' ? 'selected' : '' }}>Pediatrician</option>
                                    <option value="Child Psychologist" {{ old('specialization') == 'Child Psychologist' ? 'selected' : '' }}>Child Psychologist</option>
                                    <option value="Nutritionist" {{ old('specialization') == 'Nutritionist' ? 'selected' : '' }}>Nutritionist</option>
                                    <option value="General Physician" {{ old('specialization') == 'General Physician' ? 'selected' : '' }}>General Physician</option>
                                    <option value="Other" {{ old('specialization') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('specialization') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="clinic_name" class="form-label fw-medium">Clinic/Hospital Name</label>
                                    <input type="text" class="form-control @error('clinic_name') is-invalid @enderror" id="clinic_name" name="clinic_name" value="{{ old('clinic_name') }}">
                                    @error('clinic_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="years_experience" class="form-label fw-medium">Years of Experience</label>
                                    <input type="number" class="form-control @error('years_experience') is-invalid @enderror" id="years_experience" name="years_experience" value="{{ old('years_experience') }}" min="0" required>
                                    @error('years_experience') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="clinic_address" class="form-label fw-medium">Clinic Address</label>
                                <textarea class="form-control @error('clinic_address') is-invalid @enderror" id="clinic_address" name="clinic_address" rows="2">{{ old('clinic_address') }}</textarea>
                                @error('clinic_address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="medical_license" class="form-label fw-medium">Medical License</label>
                                <input type="file" class="form-control @error('medical_license') is-invalid @enderror" id="medical_license" name="medical_license" accept="image/*,.pdf" onchange="previewImage(this, 'license-preview')">
                                @error('medical_license') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <div class="mt-2">
                                    <img id="license-preview" src="#" alt="Preview" class="rounded" style="max-width: 150px; max-height: 150px; display: none;">
                                </div>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="pmdc_cert" class="form-label fw-medium">PMDC Certificate</label>
                                    <input type="file" class="form-control @error('pmdc_cert') is-invalid @enderror" id="pmdc_cert" name="pmdc_cert" accept="image/*,.pdf" onchange="previewImage(this, 'pmdc-preview')">
                                    @error('pmdc_cert') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    <div class="mt-2">
                                        <img id="pmdc-preview" src="#" alt="Preview" class="rounded" style="max-width: 150px; max-height: 150px; display: none;">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="cv" class="form-label fw-medium">CV/Resume</label>
                                    <input type="file" class="form-control @error('cv') is-invalid @enderror" id="cv" name="cv" accept=".pdf,.doc,.docx">
                                    @error('cv') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-outline-secondary px-4" id="step2-prev" onclick="goToStep(1)">
                                    <i class="bi bi-arrow-left me-1"></i> Previous
                                </button>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bi bi-check-lg me-1"></i> Submit Registration
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
        p1.style.backgroundColor = 'var(--baby-pink)'; p1.style.color = 'var(--white)';
        p2.style.backgroundColor = '#dee2e6'; p2.style.color = '#6c757d';
        l1.classList.remove('text-muted'); l2.classList.add('text-muted');
        bar.style.width = '50%'; bar.setAttribute('aria-valuenow', '50');
    } else {
        p1.style.backgroundColor = '#dee2e6'; p1.style.color = '#6c757d';
        p2.style.backgroundColor = 'var(--baby-pink)'; p2.style.color = 'var(--white)';
        l1.classList.add('text-muted'); l2.classList.remove('text-muted');
        bar.style.width = '100%'; bar.setAttribute('aria-valuenow', '100');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    var hasStep2Errors = {{ $errors->hasAny(['pmdc_number', 'specialization', 'clinic_name', 'years_experience', 'clinic_address', 'medical_license', 'pmdc_cert', 'cv']) ? 'true' : 'false' }};
    if (hasStep2Errors) {
        goToStep(2);
    }
});
</script>
@endpush
