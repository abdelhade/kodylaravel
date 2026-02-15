<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MainDashboardController;
use App\Http\Controllers\LegacyController;
use Modules\POS\Http\Controllers\POSController;
use Modules\POS\Http\Controllers\ClosedSessionController;

// Authentication routes
Route::get('/', [LoginController::class, 'showLoginForm'])->name('home');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard
Route::middleware('check.auth')->group(function () {
    Route::get('/dashboard', [MainDashboardController::class, 'index'])->name('dashboard.index');
    
    // POS routes
    Route::get('/pos', [POSController::class, 'index'])->name('pos.index');
    Route::post('/pos/search-item', [POSController::class, 'searchItem'])->name('pos.search-item');
    Route::post('/pos/save-order', [POSController::class, 'saveOrder'])->name('pos.save-order');
    Route::get('/closed_sessions', [ClosedSessionController::class, 'index'])->name('pos.sessions');
    Route::post('/close_shift', [ClosedSessionController::class, 'close'])->name('pos.close-shift');
    
    // Legacy routes for old pages
    Route::get('/legacy/{page}', [LegacyController::class, 'show'])->name('legacy');
});
