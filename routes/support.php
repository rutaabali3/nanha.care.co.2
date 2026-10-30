<?php

use App\Http\Controllers\Dashboard\Support\DashboardController;
use App\Http\Controllers\Dashboard\Support\EscalationsController;
use App\Http\Controllers\Dashboard\Support\FaqsController;
use App\Http\Controllers\Dashboard\Support\TicketsController;
use Illuminate\Support\Facades\Route;

Route::prefix('/dashboard/support')->middleware(['auth', 'role:support_agent'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('support.dashboard');

    Route::get('/tickets', [TicketsController::class, 'index'])->name('support.tickets.index');
    Route::get('/tickets/{id}', [TicketsController::class, 'details'])->name('support.tickets.details');
    Route::post('/tickets/{id}/reply', [TicketsController::class, 'reply'])->name('support.tickets.reply');
    Route::post('/tickets/{id}/assign', [TicketsController::class, 'assign'])->name('support.tickets.assign');
    Route::post('/tickets/bulk-close', [TicketsController::class, 'bulkClose'])->name('support.tickets.bulk-close');
    Route::post('/tickets/bulk-reassign', [TicketsController::class, 'bulkReassign'])->name('support.tickets.bulk-reassign');

    Route::get('/faqs', [FaqsController::class, 'index'])->name('support.faqs.index');
    Route::post('/faqs', [FaqsController::class, 'store'])->name('support.faqs.store');
    Route::post('/faqs/{id}', [FaqsController::class, 'update'])->name('support.faqs.update');
    Route::post('/faqs/{id}/delete', [FaqsController::class, 'destroy'])->name('support.faqs.destroy');
    Route::post('/faqs/reorder', [FaqsController::class, 'reorder'])->name('support.faqs.reorder');

    Route::get('/escalations', [EscalationsController::class, 'index'])->name('support.escalations.index');
    Route::post('/escalations/{id}/flag-admin', [EscalationsController::class, 'flagToAdmin'])->name('support.escalations.flag-admin');
});
