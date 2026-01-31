<?php

use Illuminate\Support\Facades\Route;
use Modules\Tasks\Http\Controllers\TasksController;
use Modules\Tasks\Http\Controllers\TaskController;
use Modules\Tasks\Http\Controllers\FollowupController;
use App\Http\Controllers\LegacyController;

Route::middleware('check.auth')->group(function () {
    // Resource routes
    Route::resource('tasks', TasksController::class)->names('tasks');
    
    // Tasks routes (Converted to Blade)
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/add_task', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('/add_task', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/add_task/edit', [TaskController::class, 'edit'])->name('tasks.edit'); // Uses ?id= query param
    Route::put('/add_task/update', [TaskController::class, 'update'])->name('tasks.update'); // Uses ?id= query param
    Route::get('/add_task/delete', [TaskController::class, 'destroy'])->name('tasks.destroy'); // Uses ?id= query param
    
    // Followup routes (Converted to Blade)
    Route::get('/followup', [FollowupController::class, 'index'])->name('followup.index');
    Route::delete('/followup/delete', [FollowupController::class, 'destroy'])->name('followup.destroy'); // Uses ?id= query param
    
    // Legacy routes - KPIs
    Route::get('/kbis', [LegacyController::class, 'handle'])->name('kbis');
    Route::get('/emp_kbis', [LegacyController::class, 'handle'])->name('emp_kbis');
});
