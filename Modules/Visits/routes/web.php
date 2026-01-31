<?php

use Illuminate\Support\Facades\Route;
use Modules\Visits\Http\Controllers\VisitsController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('visits', VisitsController::class)->names('visits');
});
