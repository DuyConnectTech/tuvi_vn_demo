<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/', [\App\Http\Controllers\Client\HoroscopeController::class, 'create'])->name('home');
Route::post('/lap-la-so', [\App\Http\Controllers\Client\HoroscopeController::class, 'store'])->name('client.horoscopes.store');

// Public Horoscope View
Route::get('/la-so/{slug}', [\App\Http\Controllers\Client\HoroscopeController::class, 'show'])->name('client.horoscopes.show');

// Test Route (keep for reference or remove later)
Route::get('/test-calendar', function () {
    $s = new \App\Services\Horoscope\CalendarService();
    $l = $s->toLunar('2004-03-18 12:00:00');
    return [
        'date' => $l->format('Y-m-d'),
        'can_chi' => $s->getCanChi($l)
    ];
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

        // Users Management
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);

        // Glossaries Management
        Route::resource('glossaries', \App\Http\Controllers\Admin\GlossaryController::class);

        // Tags Management
        Route::resource('tags', \App\Http\Controllers\Admin\TagController::class);

        // Horoscope House Stars (API for manual setup)
        Route::post('horoscope-houses/{horoscopeHouse}/stars', [\App\Http\Controllers\Admin\HoroscopeHouseStarController::class, 'store'])->name('horoscope-houses.stars.store');
        Route::delete('horoscope-houses/{horoscopeHouse}/stars/{star}', [\App\Http\Controllers\Admin\HoroscopeHouseStarController::class, 'destroy'])->name('horoscope-houses.stars.destroy');
    });
});