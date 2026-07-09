<?php

namespace App\Http\Controllers;

use App\Contracts\IEmailService;
use App\Contracts\INotificationService;
use App\Enums\UserStatus;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function __construct(
        private readonly IEmailService $emailService,
        private readonly INotificationService $notificationService,
    ) {}

    public function loginForm()
    {
        if (auth()->check()) {
            return redirect($this->dashboardRoute());
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors(['email' => 'Invalid credentials']);
        }

        $user = auth()->user();

        if ($user->status === UserStatus::Banned) {
            Auth::logout();
            return redirect()->route('auth.suspended');
        }

        if (!$user->hasVerifiedEmail()) {
            Auth::logout();
            return redirect()->route('auth.check-email')->with('info', 'Please verify your email before logging in.');
        }

        if (!$user->getRoleNames()->first()) {
            return redirect()->route('auth.choose-role');
        }

        return redirect($this->dashboardRoute());
    }

    public function registerForm()
    {
        if (auth()->check()) {
            return redirect($this->dashboardRoute());
        }

        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'city' => $request->city,
            'status' => UserStatus::Active,
        ]);

        $user->sendEmailVerificationNotification();

        return redirect()->route('auth.check-email')->with('success', 'Account created. Check your email.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function confirmEmail(Request $request)
    {
        $user = User::findOrFail($request->route('id'));

        if (!hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            abort(403);
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        Auth::login($user);

        $roleName = $user->getRoleNames()->first();
        if (!$roleName) {
            return redirect()->route('auth.choose-role');
        }

        $role = str_replace('_', '-', $roleName);

        return redirect()->route('onboarding.' . $role);
    }

    public function checkEmail()
    {
        return view('auth.check-email');
    }

    public function resendVerification(Request $request)
    {
        auth()->user()->sendEmailVerificationNotification();

        return back()->with('success', 'Verification email resent.');
    }

    public function forgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        Password::sendResetLink(['email' => $request->email]);

        return back()->with('status', 'Password reset link sent to your email.');
    }

    public function resetPasswordForm(Request $request, $token)
    {
        return view('auth.reset-password', ['token' => $token, 'email' => $request->email]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('auth.login')->with('success', 'Password reset successfully.');
        }

        return back()->withErrors(['email' => [__($status)]]);
    }

    public function suspended()
    {
        return view('auth.suspended');
    }

    private function dashboardRoute(): string
    {
        $role = auth()->user()->getRoleNames()->first();

        return match ($role) {
            'admin' => '/dashboard/admin',
            'moderator' => '/dashboard/moderator',
            'parent' => '/dashboard/parent',
            'babysitter' => '/dashboard/babysitter',
            'shop_owner' => '/dashboard/shop-owner',
            'doctor' => '/dashboard/doctor',
            'support_agent' => '/dashboard/support',
            default => '/',
        };
    }

    public function chooseRoleForm()
    {
        if (auth()->user()->getRoleNames()->first()) {
            return redirect($this->dashboardRoute());
        }

        return view('auth.choose-role');
    }

    public function chooseRole(Request $request)
    {
        $request->validate([
            'role' => 'required|in:parent,babysitter,shop_owner,doctor',
        ]);

        $user = auth()->user();
        if ($user->getRoleNames()->first()) {
            return redirect($this->dashboardRoute());
        }

        $user->assignRole($request->role);
        
        $roleSlug = str_replace('_', '-', $request->role);

        return redirect()->route('onboarding.' . $roleSlug);
    }
}
