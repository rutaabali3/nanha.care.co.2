<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\Doctor\DashboardController;
use App\Http\Controllers\Dashboard\Doctor\PostsController;
use App\Http\Controllers\Dashboard\Doctor\CommentsController;
use App\Http\Controllers\Dashboard\Doctor\AnalyticsController;
use App\Http\Controllers\Dashboard\Doctor\ProfileController;

Route::prefix('/dashboard/doctor')->middleware(['auth', 'role:doctor', 'onboarded'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('doctor.dashboard');

    Route::get('/posts', [PostsController::class, 'index'])->name('doctor.posts.index');
    Route::get('/posts/create', [PostsController::class, 'create'])->name('doctor.posts.create');
    Route::post('/posts', [PostsController::class, 'store'])->name('doctor.posts.store');
    Route::get('/posts/{id}/edit', [PostsController::class, 'edit'])->name('doctor.posts.edit');
    Route::post('/posts/{id}', [PostsController::class, 'update'])->name('doctor.posts.update');
    Route::post('/posts/{id}/delete', [PostsController::class, 'destroy'])->name('doctor.posts.destroy');

    Route::get('/comments', [CommentsController::class, 'index'])->name('doctor.comments.index');
    Route::post('/comments/{id}/reply', [CommentsController::class, 'reply'])->name('doctor.comments.reply');
    Route::post('/comments/{id}/flag', [CommentsController::class, 'flag'])->name('doctor.comments.flag');

    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('doctor.analytics.index');
    Route::get('/analytics/chart-data', [AnalyticsController::class, 'chartData'])->name('doctor.analytics.chart-data');

    Route::get('/profile', [ProfileController::class, 'index'])->name('doctor.profile.index');
    Route::post('/profile', [ProfileController::class, 'update'])->name('doctor.profile.update');
});
