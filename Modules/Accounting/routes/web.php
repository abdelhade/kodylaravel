<?php

use Illuminate\Support\Facades\Route;
use Modules\Accounting\Http\Controllers\AccountingController;
use Modules\Accounting\Http\Controllers\AccountController;
use Modules\Accounting\Http\Controllers\VoucherController;
use Modules\Accounting\Http\Controllers\JournalController;
use Modules\Accounting\Http\Controllers\StartBalanceController;
use Modules\Accounting\Http\Controllers\AccountReportController;
use Modules\Accounting\Http\Controllers\RentController;
use App\Http\Controllers\LegacyController;

Route::middleware('check.auth')->group(function () {
    // Resource routes
    Route::resource('accountings', AccountingController::class)->names('accounting');
    Route::resource('accounts', AccountController::class)->names('accounts');
    
    // Accounts routes (Converted to Blade)
    Route::get('/accounts/check-name', [AccountController::class, 'checkName'])->name('accounts.check-name'); // AJAX endpoint - must be before /accounts
    Route::get('/accounts', [AccountController::class, 'index'])->name('accounts.index');
    Route::get('/add_account', [AccountController::class, 'create'])->name('accounts.create');
    Route::post('/add_account', [AccountController::class, 'store'])->name('accounts.store');
    Route::get('/edit_account', [AccountController::class, 'edit'])->name('accounts.edit'); // Uses ?id= query param
    Route::put('/edit_account/update', [AccountController::class, 'update'])->name('accounts.update'); // Uses ?id= query param
    Route::get('/edit_account/delete', [AccountController::class, 'destroy'])->name('accounts.destroy'); // Uses ?id= query param
    
    // Journals routes (Converted to Blade)
    Route::get('/daily_journal', [JournalController::class, 'index'])->name('journals.index');
    Route::get('/add_journal', [JournalController::class, 'create'])->name('journals.create');
    Route::post('/add_journal', [JournalController::class, 'store'])->name('journals.store');
    Route::get('/add_journal/edit', [JournalController::class, 'edit'])->name('journals.edit'); // Uses ?id= query param
    Route::put('/add_journal/update', [JournalController::class, 'update'])->name('journals.update'); // Uses ?id= query param
    Route::get('/add_journal/delete', [JournalController::class, 'destroy'])->name('journals.destroy'); // Uses ?id= query param
    
    // Multi Journal routes (Converted to Blade)
    Route::get('/addmulti_journal', [JournalController::class, 'createMulti'])->name('journals.create-multi');
    Route::post('/addmulti_journal', [JournalController::class, 'storeMulti'])->name('journals.store-multi');
    
    // Start Balance routes (Converted to Blade)
    Route::get('/start_balance', [StartBalanceController::class, 'index'])->name('start-balance.index');
    Route::post('/start_balance', [StartBalanceController::class, 'store'])->name('start-balance.store');
    
    // Account Report routes (Converted to Blade)
    Route::get('/acc_report', [AccountReportController::class, 'index'])->name('acc-report.index'); // Uses ?acc= query param
    
    // Legacy routes - الحسابات العامه
    Route::get('/items_start_balance', [LegacyController::class, 'handle'])->name('items_start_balance');
    
    // Vouchers routes (Converted to Blade)
    Route::get('/vouchers', [VoucherController::class, 'index'])->name('vouchers.index');
    Route::get('/add_voucher', [VoucherController::class, 'create'])->name('vouchers.create');
    Route::post('/add_voucher', [VoucherController::class, 'store'])->name('vouchers.store');
    Route::get('/add_voucher/edit', [VoucherController::class, 'edit'])->name('vouchers.edit'); // Uses ?edit= query param
    Route::put('/add_voucher/update', [VoucherController::class, 'update'])->name('vouchers.update'); // Uses ?id= query param
    Route::get('/add_voucher/delete', [VoucherController::class, 'destroy'])->name('vouchers.destroy'); // Uses ?id= query param
    
    // Legacy routes - التقارير (الحسابات)
    Route::get('/summary', [LegacyController::class, 'handle'])->name('summary');
    
    // Rents routes (Converted to Blade)
    Route::get('/rentables', [RentController::class, 'index'])->name('rents.index');
    Route::get('/myrentables', [RentController::class, 'installments'])->name('rents.installments');
    Route::get('/add_rent', [RentController::class, 'create'])->name('rents.create'); // Uses ?id= query param for editing
    Route::post('/add_rent', [RentController::class, 'store'])->name('rents.store');
    Route::delete('/rents/delete', [RentController::class, 'destroy'])->name('rents.destroy'); // Uses ?id= and ?r= query params
});
