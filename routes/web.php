<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MainDashboardController;
use App\Http\Controllers\LegacyController;

// Authentication routes
Route::get('/', [LoginController::class, 'showLoginForm'])->name('home');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard
Route::middleware('check.auth')->group(function () {
    Route::get('/dashboard', [MainDashboardController::class, 'index'])->name('dashboard.index');
    
    // Legacy routes for old pages
    Route::get('/legacy/{page}', [LegacyController::class, 'show'])->name('legacy');
});
