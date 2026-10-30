<?php

namespace App\Http\Controllers\Dashboard\Parent;

use App\Contracts\IFileUploadService;
use App\Models\System\AccountDeletionRequest;
use App\Models\System\NotificationPreference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SettingsController
{
    public function __construct(
        protected IFileUploadService $fileUploadService
    ) {}

    public function index()
    {
        $user = auth()->user();
        $notificationPrefs = NotificationPreference::where('user_id', $user->id)->first();

        return view('dashboard.parent.settings.index', compact('user', 'notificationPrefs'));
    }

    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = auth()->user();

        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $this->fileUploadService->save(
                $request->file('avatar'),
                'avatars'
            );
        }

        $user->update($validated);

        return redirect()->route('parent.settings.index')
            ->with('success', 'Profile updated successfully.');
    }

    public function changePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (! Hash::check($validated['current_password'], $user->password)) {
            return redirect()->back()->withErrors([
                'current_password' => 'Current password is incorrect.',
            ]);
        }

        $user->update([
            'password' => Hash::make($validated['new_password']),
        ]);

        return redirect()->route('parent.settings.index')
            ->with('success', 'Password changed successfully.');
    }

    public function updateNotificationPrefs(Request $request)
    {
        $validated = $request->validate([
            'email_notifications' => 'nullable|boolean',
            'sms_notifications' => 'nullable|boolean',
            'in_app_notifications' => 'nullable|boolean',
        ]);

        NotificationPreference::updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'email_notifications' => $validated['email_notifications'] ?? false,
                'sms_notifications' => $validated['sms_notifications'] ?? false,
                'in_app_notifications' => $validated['in_app_notifications'] ?? false,
            ]
        );

        return redirect()->route('parent.settings.index')
            ->with('success', 'Notification preferences updated.');
    }

    public function requestAccountDeletion(Request $request)
    {
        $validated = $request->validate([
            'reason' => 'required|string|max:1000',
        ]);

        AccountDeletionRequest::create([
            'user_id' => auth()->id(),
            'reason' => $validated['reason'],
            'status' => 'pending',
        ]);

        return redirect()->route('parent.settings.index')
            ->with('success', 'Account deletion request submitted. We will process it shortly.');
    }
}
