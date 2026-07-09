<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\Parent\DashboardController;
use App\Http\Controllers\Dashboard\Parent\BookingsController;
use App\Http\Controllers\Dashboard\Parent\OrdersController;
use App\Http\Controllers\Dashboard\Parent\ChildrenController;
use App\Http\Controllers\Dashboard\Parent\SavedBabysittersController;
use App\Http\Controllers\Dashboard\Parent\BookmarksController;
use App\Http\Controllers\Dashboard\Parent\SettingsController;

Route::prefix('/dashboard/parent')->middleware(['auth', 'role:parent', 'onboarded'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('parent.dashboard');

    Route::get('/bookings', [BookingsController::class, 'index'])->name('parent.bookings.index');
    Route::get('/bookings/{id}/review', [BookingsController::class, 'reviewForm'])->name('parent.bookings.review-form');
    Route::post('/bookings/{id}/review', [BookingsController::class, 'storeReview'])->name('parent.bookings.review');
    Route::post('/bookings/{id}/report', [BookingsController::class, 'reportIssue'])->name('parent.bookings.report');

    Route::get('/orders', [OrdersController::class, 'index'])->name('parent.orders.index');
    Route::get('/orders/{id}', [OrdersController::class, 'details'])->name('parent.orders.details');
    Route::post('/orders/{id}/return', [OrdersController::class, 'requestReturn'])->name('parent.orders.return');

    Route::get('/children', [ChildrenController::class, 'index'])->name('parent.children.index');
    Route::post('/children', [ChildrenController::class, 'store'])->name('parent.children.store');
    Route::put('/children/{id}', [ChildrenController::class, 'update'])->name('parent.children.update');
    Route::delete('/children/{id}', [ChildrenController::class, 'destroy'])->name('parent.children.destroy');

    Route::get('/saved-babysitters', [SavedBabysittersController::class, 'index'])->name('parent.saved-babysitters.index');
    Route::post('/saved-babysitters/{id}', [SavedBabysittersController::class, 'save'])->name('parent.saved-babysitters.save');
    Route::post('/saved-babysitters/{id}/remove', [SavedBabysittersController::class, 'remove'])->name('parent.saved-babysitters.remove');

    Route::get('/bookmarks', [BookmarksController::class, 'index'])->name('parent.bookmarks.index');
    Route::post('/bookmarks/{id}', [BookmarksController::class, 'save'])->name('parent.bookmarks.save');
    Route::post('/bookmarks/{id}/remove', [BookmarksController::class, 'remove'])->name('parent.bookmarks.remove');

    Route::get('/settings', [SettingsController::class, 'index'])->name('parent.settings.index');
    Route::post('/settings/profile', [SettingsController::class, 'updateProfile'])->name('parent.settings.profile');
    Route::post('/settings/password', [SettingsController::class, 'changePassword'])->name('parent.settings.password');
    Route::post('/settings/notifications', [SettingsController::class, 'updateNotificationPrefs'])->name('parent.settings.notifications');
    Route::post('/settings/delete-account', [SettingsController::class, 'requestAccountDeletion'])->name('parent.settings.delete-account');
});
