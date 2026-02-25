<?php

use Illuminate\Support\Facades\Route;
use Modules\Voucher\Http\Controllers\VoucherController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['web', 'check.auth'])->prefix('voucher')->name('voucher.')->group(function () {
    Route::get('/', [VoucherController::class, 'index'])->name('index');
    Route::get('/create', [VoucherController::class, 'create'])->name('create');
    Route::post('/store', [VoucherController::class, 'store'])->name('store');
    Route::get('/show/{id}', [VoucherController::class, 'show'])->name('show');
    Route::get('/edit/{id}', [VoucherController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [VoucherController::class, 'update'])->name('update');
    Route::delete('/destroy/{id}', [VoucherController::class, 'destroy'])->name('destroy');
});
