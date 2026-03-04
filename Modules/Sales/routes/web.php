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
    Route::get('/invoice', [SalesController::class, 'saleInvoice'])->name('invoice');
    
    // أمر بيع
    Route::get('/order', [SalesController::class, 'saleOrder'])->name('order');
    
    // مردود مبيعات
    Route::get('/return', [SalesController::class, 'saleReturn'])->name('return');
    
    // عرض سعر
    Route::get('/quotation', [SalesController::class, 'quotation'])->name('quotation');
    
    // حفظ فاتورة
    Route::post('/store', [SalesController::class, 'store'])->name('store');
    
    // تعديل فاتورة
    Route::get('/edit/{id}', [SalesController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [SalesController::class, 'update'])->name('update');
    
    // حذف فاتورة
    Route::delete('/delete/{id}', [SalesController::class, 'destroy'])->name('destroy');
    
    // تحويل أمر بيع لفاتورة
    Route::post('/convert-to-invoice/{id}', [SalesController::class, 'convertToInvoice'])->name('convertToInvoice');
    
    // تحويل عرض سعر لفاتورة
    Route::post('/convert-quotation-to-invoice/{id}', [SalesController::class, 'convertQuotationToInvoice'])->name('convertQuotationToInvoice');
    
    // التقارير
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [\Modules\Sales\Http\Controllers\SalesReportsController::class, 'index'])->name('index');
        Route::match(['get', 'post'], '/by-day', [\Modules\Sales\Http\Controllers\SalesReportsController::class, 'byDay'])->name('by-day');
        Route::match(['get', 'post'], '/by-hour', [\Modules\Sales\Http\Controllers\SalesReportsController::class, 'byHour'])->name('by-hour');
        Route::match(['get', 'post'], '/by-week', [\Modules\Sales\Http\Controllers\SalesReportsController::class, 'byWeek'])->name('by-week');
        Route::match(['get', 'post'], '/by-month', [\Modules\Sales\Http\Controllers\SalesReportsController::class, 'byMonth'])->name('by-month');
        Route::get('/items-summary', [\Modules\Sales\Http\Controllers\SalesReportsController::class, 'itemsSummary'])->name('items-summary');
        Route::match(['get', 'post'], '/operations-summary', [\Modules\Sales\Http\Controllers\SalesReportsController::class, 'operationsSummary'])->name('operations-summary');
    });
});
