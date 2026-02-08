<?php

use Illuminate\Support\Facades\Route;
use Modules\Sales\Http\Controllers\SalesController;

/*
|--------------------------------------------------------------------------
| Web Routes - Sales Module
|--------------------------------------------------------------------------
*/

Route::middleware(['web', 'check.auth'])->prefix('sales')->name('sales.')->group(function () {
    // قائمة الفواتير
    Route::get('/', [SalesController::class, 'index'])->name('index');
    
    // فاتورة مبيعات
    Route::get('/invoice', [SalesController::class, 'salesInvoice'])->name('invoice');
    
    // أمر بيع
    Route::get('/order', [SalesController::class, 'salesOrder'])->name('order');
    
    // عرض سعر
    Route::get('/quotation', [SalesController::class, 'quotation'])->name('quotation');
    
    // حفظ فاتورة
    Route::post('/store', [SalesController::class, 'store'])->name('store');
    
    // تعديل فاتورة
    Route::get('/edit/{id}', [SalesController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [SalesController::class, 'update'])->name('update');
    
    // حذف فاتورة
    Route::delete('/delete/{id}', [SalesController::class, 'destroy'])->name('destroy');
});
