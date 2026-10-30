<?php

use App\Http\Controllers\Dashboard\Moderator\ActivityController;
use App\Http\Controllers\Dashboard\Moderator\DashboardController;
use App\Http\Controllers\Dashboard\Moderator\FlaggedController;
use App\Http\Controllers\Dashboard\Moderator\PublishedController;
use App\Http\Controllers\Dashboard\Moderator\QueueController;
use App\Http\Controllers\Dashboard\Moderator\ReportsController;
use Illuminate\Support\Facades\Route;

Route::prefix('/dashboard/moderator')->middleware(['auth', 'role:moderator'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('moderator.dashboard');

    Route::get('/queue', [QueueController::class, 'index'])->name('moderator.queue.index');
    Route::post('/queue/approve/{type}/{id}', [QueueController::class, 'approve'])->name('moderator.queue.approve');
    Route::post('/queue/reject/{type}/{id}', [QueueController::class, 'reject'])->name('moderator.queue.reject');
    Route::post('/queue/revise/{type}/{id}', [QueueController::class, 'requestRevision'])->name('moderator.queue.revise');

    Route::get('/published', [PublishedController::class, 'index'])->name('moderator.published.index');
    Route::post('/published/unpublish/{type}/{id}', [PublishedController::class, 'unpublish'])->name('moderator.published.unpublish');

    Route::get('/flagged', [FlaggedController::class, 'index'])->name('moderator.flagged.index');
    Route::post('/flagged/dismiss/{id}', [FlaggedController::class, 'dismiss'])->name('moderator.flagged.dismiss');
    Route::post('/flagged/unpublish/{id}', [FlaggedController::class, 'unpublish'])->name('moderator.flagged.unpublish');
    Route::post('/flagged/escalate/{id}', [FlaggedController::class, 'escalate'])->name('moderator.flagged.escalate');

    Route::get('/reports', [ReportsController::class, 'index'])->name('moderator.reports.index');
    Route::post('/reports/{id}/warn', [ReportsController::class, 'warn'])->name('moderator.reports.warn');
    Route::post('/reports/{id}/resolve', [ReportsController::class, 'resolve'])->name('moderator.reports.resolve');

    Route::get('/activity', [ActivityController::class, 'index'])->name('moderator.activity.index');
});
