<?php

use Illuminate\Support\Facades\Route;
use Modules\POS\Http\Controllers\POSController;
use Modules\POS\Http\Controllers\TableController;
use Modules\POS\Http\Controllers\ClosedSessionController;

Route::middleware('check.auth')->group(function () {
    // POS routes (Partially converted - complex pages use LegacyController)
    // Register explicit routes first so they don't get captured by the resource {pos} parameter
    Route::get('/pos', [POSController::class, 'index'])->name('pos.index');
    Route::get('/pos/barcode-basic', [POSController::class, 'barcodeBasic'])->name('pos.barcode-basic');
    Route::post('/pos/search-item', [POSController::class, 'searchItem'])->name('pos.search-item');
    Route::post('/pos/search-customer', [POSController::class, 'searchCustomerByPhone'])->name('pos.search-customer');
    Route::post('/pos/save-order', [POSController::class, 'saveOrder'])->name('pos.save-order');
    Route::get('/pos/recent-orders', [POSController::class, 'getRecentOrders'])->name('pos.recent-orders');
    Route::get('/pos/order/{id}/details', [POSController::class, 'getOrderDetails'])->name('pos.order.details');
    Route::delete('/pos/order/{id}', [POSController::class, 'deleteOrder'])->name('pos.order.delete');
    Route::delete('/pos/delete/{id}', [POSController::class, 'deleteOrder'])->name('pos.delete');
    Route::get('/pos/print/{id}', [POSController::class, 'printOrder'])->name('pos.print');
    
    // Closed Sessions routes - MUST be before resource routes
    Route::get('/closed_sessions', [ClosedSessionController::class, 'index'])->name('pos.closed-sessions.index');
    Route::get('/pos/closed-sessions/export', [ClosedSessionController::class, 'export'])->name('pos.closed-sessions.export');
    Route::get('/pos/closed-sessions/{session}', [ClosedSessionController::class, 'show'])->name('pos.closed-sessions.show');
    Route::get('/pos/closed-sessions', [ClosedSessionController::class, 'index'])->name('pos.sessions');
    Route::post('/close_shift', [ClosedSessionController::class, 'close'])->name('pos.close-shift');
    Route::get('/close_shift', [ClosedSessionController::class, 'close'])->name('pos.close-shift.get');
    
    // Tables Management Routes - MUST be before resource routes
    Route::get('/crud_tables', [TableController::class, 'index'])->name('pos.tables');
    Route::get('/pos/tables', [TableController::class, 'index'])->name('pos.tables.index');
    Route::post('/pos/tables', [TableController::class, 'store'])->name('pos.tables.store');
    Route::put('/pos/tables/{table}', [TableController::class, 'update'])->name('pos.tables.update');
    Route::delete('/pos/tables/{table}', [TableController::class, 'destroy'])->name('pos.tables.destroy');
    Route::post('/pos/tables/{table}/status', [TableController::class, 'updateStatus'])->name('pos.tables.status');
    
    // Complex POS pages
    Route::get('/pos_barcode', [POSController::class, 'barcode'])->name('pos.barcode');
    Route::get('/pos/time', [POSController::class, 'timeBased'])->name('pos.time');
    Route::get('/pos_po', [POSController::class, 'purchaseOrder'])->name('pos_po');
    
    // Resource routes - MUST be last to avoid conflicts
    Route::resource('pos', POSController::class)->except(['index'])->names('pos');
});
