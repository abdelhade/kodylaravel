<?php

use Illuminate\Support\Facades\Route;
use Modules\Employees\Http\Controllers\EmployeesController;
use Modules\Employees\Http\Controllers\EmployeeController;
use Modules\Employees\Http\Controllers\ShiftController;
use Modules\Employees\Http\Controllers\DepartmentController;
use Modules\Employees\Http\Controllers\JobController;
use Modules\Employees\Http\Controllers\JobRuleController;
use Modules\Employees\Http\Controllers\JobLevelController;
use Modules\Employees\Http\Controllers\CVController;
use Modules\Employees\Http\Controllers\OrderController;
use Modules\Employees\Http\Controllers\KBIController;
use Modules\Employees\Http\Controllers\EmployeeKBIController;
use App\Http\Controllers\LegacyController;

Route::middleware('check.auth')->group(function () {
    // Resource routes
    Route::resource('employees', EmployeesController::class)->names('employees');
    
    // Employees routes (Converted to Blade)
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('/add_employee', [EmployeeController::class, 'create'])->name('employees.create');
    Route::post('/add_employee', [EmployeeController::class, 'store'])->name('employees.store');
    Route::get('/edit_employee', [EmployeeController::class, 'edit'])->name('employees.edit'); // Uses ?id= query param
    Route::put('/edit_employee/update', [EmployeeController::class, 'update'])->name('employees.update'); // Uses ?id= query param
    Route::delete('/edit_employee/delete', [EmployeeController::class, 'destroy'])->name('employees.destroy'); // Uses ?id= query param
    Route::get('/emprofile', [LegacyController::class, 'handle'])->name('employees.profile'); // Profile page - legacy for now
    
    // Shifts routes (Converted to Blade)
    Route::get('/shifts', [ShiftController::class, 'index'])->name('shifts.index');
    Route::get('/add_shift', [ShiftController::class, 'create'])->name('shifts.create');
    Route::post('/add_shift', [ShiftController::class, 'store'])->name('shifts.store');
    Route::get('/edit_shift', [ShiftController::class, 'edit'])->name('shifts.edit'); // Uses ?id= query param
    Route::put('/edit_shift/update', [ShiftController::class, 'update'])->name('shifts.update'); // Uses ?id= query param
    Route::delete('/edit_shift/delete', [ShiftController::class, 'destroy'])->name('shifts.destroy'); // Uses ?id= query param
    
    // Departments routes (Converted to Blade)
    Route::get('/departments', [DepartmentController::class, 'index'])->name('departments.index');
    Route::get('/add_department', [DepartmentController::class, 'create'])->name('departments.create');
    Route::post('/add_department', [DepartmentController::class, 'store'])->name('departments.store');
    Route::get('/edit_department', [DepartmentController::class, 'edit'])->name('departments.edit'); // Uses ?id= query param
    Route::put('/edit_department/update', [DepartmentController::class, 'update'])->name('departments.update'); // Uses ?id= query param
    Route::delete('/edit_department/delete', [DepartmentController::class, 'destroy'])->name('departments.destroy'); // Uses ?id= query param
    
    // Jobs routes (Converted to Blade)
    Route::get('/jops', [JobController::class, 'index'])->name('jobs.index');
    Route::get('/add_jop', [JobController::class, 'create'])->name('jobs.create');
    Route::post('/add_jop', [JobController::class, 'store'])->name('jobs.store');
    Route::get('/edit_jop', [JobController::class, 'edit'])->name('jobs.edit'); // Uses ?id= query param
    Route::put('/edit_jop/update', [JobController::class, 'update'])->name('jobs.update'); // Uses ?id= query param
    Route::delete('/edit_jop/delete', [JobController::class, 'destroy'])->name('jobs.destroy'); // Uses ?id= query param
    
    // Job Rules routes (Converted to Blade)
    Route::get('/joprules', [JobRuleController::class, 'index'])->name('job-rules.index');
    Route::get('/add_joprule', [JobRuleController::class, 'create'])->name('job-rules.create');
    Route::post('/add_joprule', [JobRuleController::class, 'store'])->name('job-rules.store');
    Route::get('/edit_joprule', [JobRuleController::class, 'edit'])->name('job-rules.edit'); // Uses ?id= query param
    Route::put('/edit_joprule/update', [JobRuleController::class, 'update'])->name('job-rules.update'); // Uses ?id= query param
    Route::delete('/edit_joprule/delete', [JobRuleController::class, 'destroy'])->name('job-rules.destroy'); // Uses ?id= query param
    
    // Job Levels routes (Converted to Blade)
    Route::get('/joplevels', [JobLevelController::class, 'index'])->name('job-levels.index');
    Route::get('/add_joplevel', [JobLevelController::class, 'create'])->name('job-levels.create');
    Route::post('/add_joplevel', [JobLevelController::class, 'store'])->name('job-levels.store');
    Route::get('/edit_joplevel', [JobLevelController::class, 'edit'])->name('job-levels.edit'); // Uses ?id= query param
    Route::put('/edit_joplevel/update', [JobLevelController::class, 'update'])->name('job-levels.update'); // Uses ?id= query param
    Route::delete('/edit_joplevel/delete', [JobLevelController::class, 'destroy'])->name('job-levels.destroy'); // Uses ?id= query param
    
    // CVs routes (Converted to Blade)
    Route::get('/cvs', [CVController::class, 'index'])->name('cvs.index');
    Route::get('/add_cv', [CVController::class, 'create'])->name('cvs.create');
    Route::post('/add_cv', [CVController::class, 'store'])->name('cvs.store');
    Route::get('/edit_cv', [CVController::class, 'edit'])->name('cvs.edit'); // Uses ?id= query param
    Route::put('/edit_cv/update', [CVController::class, 'update'])->name('cvs.update'); // Uses ?id= query param
    
    // Orders routes (Converted to Blade)
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/add_order', [OrderController::class, 'create'])->name('orders.create'); // Uses ?id= query param for order type
    Route::post('/add_order', [OrderController::class, 'store'])->name('orders.store');
    
    // KBIs routes (Converted to Blade)
    Route::get('/kbis', [KBIController::class, 'index'])->name('kbis.index');
    Route::get('/add_kbi', [KBIController::class, 'create'])->name('kbis.create');
    Route::post('/add_kbi', [KBIController::class, 'store'])->name('kbis.store');
    Route::put('/kbis/update', [KBIController::class, 'update'])->name('kbis.update'); // Uses ?id= query param
    Route::delete('/kbis/delete', [KBIController::class, 'destroy'])->name('kbis.destroy'); // Uses ?id= query param
    
    // Employee KBIs routes (Converted to Blade)
    Route::get('/emp_kbis', [EmployeeKBIController::class, 'index'])->name('emp-kbis.index');
    Route::get('/add_empkbi', [EmployeeKBIController::class, 'create'])->name('emp-kbis.create'); // Uses ?c=, ?i=, ?q= query params
    Route::post('/add_empkbi', [EmployeeKBIController::class, 'store'])->name('emp-kbis.store');
});
