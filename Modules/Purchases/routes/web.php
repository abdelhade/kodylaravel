<?php

use Illuminate\Support\Facades\Route;
use Modules\Purchases\Http\Controllers\PurchasesController;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes - Purchases Module
|--------------------------------------------------------------------------
*/

Route::middleware(['web', 'check.auth'])->prefix('purchases')->name('purchases.')->group(function () {
    // قائمة الفواتير
    Route::get('/', [PurchasesController::class, 'index'])->name('index');
    
    // فاتورة مشتريات
    Route::get('/invoice', [PurchasesController::class, 'purchaseInvoice'])->name('invoice');
    
    // فاتورة مردود مشتريات
    Route::get('/return', [PurchasesController::class, 'purchaseReturn'])->name('return');
    
    // أمر شراء
    Route::get('/order', [PurchasesController::class, 'purchaseOrder'])->name('order');
    
    // حفظ فاتورة
    Route::post('/store', [PurchasesController::class, 'store'])->name('store');
    
    // تعديل فاتورة
    Route::get('/edit/{id}', [PurchasesController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [PurchasesController::class, 'update'])->name('update');
    
    // حذف فاتورة
    Route::delete('/delete/{id}', [PurchasesController::class, 'destroy'])->name('destroy');
    
    // التقارير
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [\Modules\Purchases\Http\Controllers\PurchaseReportsController::class, 'index'])->name('index');
        Route::get('/daily', [\Modules\Purchases\Http\Controllers\PurchaseReportsController::class, 'dailyReport'])->name('daily');
        Route::get('/items', [\Modules\Purchases\Http\Controllers\PurchaseReportsController::class, 'itemsReport'])->name('items');
        Route::get('/suppliers', [\Modules\Purchases\Http\Controllers\PurchaseReportsController::class, 'suppliersReport'])->name('suppliers');
    });
});

// API routes
Route::middleware(['web', 'check.auth'])->prefix('api')->group(function () {
    Route::get('/store-inventory/{storeId}', [PurchasesController::class, 'getStoreInventory']);
});
