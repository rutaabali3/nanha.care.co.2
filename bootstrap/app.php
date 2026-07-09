<?php

use App\Http\Middleware\BanCheckMiddleware;
use App\Http\Middleware\MaintenanceModeMiddleware;
use App\Http\Middleware\RoleAreaGuardMiddleware;
use App\Providers\EventServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectGuestsTo(fn () => route('auth.login'));

        $middleware->alias([
            'maintenance' => MaintenanceModeMiddleware::class,
            'bancheck' => BanCheckMiddleware::class,
            'rolearea' => RoleAreaGuardMiddleware::class,
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'onboarded' => \App\Http\Middleware\EnsureOnboardingCompleted::class,
        ]);

        $middleware->append([
            BanCheckMiddleware::class,
            MaintenanceModeMiddleware::class,
        ]);
    })
    ->withSchedule(function (Schedule $schedule) {
        $schedule->command('nanhacare:process-announcements')->everyFiveMinutes();
    })
    ->withProviders([
        EventServiceProvider::class,
    ])
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
