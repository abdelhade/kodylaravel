<?php

use Illuminate\Support\Facades\Route;
use Modules\Production\Http\Controllers\ProductionController;
use App\Http\Controllers\LegacyController;

Route::middleware('check.auth')->group(function () {
    // Production routes (Converted to Blade)
    Route::get('/production', [ProductionController::class, 'index'])->name('production.index');
    Route::get('/add_production', [ProductionController::class, 'create'])->name('production.create');
    Route::post('/add_production', [ProductionController::class, 'store'])->name('production.store');
    Route::get('/edit_production', [ProductionController::class, 'edit'])->name('production.edit'); // Uses ?edit= query param
    Route::put('/edit_production/update', [ProductionController::class, 'update'])->name('production.update'); // Uses ?edit= query param
    Route::delete('/edit_production/delete', [ProductionController::class, 'destroy'])->name('production.destroy'); // Uses ?snd_id= query param
});
