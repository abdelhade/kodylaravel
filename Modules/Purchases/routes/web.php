<?php

use Illuminate\Support\Facades\Route;
use Modules\Purchases\Http\Controllers\PurchasesController;

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
});
