<?php

use Illuminate\Support\Facades\Route;
use Modules\Print\Http\Controllers\PrintController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('prints', PrintController::class)->names('print');
});
