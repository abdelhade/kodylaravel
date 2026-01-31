<?php

use Illuminate\Support\Facades\Route;
use Modules\Reports\Http\Controllers\ReportsController;
use App\Http\Controllers\LegacyController;

Route::middleware('check.auth')->group(function () {
    // Reports routes (Converted to Blade)
    Route::get('/reports', [ReportsController::class, 'index'])->name('reports.index');
    Route::get('/summary', [ReportsController::class, 'summary'])->name('reports.summary');
    Route::post('/summary', [ReportsController::class, 'summary'])->name('reports.summary.post');
    
    // Clinic Reports routes (Converted to Blade)
    Route::get('/reps_cl', [ReportsController::class, 'clinicReports'])->name('reps_cl');
});
