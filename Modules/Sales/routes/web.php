<?php

use Illuminate\Support\Facades\Route;
use Modules\Sales\Http\Controllers\SalesController;
use Modules\Sales\Http\Controllers\InvoiceController;
use Modules\Sales\Http\Controllers\SalesReportsController;
use App\Http\Controllers\LegacyController;

Route::middleware('check.auth')->group(function () {
    // Resource routes
    Route::resource('sales', SalesController::class)->names('sales');
    
    // Sales/Invoices routes (Partially converted - complex pages use LegacyController)
    Route::get('/sales', [InvoiceController::class, 'index'])->name('sales.index');
    Route::get('/sales/create', [InvoiceController::class, 'create'])->name('invoices.create');
    // Complex invoice handling still uses LegacyController
    Route::get('/sales/legacy', [LegacyController::class, 'handle'])->name('sales.legacy');
    Route::post('/sales/legacy', [LegacyController::class, 'handle'])->name('sales.legacy.post');
    
    // Sales Reports routes (Converted to Blade)
    Route::get('/sales-reports', [SalesReportsController::class, 'index'])->name('sales-reports.index');
    Route::get('/sales-by-day', [SalesReportsController::class, 'byDay'])->name('sales-reports.by-day');
    Route::post('/sales-by-day', [SalesReportsController::class, 'byDay'])->name('sales-reports.by-day');
    Route::get('/sales-by-hour', [SalesReportsController::class, 'byHour'])->name('sales-reports.by-hour');
    Route::post('/sales-by-hour', [SalesReportsController::class, 'byHour'])->name('sales-reports.by-hour');
    Route::get('/sales-by-week', [SalesReportsController::class, 'byWeek'])->name('sales-reports.by-week');
    Route::post('/sales-by-week', [SalesReportsController::class, 'byWeek'])->name('sales-reports.by-week');
    Route::get('/sales-by-month', [SalesReportsController::class, 'byMonth'])->name('sales-reports.by-month');
    Route::post('/sales-by-month', [SalesReportsController::class, 'byMonth'])->name('sales-reports.by-month');
    
    // Operations Summary route (Converted to Blade)
    Route::get('/operations_summary', [SalesReportsController::class, 'operationsSummary'])->name('operations_summary');
    Route::post('/operations_summary', [SalesReportsController::class, 'operationsSummary'])->name('operations_summary.post');
    
    // Items Summary route (Converted to Blade)
    Route::get('/items_summery', [SalesReportsController::class, 'itemsSummary'])->name('items_summery');
    Route::get('/items_summery', [LegacyController::class, 'handle'])->name('items_summery');
    Route::get('/top_products_report', [LegacyController::class, 'handle'])->name('top_products_report');
    Route::get('/stagnant-items-report', [LegacyController::class, 'handle'])->name('stagnant_items_report');
});
