<?php

use Illuminate\Support\Facades\Route;
use Modules\Clients\Http\Controllers\ClientsController;
use Modules\Clients\Http\Controllers\CallController;
use App\Http\Controllers\LegacyController;

Route::middleware('check.auth')->group(function () {
    // Clients Resource Routes
    Route::resource('clients', ClientsController::class);
    
    // Legacy profile route (not yet converted)
    Route::get('/clprofile', [LegacyController::class, 'handle'])->name('clients.profile');
    
    // Calls routes (Converted to Blade)
    Route::get('/calls', [CallController::class, 'index'])->name('calls.index');
    Route::get('/add_call', [CallController::class, 'create'])->name('calls.create');
    Route::post('/add_call', [CallController::class, 'store'])->name('calls.store');
    Route::delete('/calls/delete', [CallController::class, 'destroy'])->name('calls.destroy');
    
    // Legacy routes - CRM
    Route::get('/chances', [LegacyController::class, 'handle'])->name('chances');
    Route::get('/orders', [LegacyController::class, 'handle'])->name('orders');
    Route::get('/prints', [LegacyController::class, 'handle'])->name('prints');
    
    // Legacy routes - Booking
    Route::get('/add_booking', [LegacyController::class, 'handle'])->name('add_booking');
    Route::post('/add_booking', [LegacyController::class, 'handle'])->name('add_booking.post');
    Route::get('/booking', [LegacyController::class, 'handle'])->name('booking');
    Route::get('/bookings', [LegacyController::class, 'handle'])->name('bookings');
});
