<?php

use Illuminate\Support\Facades\Route;
use Modules\Purchases\Http\Controllers\PurchaseController;

Route::middleware('check.auth')->group(function () {
    // الصفحة الرئيسية للمشتريات
    Route::get('/purchases', [PurchaseController::class, 'index'])->name('purchases.index');
    
    // فواتير المشتريات والمبيعات
    Route::get('/sales', [PurchaseController::class, 'sales'])->name('sales');
    
    // باقي الروابط
    Route::get('/purchases/create', [PurchaseController::class, 'create'])->name('purchases.create');
    Route::get('/purchases/edit', [PurchaseController::class, 'edit'])->name('purchases.edit');
    Route::get('/pos_barcode', [PurchaseController::class, 'posBarcode'])->name('pos_barcode');
    Route::get('/pos_po', [PurchaseController::class, 'posPo'])->name('pos_po');
    Route::get('/crud_tables', [PurchaseController::class, 'crudTables'])->name('crud_tables');
    Route::get('/closed_sessions', [PurchaseController::class, 'closedSessions'])->name('closed_sessions');
    Route::get('/add_voucher', [PurchaseController::class, 'addVoucher'])->name('add_voucher');
    Route::get('/vouchers', [PurchaseController::class, 'vouchers'])->name('vouchers');
    Route::get('/sales-reports', [PurchaseController::class, 'salesReports'])->name('sales-reports');
    Route::get('/operations_summary', [PurchaseController::class, 'operationsSummary'])->name('operations_summary');
    Route::get('/items_summery', [PurchaseController::class, 'itemsSummary'])->name('items_summery');
});