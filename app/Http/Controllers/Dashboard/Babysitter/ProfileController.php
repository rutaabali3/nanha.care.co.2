<?php

namespace App\Http\Controllers\Dashboard\Babysitter;

use App\Contracts\IBabysitterService;
use App\Contracts\IFileUploadService;
use App\Models\Profiles\BabysitterProfile;
use Illuminate\Http\Request;

class ProfileController
{
    public function __construct(
        protected IBabysitterService $babysitterService,
        protected IFileUploadService $fileUploadService
    ) {}

    public function index()
    {
        $profile = BabysitterProfile::where('user_id', auth()->id())->first();
        $completion = $this->babysitterService->getCompletionPercentage(auth()->id());

        return view('dashboard.babysitter.profile.index', compact('profile', 'completion'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'bio' => 'required|string',
            'hourly_rate' => 'required|numeric',
            'specializations' => 'required|array',
            'experience_years' => 'required|integer',
        ]);

        $profile = BabysitterProfile::where('user_id', auth()->id())->firstOrFail();

        if ($request->hasFile('avatar')) {
            $profile->avatar = $this->fileUploadService->save($request->file('avatar'), 'avatars');
        }

        if ($request->hasFile('certifications')) {
            $certPaths = [];
            foreach ($request->file('certifications') as $file) {
                $certPaths[] = $this->fileUploadService->save($file, 'certifications');
            }
        }

        $profile->update($request->only([
            'bio', 'hourly_rate', 'specializations', 'experience_years',
        ]));

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}
