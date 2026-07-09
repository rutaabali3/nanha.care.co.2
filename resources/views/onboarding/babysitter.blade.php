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
                    <h2 class="fw-bold mb-1" style="color: var(--dark-text);">Become a Babysitter</h2>
                    <p class="text-muted mb-4">Join NanhaCare as a trusted babysitter</p>

                    <form method="POST" action="{{ route('onboarding.babysitter') }}" enctype="multipart/form-data" novalidate>
                        @csrf

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

                        <div id="step-indicators" class="d-flex justify-content-between mb-4">
                            <div class="text-center flex-fill">
                                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-1" style="width: 36px; height: 36px; background-color: var(--mint-green); color: var(--white); font-weight: 700;" id="step1-indicator">1</div>
                                <p class="small mb-0 fw-medium" id="step1-label">Personal Info</p>
                            </div>
                            <div class="text-center flex-fill">
                                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-1" style="width: 36px; height: 36px; background-color: #dee2e6; color: #6c757d; font-weight: 700;" id="step2-indicator">2</div>
                                <p class="small mb-0 text-muted" id="step2-label">Professional Details</p>
                            </div>
                        </div>

                        <div class="progress mb-4" style="height: 6px;">
                            <div class="progress-bar" id="progress-bar" role="progressbar" style="width: 50%; background-color: var(--mint-green);" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
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

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
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
                                        <option value="Hyderabad" {{ old('city') == 'Hyderabad' ? 'selected' : '' }}>Hyderabad</option>
                                        <option value="Abbottabad" {{ old('city') == 'Abbottabad' ? 'selected' : '' }}>Abbottabad</option>
                                    </select>
                                    @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="dob" class="form-label fw-medium">Date of Birth</label>
                                    <input type="date" class="form-control @error('dob') is-invalid @enderror" id="dob" name="dob" value="{{ old('dob') }}" required>
                                    @error('dob') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="profile_photo" class="form-label fw-medium">Profile Photo</label>
                                <input type="file" class="form-control @error('profile_photo') is-invalid @enderror" id="profile_photo" name="profile_photo" accept="image/*" onchange="previewImage(this, 'profile-preview')">
                                @error('profile_photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <div class="mt-2">
                                    <img id="profile-preview" src="#" alt="Preview" class="rounded" style="max-width: 150px; max-height: 150px; display: none;">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="cnic" class="form-label fw-medium">CNIC Number</label>
                                <input type="text" class="form-control @error('cnic') is-invalid @enderror" id="cnic" name="cnic" value="{{ old('cnic') }}" placeholder="XXXXX-XXXXXXX-X" required>
                                @error('cnic') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="cnic_front" class="form-label fw-medium">CNIC Front</label>
                                    <input type="file" class="form-control @error('cnic_front') is-invalid @enderror" id="cnic_front" name="cnic_front" accept="image/*" onchange="previewImage(this, 'cnic-front-preview')">
                                    @error('cnic_front') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    <div class="mt-2">
                                        <img id="cnic-front-preview" src="#" alt="Preview" class="rounded" style="max-width: 150px; max-height: 150px; display: none;">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="cnic_back" class="form-label fw-medium">CNIC Back</label>
                                    <input type="file" class="form-control @error('cnic_back') is-invalid @enderror" id="cnic_back" name="cnic_back" accept="image/*" onchange="previewImage(this, 'cnic-back-preview')">
                                    @error('cnic_back') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    <div class="mt-2">
                                        <img id="cnic-back-preview" src="#" alt="Preview" class="rounded" style="max-width: 150px; max-height: 150px; display: none;">
                                    </div>
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
                                <label class="form-label fw-medium">Specializations</label>
                                <div class="d-flex flex-wrap gap-2">
                                    @php $specs = ['Newborn Care', 'Toddler Care', 'Special Needs', 'First Aid Certified', 'CPR Certified', 'Special Education', 'Montessori Trained', 'Nutrition Planning']; @endphp
                                    @foreach($specs as $spec)
                                    <div class="form-check">
                                        <input class="btn-check @error('specializations') is-invalid @enderror" type="checkbox" name="specializations[]" id="spec-{{ Str::slug($spec) }}" value="{{ $spec }}" autocomplete="off" {{ is_array(old('specializations')) && in_array($spec, old('specializations')) ? 'checked' : '' }}>
                                        <label class="btn btn-outline-secondary rounded-pill px-3" for="spec-{{ Str::slug($spec) }}" style="border-color: var(--mint-green); color: var(--dark-text);">
                                            {{ $spec }}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                                @error('specializations') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="experience" class="form-label fw-medium">Experience</label>
                                <textarea class="form-control @error('experience') is-invalid @enderror" id="experience" name="experience" rows="4" placeholder="Describe your babysitting experience..." required>{{ old('experience') }}</textarea>
                                @error('experience') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                        <label for="hourly_rate" class="form-label fw-medium">Hourly Rate (PKR)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rs.</span>
                                        <input type="number" class="form-control @error('hourly_rate') is-invalid @enderror" id="hourly_rate" name="hourly_rate" value="{{ old('hourly_rate') }}" min="0" step="0.01" required>
                                        @error('hourly_rate') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Availability</label>
                                    @error('availability') <div class="text-danger small mb-2">{{ $message }}</div> @enderror
                                    <div class="d-flex flex-wrap gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="availability[]" value="Weekdays" id="avail-weekdays" {{ is_array(old('availability')) && in_array('Weekdays', old('availability')) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="avail-weekdays">Weekdays</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="availability[]" value="Weekends" id="avail-weekends" {{ is_array(old('availability')) && in_array('Weekends', old('availability')) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="avail-weekends">Weekends</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="availability[]" value="Overnight" id="avail-overnight" {{ is_array(old('availability')) && in_array('Overnight', old('availability')) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="avail-overnight">Overnight</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="police_clearance" class="form-label fw-medium">Police Clearance Certificate</label>
                                <input type="file" class="form-control @error('police_clearance') is-invalid @enderror" id="police_clearance" name="police_clearance" accept="image/*,.pdf" onchange="previewImage(this, 'police-preview')">
                                @error('police_clearance') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <div class="mt-2">
                                    <img id="police-preview" src="#" alt="Preview" class="rounded" style="max-width: 150px; max-height: 150px; display: none;">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="training_cert" class="form-label fw-medium">Training Certificate</label>
                                <input type="file" class="form-control @error('training_cert') is-invalid @enderror" id="training_cert" name="training_cert" accept="image/*,.pdf" onchange="previewImage(this, 'training-preview')">
                                @error('training_cert') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <div class="mt-2">
                                    <img id="training-preview" src="#" alt="Preview" class="rounded" style="max-width: 150px; max-height: 150px; display: none;">
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-outline-secondary px-4" id="step2-prev" onclick="goToStep(1)">
                                    <i class="bi bi-arrow-left me-1"></i> Previous
                                </button>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bi bi-check-lg me-1"></i> Submit Application
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
        p1.style.backgroundColor = 'var(--mint-green)'; p1.style.color = 'var(--white)';
        p2.style.backgroundColor = '#dee2e6'; p2.style.color = '#6c757d';
        l1.classList.remove('text-muted'); l2.classList.add('text-muted');
        bar.style.width = '50%'; bar.setAttribute('aria-valuenow', '50');
    } else {
        p1.style.backgroundColor = '#dee2e6'; p1.style.color = '#6c757d';
        p2.style.backgroundColor = 'var(--mint-green)'; p2.style.color = 'var(--white)';
        l1.classList.add('text-muted'); l2.classList.remove('text-muted');
        bar.style.width = '100%'; bar.setAttribute('aria-valuenow', '100');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    var hasStep2Errors = {{ $errors->hasAny(['specializations', 'experience', 'hourly_rate', 'availability', 'police_clearance', 'training_cert']) ? 'true' : 'false' }};
    if (hasStep2Errors) {
        goToStep(2);
    }
});
</script>
@endpush
