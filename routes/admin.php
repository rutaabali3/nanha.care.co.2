<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\Admin\DashboardController;
use App\Http\Controllers\Dashboard\Admin\UsersController;
use App\Http\Controllers\Dashboard\Admin\RolesController;
use App\Http\Controllers\Dashboard\Admin\ModerationController;
use App\Http\Controllers\Dashboard\Admin\ReportsController;
use App\Http\Controllers\Dashboard\Admin\SettingsController;
use App\Http\Controllers\Dashboard\Admin\RevenueController;
use App\Http\Controllers\Dashboard\Admin\AnnouncementsController;

Route::prefix('/dashboard/admin')->middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/users', [UsersController::class, 'index'])->name('admin.users.index');
    Route::get('/users/create', [UsersController::class, 'create'])->name('admin.users.create');
    Route::post('/users', [UsersController::class, 'store'])->name('admin.users.store');
    Route::get('/users/{id}', [UsersController::class, 'details'])->name('admin.users.details');
    Route::get('/users/{id}/edit', [UsersController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/{id}', [UsersController::class, 'update'])->name('admin.users.update');
    Route::post('/users/{id}/suspend', [UsersController::class, 'suspend'])->name('admin.users.suspend');
    Route::post('/users/{id}/ban', [UsersController::class, 'ban'])->name('admin.users.ban');
    Route::post('/users/{id}/restore', [UsersController::class, 'restore'])->name('admin.users.restore');
    Route::post('/users/{id}/delete', [UsersController::class, 'destroy'])->name('admin.users.destroy');

    Route::get('/roles', [RolesController::class, 'index'])->name('admin.roles.index');
    Route::post('/roles/assign', [RolesController::class, 'assign'])->name('admin.roles.assign');

    Route::get('/moderation', [ModerationController::class, 'index'])->name('admin.moderation.index');
    Route::post('/moderation/override/{logId}', [ModerationController::class, 'override'])->name('admin.moderation.override');

    Route::get('/reports', [ReportsController::class, 'index'])->name('admin.reports.index');
    Route::get('/reports/users-per-week', [ReportsController::class, 'usersPerWeek'])->name('admin.reports.users-per-week');
    Route::get('/reports/bookings-per-day', [ReportsController::class, 'bookingsPerDay'])->name('admin.reports.bookings-per-day');
    Route::get('/reports/top-products', [ReportsController::class, 'topProducts'])->name('admin.reports.top-products');
    Route::get('/reports/city-usage', [ReportsController::class, 'cityUsage'])->name('admin.reports.city-usage');
    Route::get('/reports/export', [ReportsController::class, 'export'])->name('admin.reports.export');

    Route::get('/settings', [SettingsController::class, 'index'])->name('admin.settings.index');
    Route::post('/settings', [SettingsController::class, 'save'])->name('admin.settings.save');

    Route::get('/revenue', [RevenueController::class, 'index'])->name('admin.revenue.index');

    Route::get('/announcements', [AnnouncementsController::class, 'index'])->name('admin.announcements.index');
    Route::get('/announcements/create', [AnnouncementsController::class, 'create'])->name('admin.announcements.create');
    Route::post('/announcements', [AnnouncementsController::class, 'store'])->name('admin.announcements.store');
});
