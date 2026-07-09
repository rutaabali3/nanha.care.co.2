<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\Babysitter\DashboardController;
use App\Http\Controllers\Dashboard\Babysitter\BookingsController;
use App\Http\Controllers\Dashboard\Babysitter\ProfileController;
use App\Http\Controllers\Dashboard\Babysitter\EarningsController;
use App\Http\Controllers\Dashboard\Babysitter\ReviewsController;
use App\Http\Controllers\Dashboard\Babysitter\NotificationsController;

Route::prefix('/dashboard/babysitter')->middleware(['auth', 'role:babysitter', 'onboarded'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('babysitter.dashboard');

    Route::get('/bookings', [BookingsController::class, 'index'])->name('babysitter.bookings.index');
    Route::post('/bookings/{id}/accept', [BookingsController::class, 'accept'])->name('babysitter.bookings.accept');
    Route::post('/bookings/{id}/decline', [BookingsController::class, 'decline'])->name('babysitter.bookings.decline');
    Route::post('/bookings/{id}/complete', [BookingsController::class, 'complete'])->name('babysitter.bookings.complete');

    Route::get('/profile', [ProfileController::class, 'index'])->name('babysitter.profile.index');
    Route::post('/profile', [ProfileController::class, 'update'])->name('babysitter.profile.update');

    Route::get('/earnings', [EarningsController::class, 'index'])->name('babysitter.earnings.index');
    Route::get('/earnings/chart-data', [EarningsController::class, 'chartData'])->name('babysitter.earnings.chart-data');
    Route::post('/earnings/payout', [EarningsController::class, 'payoutRequest'])->name('babysitter.earnings.payout');

    Route::get('/reviews', [ReviewsController::class, 'index'])->name('babysitter.reviews.index');
    Route::post('/reviews/{id}/reply', [ReviewsController::class, 'reply'])->name('babysitter.reviews.reply');
    Route::post('/reviews/{id}/flag', [ReviewsController::class, 'flag'])->name('babysitter.reviews.flag');

    Route::get('/notifications', [NotificationsController::class, 'index'])->name('babysitter.notifications.index');
});
