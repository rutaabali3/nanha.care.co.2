<?php

use App\Http\Controllers\Dashboard\ShopOwner\DashboardController;
use App\Http\Controllers\Dashboard\ShopOwner\EarningsController;
use App\Http\Controllers\Dashboard\ShopOwner\OrdersController;
use App\Http\Controllers\Dashboard\ShopOwner\ProductsController;
use App\Http\Controllers\Dashboard\ShopOwner\ProfileController;
use App\Http\Controllers\Dashboard\ShopOwner\ReviewsController;
use Illuminate\Support\Facades\Route;

Route::prefix('/dashboard/shop-owner')->middleware(['auth', 'role:shop_owner', 'onboarded'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('shop-owner.dashboard');

    Route::get('/products', [ProductsController::class, 'index'])->name('shop-owner.products.index');
    Route::get('/products/create', [ProductsController::class, 'create'])->name('shop-owner.products.create');
    Route::post('/products', [ProductsController::class, 'store'])->name('shop-owner.products.store');
    Route::get('/products/{id}/edit', [ProductsController::class, 'edit'])->name('shop-owner.products.edit');
    Route::post('/products/{id}', [ProductsController::class, 'update'])->name('shop-owner.products.update');
    Route::post('/products/{id}/duplicate', [ProductsController::class, 'duplicate'])->name('shop-owner.products.duplicate');
    Route::post('/products/{id}/archive', [ProductsController::class, 'archive'])->name('shop-owner.products.archive');
    Route::post('/products/{id}/delete', [ProductsController::class, 'destroy'])->name('shop-owner.products.destroy');
    Route::post('/products/images/{id}/delete', [ProductsController::class, 'deleteImage'])->name('shop-owner.products.images.delete');

    Route::get('/orders', [OrdersController::class, 'index'])->name('shop-owner.orders.index');
    Route::post('/orders/{id}/status', [OrdersController::class, 'updateStatus'])->name('shop-owner.orders.status');
    Route::post('/orders/{id}/cancel', [OrdersController::class, 'cancel'])->name('shop-owner.orders.cancel');

    Route::get('/earnings', [EarningsController::class, 'index'])->name('shop-owner.earnings.index');
    Route::get('/earnings/chart-data', [EarningsController::class, 'chartData'])->name('shop-owner.earnings.chart-data');
    Route::post('/earnings/payout', [EarningsController::class, 'payoutRequest'])->name('shop-owner.earnings.payout');

    Route::get('/profile', [ProfileController::class, 'index'])->name('shop-owner.profile.index');
    Route::post('/profile', [ProfileController::class, 'update'])->name('shop-owner.profile.update');

    Route::get('/reviews', [ReviewsController::class, 'index'])->name('shop-owner.reviews.index');
    Route::post('/reviews/{id}/reply', [ReviewsController::class, 'reply'])->name('shop-owner.reviews.reply');
    Route::post('/reviews/{id}/flag', [ReviewsController::class, 'flag'])->name('shop-owner.reviews.flag');
});
