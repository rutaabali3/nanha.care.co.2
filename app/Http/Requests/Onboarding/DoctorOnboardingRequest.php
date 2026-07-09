<?php

namespace App\Http\Requests\Onboarding;

use Illuminate\Foundation\Http\FormRequest;

class DoctorOnboardingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'city' => 'required|string|max:100',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'pmdc_number' => 'required|string|max:50',
            'specialization' => 'required|string|max:100',
            'clinic_name' => 'required|string|max:200',
            'years_experience' => 'required|integer|min:0|max:70',
            'clinic_address' => 'nullable|string|max:500',
            'medical_license' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'pmdc_cert' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'cv' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ];
    }
}
