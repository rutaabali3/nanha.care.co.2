<?php

namespace App\Http\Controllers\Dashboard\Doctor;

use App\Contracts\IFileUploadService;
use App\Models\Profiles\DoctorProfile;
use Illuminate\Http\Request;

class ProfileController
{
    public function __construct(
        protected IFileUploadService $fileUploadService
    ) {}

    public function index()
    {
        $profile = DoctorProfile::where('user_id', auth()->id())->first();

        return view('dashboard.doctor.profile.index', compact('profile'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'specialization' => 'required|string|max:255',
            'hospital' => 'required|string|max:255',
            'pmdc_number' => 'required|string|max:50',
        ]);

        $userId = auth()->id();
        $profile = DoctorProfile::firstOrNew(['user_id' => $userId]);

        if ($request->hasFile('profile_photo')) {
            $request->validate(['profile_photo' => 'image|mimes:jpeg,png,webp|max:3072']);
            $validated['profile_photo'] = $this->fileUploadService->save(
                $request->file('profile_photo'), 'doctor_photos'
            );
        }

        $profile->fill($validated);
        $profile->user_id = $userId;
        $profile->save();

        return redirect()->route('doctor.profile.index')->with('success', 'Profile updated successfully.');
    }
}
