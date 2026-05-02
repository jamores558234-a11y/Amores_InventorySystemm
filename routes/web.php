<?php
<<<<<<< HEAD
// FILE PATH: routes/web.php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('dashboard'));

Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Products
    Route::resource('products', ProductController::class);
    Route::post('/products/{product}/stock-in',  [ProductController::class, 'stockIn'])->name('products.stock-in');
    Route::post('/products/{product}/stock-out', [ProductController::class, 'stockOut'])->name('products.stock-out');

    // Users (Admin only)
    Route::resource('users', UserController::class)->except(['show']);

    // Settings (Admin only)
    Route::get('/settings',          [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings/clear-cache', [SettingsController::class, 'clearCache'])->name('settings.clear-cache');
});

require __DIR__ . '/auth.php';
=======


use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('menu', MenuController::class);

    Route::resource('order', OrderController::class);

    Route::get('/payment', [PaymentController::class, 'index'])->name('payment.index');
    Route::get('/payment/create/{order}', [PaymentController::class, 'create'])->name('payment.create');
    Route::post('/payment', [PaymentController::class, 'store'])->name('payment.store');
    Route::get('/payment/{payment}', [PaymentController::class, 'show'])->name('payment.show');
    Route::get('/payment/history/{order}', [PaymentController::class, 'history'])->name('payment.history');

});

require __DIR__.'/auth.php';
>>>>>>> 65b51754ff66c222a1d9fdc027683d09d9afc9cc
