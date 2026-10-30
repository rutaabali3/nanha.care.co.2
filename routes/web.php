<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BabysittersController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/training', [HomeController::class, 'training'])->name('training');

Route::get('/babysitters', [BabysittersController::class, 'index'])->name('babysitters.index');
Route::get('/babysitters/{id}', [BabysittersController::class, 'profile'])->name('babysitters.profile');

Route::get('/marketplace', [MarketplaceController::class, 'index'])->name('marketplace.index');
Route::get('/marketplace/product/{id}', [MarketplaceController::class, 'detail'])->name('marketplace.detail');

Route::get('/shop/{slug}', [ShopController::class, 'public'])->name('shop.show');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'detail'])->name('blog.detail');
Route::post('/blog/{id}/comment', [BlogController::class, 'addComment'])->name('blog.comment')->middleware(['auth', 'onboarded']);

Route::get('/cart', [CartController::class, 'index'])->name('cart.index')->middleware('onboarded');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add')->middleware('onboarded');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove')->middleware('onboarded');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update')->middleware('onboarded');
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout')->middleware(['auth', 'role:parent', 'onboarded']);
Route::post('/checkout', [CartController::class, 'placeOrder'])->middleware(['auth', 'role:parent', 'onboarded']);

Route::get('/auth/login', [AuthController::class, 'loginForm'])->name('auth.login');
Route::post('/auth/login', [AuthController::class, 'login']);
Route::get('/auth/register', [AuthController::class, 'registerForm'])->name('auth.register');
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::get('/auth/confirm-email', [AuthController::class, 'checkEmail'])->name('auth.confirm-email');
Route::get('/auth/check-email', [AuthController::class, 'checkEmail'])->name('auth.check-email');
Route::get('/auth/forgot-password', [AuthController::class, 'forgotPasswordForm'])->name('auth.forgot-password');
Route::post('/auth/forgot-password', [AuthController::class, 'forgotPassword']);
Route::get('/auth/reset-password/{token}', [AuthController::class, 'resetPasswordForm'])->name('password.reset');
Route::post('/auth/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
Route::get('/auth/suspended', [AuthController::class, 'suspended'])->name('auth.suspended');

Route::get('email/verify/{id}/{hash}', [AuthController::class, 'confirmEmail'])
    ->name('verification.verify')
    ->middleware('signed');

Route::prefix('email')->middleware('auth')->group(function () {
    Route::get('verify', [AuthController::class, 'checkEmail'])->name('verification.notice');
    Route::post('resend', [AuthController::class, 'resendVerification'])->name('verification.resend');
});

Route::get('/auth/choose-role', [AuthController::class, 'chooseRoleForm'])->name('auth.choose-role')->middleware('auth');
Route::post('/auth/choose-role', [AuthController::class, 'chooseRole'])->middleware('auth');

Route::get('/onboarding/babysitter', [OnboardingController::class, 'babysitter'])->name('onboarding.babysitter')->middleware('auth');
Route::post('/onboarding/babysitter', [OnboardingController::class, 'saveBabysitter'])->middleware('auth');
Route::get('/onboarding/shop-owner', [OnboardingController::class, 'shopOwner'])->name('onboarding.shop-owner')->middleware('auth');
Route::post('/onboarding/shop-owner', [OnboardingController::class, 'saveShopOwner'])->middleware('auth');
Route::get('/onboarding/doctor', [OnboardingController::class, 'doctor'])->name('onboarding.doctor')->middleware('auth');
Route::post('/onboarding/doctor', [OnboardingController::class, 'saveDoctor'])->middleware('auth');
Route::get('/onboarding/parent', [OnboardingController::class, 'parent'])->name('onboarding.parent')->middleware('auth');
Route::post('/onboarding/parent', [OnboardingController::class, 'saveParent'])->middleware('auth');

Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

Route::get('/notifications', [NotificationsController::class, 'index'])->name('notifications.index')->middleware('auth');
Route::post('/notifications/mark-read/{id}', [NotificationsController::class, 'markRead'])->name('notifications.mark-read')->middleware('auth');
Route::post('/notifications/mark-all-read', [NotificationsController::class, 'markAllRead'])->name('notifications.mark-all-read')->middleware('auth');
Route::post('/notifications/delete/{id}', [NotificationsController::class, 'delete'])->name('notifications.delete')->middleware('auth');

require __DIR__.'/admin.php';
require __DIR__.'/moderator.php';
require __DIR__.'/babysitter.php';
require __DIR__.'/parent.php';
require __DIR__.'/shop-owner.php';
require __DIR__.'/doctor.php';
require __DIR__.'/support.php';
