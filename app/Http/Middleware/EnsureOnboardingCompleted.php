<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureOnboardingCompleted
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();
            if (! $user->hasCompletedOnboarding()) {
                if ($request->expectsJson()) {
                    return response()->json(['error' => 'Onboarding not completed. Please complete registration.'], 403);
                }

                return redirect($user->onboardingRoute());
            }
        }

        return $next($request);
    }
}
