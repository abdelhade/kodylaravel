<?php

use Illuminate\Support\Facades\Route;
use Modules\Settings\Http\Controllers\SettingsController;
use Modules\Settings\Http\Controllers\TownController;
use Modules\Settings\Http\Controllers\AboutController;
use App\Http\Controllers\LegacyController;

Route::middleware('check.auth')->group(function () {
    // Resource routes
    Route::resource('settings', SettingsController::class)->names('settings');
    
    // Towns routes (Converted to Blade)
    Route::get('/mytowns', [TownController::class, 'index'])->name('towns.index');
    Route::post('/mytowns', [TownController::class, 'store'])->name('towns.store');
    Route::put('/mytowns/update', [TownController::class, 'update'])->name('towns.update'); // Uses ?id= query param
    Route::delete('/mytowns/delete', [TownController::class, 'destroy'])->name('towns.destroy'); // Uses ?id= query param
    
    // Settings routes (Converted to Blade)
    Route::get('/setting', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('/setting/update', [SettingsController::class, 'update'])->name('settings.update');
    
    // About routes (Converted to Blade)
    Route::get('/about', [AboutController::class, 'index'])->name('about.index');
    Route::post('/about/truncate', [AboutController::class, 'truncate'])->name('about.truncate');
    Route::post('/about/finish', [AboutController::class, 'finish'])->name('about.finish');
});
