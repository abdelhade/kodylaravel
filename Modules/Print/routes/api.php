<?php

use Illuminate\Support\Facades\Route;
use Modules\Print\Http\Controllers\PrintController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('prints', PrintController::class)->names('print');
});
