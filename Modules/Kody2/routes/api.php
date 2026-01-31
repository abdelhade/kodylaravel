<?php

use Illuminate\Support\Facades\Route;
use Modules\Kody2\Http\Controllers\Kody2Controller;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('kody2s', Kody2Controller::class)->names('kody2');
});
