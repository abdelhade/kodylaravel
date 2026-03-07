<?php

use Illuminate\Support\Facades\Route;
use Modules\Clients\Http\Controllers\ClientsController;
use Modules\Clients\Http\Controllers\CallController;

Route::middleware('check.auth')->group(function () {
    // Clients Resource Routes
    Route::resource('clients', ClientsController::class);
    
    // Calls routes (Converted to Blade)
    Route::get('/calls', [CallController::class, 'index'])->name('calls.index');
    Route::get('/add_call', [CallController::class, 'create'])->name('calls.create');
    Route::post('/add_call', [CallController::class, 'store'])->name('calls.store');
    Route::delete('/calls/delete', [CallController::class, 'destroy'])->name('calls.destroy');
});
