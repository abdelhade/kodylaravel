<?php

use Illuminate\Support\Facades\Route;
use Modules\Users\Http\Controllers\UsersController;
use Modules\Users\Http\Controllers\PasswordController;
use Modules\Users\Http\Controllers\RoleController;
use App\Http\Controllers\LegacyController;

Route::middleware('check.auth')->group(function () {
    // Users routes (Converted to Blade)
    // Users routes (Converted to Blade)
    Route::resource('users', UsersController::class);
    
    // Password change routes (Converted to Blade)
    Route::get('/change_password', [PasswordController::class, 'showChangeForm'])->name('change_password');
    Route::post('/change_password', [PasswordController::class, 'change'])->name('change_password.post');
    
    // Roles routes (Converted to Blade)
    Route::get('/myroles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/add_role', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/add_role', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/edit_role', [RoleController::class, 'edit'])->name('roles.edit'); // Uses ?id=, ?name=, ?hash= query params
    Route::put('/edit_role/update', [RoleController::class, 'update'])->name('roles.update'); // Uses ?id= query param
    Route::delete('/myroles/delete', [RoleController::class, 'destroy'])->name('roles.destroy'); // Uses ?id= query param
});
