<?php

use Illuminate\Support\Facades\Route;
use Modules\Logs\Http\Controllers\LogsController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('logs', LogsController::class)->names('logs');
});
