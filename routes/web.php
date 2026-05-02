<?php
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