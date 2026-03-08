<?php

use Illuminate\Support\Facades\Route;
use Modules\Mobile\Http\Controllers\MobileController;
use Modules\Mobile\Http\Controllers\MobilePOSController;

/*
 * Mobile Module Web Routes
 */

Route::middleware('check.auth')->prefix('mobile')->name('mobile.')->group(function () {
    Route::get('/', [MobileController::class, 'index'])->name('index');
    
    // نقطة البيع المتنقلة
    Route::get('/pos', [MobilePOSController::class, 'index'])->name('pos.index');
    Route::post('/pos/search', [MobilePOSController::class, 'searchProduct'])->name('pos.search');
    Route::post('/pos/save', [MobilePOSController::class, 'saveInvoice'])->name('pos.save');
});
