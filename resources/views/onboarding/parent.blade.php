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
                    <h2 class="fw-bold mb-1" style="color: var(--dark-text);">Join as a Parent</h2>
                    <p class="text-muted mb-4">Find trusted care for your little ones</p>

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

                    <form method="POST" action="{{ route('onboarding.parent') }}" enctype="multipart/form-data" novalidate>
                        @csrf

                        <div id="step-indicators" class="d-flex justify-content-between mb-4">
                            <div class="text-center flex-fill">
                                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-1" style="width: 36px; height: 36px; background-color: var(--sunshine-yellow); color: var(--white); font-weight: 700;" id="step1-indicator">1</div>
                                <p class="small mb-0 fw-medium" id="step1-label">Personal Info</p>
                            </div>
                            <div class="text-center flex-fill">
                                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-1" style="width: 36px; height: 36px; background-color: #dee2e6; color: #6c757d; font-weight: 700;" id="step2-indicator">2</div>
                                <p class="small mb-0 text-muted" id="step2-label">Family Details</p>
                            </div>
                        </div>

                        <div class="progress mb-4" style="height: 6px;">
                            <div class="progress-bar" id="progress-bar" role="progressbar" style="width: 50%; background-color: var(--sunshine-yellow);" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
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
                                    <option value="Sialkot" {{ old('city') == 'Sialkot' ? 'selected' : '' }}>Sialkot</option>
                                    <option value="Gujranwala" {{ old('city') == 'Gujranwala' ? 'selected' : '' }}>Gujranwala</option>
                                </select>
                                @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="profile_photo" class="form-label fw-medium">Profile Photo</label>
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
                            <h5 class="fw-semibold mb-3" style="color: var(--dark-text);">Step 2: Family Details</h5>

                            <div class="mb-3">
                                <label for="num_children" class="form-label fw-medium">Number of Children</label>
                                <select class="form-select @error('num_children') is-invalid @enderror" id="num_children" name="num_children" required>
                                    <option value="" disabled {{ old('num_children') ? '' : 'selected' }}>Select</option>
                                    <option value="1" {{ old('num_children') == '1' ? 'selected' : '' }}>1</option>
                                    <option value="2" {{ old('num_children') == '2' ? 'selected' : '' }}>2</option>
                                    <option value="3" {{ old('num_children') == '3' ? 'selected' : '' }}>3</option>
                                    <option value="4" {{ old('num_children') == '4' ? 'selected' : '' }}>4+</option>
                                </select>
                                @error('num_children') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-medium">Children Ages</label>
                                <div class="d-flex flex-wrap gap-3">
                                    @php $ages = ['0-1 year', '1-3 years', '3-5 years', '5-10 years', '10+']; @endphp
                                    @foreach($ages as $age)
                                    <div class="form-check">
                                        <input class="form-check-input @error('children_ages') is-invalid @enderror" type="checkbox" name="children_ages[]" value="{{ $age }}" id="age-{{ Str::slug($age) }}" {{ is_array(old('children_ages')) && in_array($age, old('children_ages')) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="age-{{ Str::slug($age) }}">{{ $age }}</label>
                                    </div>
                                    @endforeach
                                </div>
                                @error('children_ages') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="emergency_contact_name" class="form-label fw-medium">Emergency Contact Name</label>
                                    <input type="text" class="form-control @error('emergency_contact_name') is-invalid @enderror" id="emergency_contact_name" name="emergency_contact_name" value="{{ old('emergency_contact_name') }}" required>
                                    @error('emergency_contact_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="emergency_contact_phone" class="form-label fw-medium">Emergency Contact Phone</label>
                                    <input type="text" class="form-control @error('emergency_contact_phone') is-invalid @enderror" id="emergency_contact_phone" name="emergency_contact_phone" value="{{ old('emergency_contact_phone') }}" required>
                                    @error('emergency_contact_phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label fw-medium">Address</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="2" required>{{ old('address') }}</textarea>
                                @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="special_requirements" class="form-label fw-medium">Special Requirements <span class="text-muted">(optional)</span></label>
                                <textarea class="form-control @error('special_requirements') is-invalid @enderror" id="special_requirements" name="special_requirements" rows="3" placeholder="Any special needs or requirements for your children...">{{ old('special_requirements') }}</textarea>
                                @error('special_requirements') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-outline-secondary px-4" id="step2-prev" onclick="goToStep(1)">
                                    <i class="bi bi-arrow-left me-1"></i> Previous
                                </button>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bi bi-check-lg me-1"></i> Complete Registration
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
        p1.style.backgroundColor = 'var(--sunshine-yellow)'; p1.style.color = 'var(--white)';
        p2.style.backgroundColor = '#dee2e6'; p2.style.color = '#6c757d';
        l1.classList.remove('text-muted'); l2.classList.add('text-muted');
        bar.style.width = '50%'; bar.setAttribute('aria-valuenow', '50');
    } else {
        p1.style.backgroundColor = '#dee2e6'; p1.style.color = '#6c757d';
        p2.style.backgroundColor = 'var(--sunshine-yellow)'; p2.style.color = 'var(--white)';
        l1.classList.add('text-muted'); l2.classList.remove('text-muted');
        bar.style.width = '100%'; bar.setAttribute('aria-valuenow', '100');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    var hasStep2Errors = {{ $errors->hasAny(['num_children', 'children_ages', 'emergency_contact_name', 'emergency_contact_phone', 'address', 'special_requirements']) ? 'true' : 'false' }};
    if (hasStep2Errors) {
        goToStep(2);
    }
});
</script>
@endpush
