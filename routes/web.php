<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Admin Auth Routes
Route::prefix('admin')->name('admin.')->group(function () {
    
    // Guest routes (Login)
    Route::middleware('guest')->group(function () {
        Route::get('login', [AuthController::class, 'create'])->name('login');
        Route::post('login', [AuthController::class, 'store'])->name('login.store');
    });

    // Authenticated routes
    Route::middleware(['web', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
        Route::post('logout', [AuthController::class, 'destroy'])->name('logout');
        
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        
        // Stars Management
        Route::resource('stars', \App\Http\Controllers\Admin\StarController::class);

        // Rules Management
        Route::resource('rules', \App\Http\Controllers\Admin\RuleController::class);

        // Horoscopes Management
        Route::resource('horoscopes', \App\Http\Controllers\Admin\HoroscopeController::class);

        // Horoscope House Stars (API for manual setup)
        Route::post('horoscope-houses/{horoscopeHouse}/stars', [\App\Http\Controllers\Admin\HoroscopeHouseStarController::class, 'store'])->name('horoscope-houses.stars.store');
        Route::delete('horoscope-houses/{horoscopeHouse}/stars/{star}', [\App\Http\Controllers\Admin\HoroscopeHouseStarController::class, 'destroy'])->name('horoscope-houses.stars.destroy');
    });
});