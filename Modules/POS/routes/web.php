<?php

use Illuminate\Support\Facades\Route;
use Modules\POS\Http\Controllers\POSController;
use Modules\POS\Http\Controllers\TableController;
use Modules\POS\Http\Controllers\ClosedSessionController;

Route::middleware(['check.auth'])->group(function () {
    // POS الرئيسية
    Route::get('/pos', [POSController::class, 'index'])->name('pos.index');
    Route::post('/pos/search-item', [POSController::class, 'searchItem'])->name('pos.search-item');
    Route::post('/pos/add-item', [POSController::class, 'addItem'])->name('pos.add-item');
    Route::post('/pos/save-order', [POSController::class, 'saveOrder'])->name('pos.save-order');

    // إدارة الطاولات
    Route::resource('pos/tables', TableController::class, ['as' => 'pos']);
    Route::patch('/pos/tables/{table}/status', [TableController::class, 'updateStatus'])->name('pos.tables.update-status');

    // الجلسات المغلقة
    Route::get('/pos/closed-sessions', [ClosedSessionController::class, 'index'])->name('pos.closed-sessions.index');
    Route::post('/pos/close-shift', [ClosedSessionController::class, 'close'])->name('pos.close-shift');
    Route::get('/pos/closed-sessions/{session}', [ClosedSessionController::class, 'show'])->name('pos.closed-sessions.show');
    Route::get('/pos/closed-sessions/export/excel', [ClosedSessionController::class, 'export'])->name('pos.closed-sessions.export');
});
