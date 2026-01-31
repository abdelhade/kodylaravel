<?php

use Illuminate\Support\Facades\Route;
use Modules\POS\Http\Controllers\POSController;
use Modules\POS\Http\Controllers\ClosedSessionController;
use App\Http\Controllers\LegacyController;

Route::middleware('check.auth')->group(function () {
    // Resource routes
    Route::resource('pos', POSController::class)->names('pos');
    
    // POS routes (Partially converted - complex pages use LegacyController)
    Route::get('/pos', [POSController::class, 'index'])->name('pos.index');
    Route::get('/pos/barcode-basic', [POSController::class, 'barcodeBasic'])->name('pos.barcode-basic');
    // Complex POS pages still use LegacyController
    Route::get('/pos_barcode', [LegacyController::class, 'handle'])->name('pos.barcode');
    Route::get('/pos/tables', [POSController::class, 'tables'])->name('pos.tables.view');
    Route::get('/pos/time', [POSController::class, 'timeBased'])->name('pos.time');
    Route::get('/crud_tables', [LegacyController::class, 'handle'])->name('pos.tables');
    
    // Closed Sessions routes (Converted to Blade)
    Route::get('/closed_sessions', [ClosedSessionController::class, 'index'])->name('pos.sessions');
    Route::post('/close_shift', [ClosedSessionController::class, 'close'])->name('pos.close-shift');
    Route::get('/close_shift', [ClosedSessionController::class, 'close'])->name('pos.close-shift.get'); // For GET requests from pos_barcode
    
    Route::get('/pos_po', [POSController::class, 'purchaseOrder'])->name('pos_po');
});
