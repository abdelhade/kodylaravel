<?php

use Illuminate\Support\Facades\Route;
use Modules\Attendance\Http\Controllers\AttendanceController;
use Modules\Attendance\Http\Controllers\ManualAttendanceController;
use Modules\Attendance\Http\Controllers\SalaryController;
use Modules\Attendance\Http\Controllers\AllowanceController;
use Modules\Attendance\Http\Controllers\ImportFPLogController;
use Modules\Attendance\Http\Controllers\MachineLogController;
use Modules\Attendance\Http\Controllers\ScanAttendanceController;
use Modules\Attendance\Http\Controllers\PermitController;
use App\Http\Controllers\LegacyController;

Route::middleware('check.auth')->group(function () {
    // Resource routes
    Route::resource('attendances', AttendanceController::class)->names('attendance');
    
    // Manual Attendance routes (Converted to Blade)
    Route::get('/manualattandance', [ManualAttendanceController::class, 'index'])->name('manual-attendance.index');
    Route::post('/manualattandance', [ManualAttendanceController::class, 'index'])->name('manual-attendance.index'); // For filtering
    Route::get('/add_manualfp', [ManualAttendanceController::class, 'create'])->name('manual-attendance.create');
    Route::post('/add_manualfp', [ManualAttendanceController::class, 'store'])->name('manual-attendance.store');
    Route::get('/edit_manualfp', [ManualAttendanceController::class, 'edit'])->name('manual-attendance.edit'); // Uses ?id= query param
    Route::put('/edit_manualfp/update', [ManualAttendanceController::class, 'update'])->name('manual-attendance.update'); // Uses ?id= query param
    Route::delete('/edit_manualfp/delete', [ManualAttendanceController::class, 'destroy'])->name('manual-attendance.destroy'); // Uses ?id= query param
    
    // Salary routes (Converted to Blade)
    Route::get('/calcsalary', [SalaryController::class, 'index'])->name('salary.index');
    Route::get('/add_calcsalary', [SalaryController::class, 'create'])->name('salary.create');
    Route::post('/add_calcsalary', [LegacyController::class, 'handle'])->name('salary.calculate'); // Complex calculation - legacy for now
    Route::post('/add_calcgroup', [LegacyController::class, 'handle'])->name('salary.calculate-group'); // Complex calculation - legacy for now
    Route::get('/calcsalary/delete', [SalaryController::class, 'destroy'])->name('salary.destroy'); // Uses ?doc= query param
    
    // Allowances routes (Converted to Blade)
    Route::get('/allowences', [AllowanceController::class, 'index'])->name('allowances.index');
    Route::get('/add_allowances', [AllowanceController::class, 'create'])->name('allowances.create');
    Route::post('/add_allowances', [AllowanceController::class, 'store'])->name('allowances.store');
    Route::get('/edit_allowances', [AllowanceController::class, 'edit'])->name('allowances.edit'); // Uses ?id= query param
    Route::put('/edit_allowances/update', [AllowanceController::class, 'update'])->name('allowances.update'); // Uses ?id= query param
    Route::delete('/edit_allowances/delete', [AllowanceController::class, 'destroy'])->name('allowances.destroy'); // Uses ?id= query param
    
    // Import FP Log routes (Converted to Blade)
    Route::get('/importfplog', [ImportFPLogController::class, 'index'])->name('import-fp-log.index');
    Route::post('/importfplog', [ImportFPLogController::class, 'store'])->name('import-fp-log.store');
    
    // Machine Log routes (Converted to Blade)
    Route::get('/machinelog', [MachineLogController::class, 'index'])->name('machine-log.index');
    
    // Scan Attendance routes (Converted to Blade)
    Route::get('/scan_att', [ScanAttendanceController::class, 'index'])->name('scan-attendance.index');
    Route::post('/scan_att', [ScanAttendanceController::class, 'scan'])->name('scan-attendance.scan');
    
    // Permits routes (Converted to Blade)
    Route::get('/permits', [PermitController::class, 'index'])->name('permits.index');
});
