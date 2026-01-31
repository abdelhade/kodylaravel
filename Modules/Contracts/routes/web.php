<?php

use Illuminate\Support\Facades\Route;
use Modules\Contracts\Http\Controllers\ContractsController;
use Modules\Contracts\Http\Controllers\ContractController;
use App\Http\Controllers\LegacyController;

Route::middleware('check.auth')->group(function () {
    // Resource routes
    Route::resource('contracts', ContractsController::class)->names('contracts');
    
    // Training Contracts routes (Converted to Blade)
    Route::get('/trainingcontracts', [ContractController::class, 'trainingIndex'])->name('contracts.training.index');
    Route::get('/add_trainingcontract', [ContractController::class, 'createTraining'])->name('contracts.training.create');
    Route::post('/add_trainingcontract', [ContractController::class, 'store'])->name('contracts.training.store'); // type=1
    
    // Hiring Contracts routes (Converted to Blade)
    Route::get('/hiringcontracts', [ContractController::class, 'hiringIndex'])->name('contracts.hiring.index');
    Route::get('/add_hiringcontract', [ContractController::class, 'createHiring'])->name('contracts.hiring.create');
    Route::post('/add_hiringcontract', [ContractController::class, 'store'])->name('contracts.hiring.store'); // type=0
    
    // External Contracts routes (Converted to Blade)
    Route::get('/externalcontracts', [ContractController::class, 'externalIndex'])->name('contracts.external.index');
    Route::get('/add_externalcontract', [ContractController::class, 'createExternal'])->name('contracts.external.create');
    Route::post('/add_externalcontract', [ContractController::class, 'store'])->name('contracts.external.store'); // type=2
    
    // Common contract routes
    Route::get('/edit_contract', [ContractController::class, 'edit'])->name('contracts.edit'); // Uses ?id= query param
    Route::put('/edit_contract/update', [ContractController::class, 'update'])->name('contracts.update'); // Uses ?id= query param
    Route::delete('/edit_contract/delete', [ContractController::class, 'destroy'])->name('contracts.destroy'); // Uses ?id= query param
    Route::get('/print/contracta4', [LegacyController::class, 'handle'])->name('contracts.print'); // Print contract - legacy for now
});
