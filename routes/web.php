<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MainDashboardController;
use App\Http\Controllers\BackupController;

// Authentication routes
Route::get('/', [LoginController::class, 'showLoginForm'])->name('home');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard
Route::middleware('check.auth')->group(function () {
    Route::get('/dashboard', [MainDashboardController::class, 'index'])->name('dashboard.index');
    
    // Backup routes
    Route::get('/backup', [BackupController::class, 'backup'])->name('backup');
    Route::get('/backup/list', [BackupController::class, 'index'])->name('backup.index');
    Route::get('/backup/download/{filename}', [BackupController::class, 'download'])->name('backup.download');
});
