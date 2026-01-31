<?php

use Illuminate\Support\Facades\Route;
use Modules\Kody2\Http\Controllers\AuthController;
use Modules\Kody2\Http\Controllers\Kody2Controller;
use Modules\Kody2\Http\Middleware\Kody2Auth;

Route::prefix('kody2')->middleware(['web', Kody2Auth::class])->group(function () {
    Route::get('/dashboard', [Kody2Controller::class, 'index'])->name('kody2.dashboard');
});
