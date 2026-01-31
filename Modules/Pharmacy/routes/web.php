<?php

use Illuminate\Support\Facades\Route;
use Modules\Pharmacy\Http\Controllers\PharmacyController;
use Modules\Pharmacy\Http\Controllers\DrugController;
use Modules\Pharmacy\Http\Controllers\PrescriptionController;
use Modules\Pharmacy\Http\Controllers\VisitController;
use Modules\Pharmacy\Http\Controllers\VisitTypeController;
use Modules\Pharmacy\Http\Controllers\PatientController;
use App\Http\Controllers\LegacyController;

Route::middleware('check.auth')->group(function () {
    // Resource routes
    Route::resource('pharmacies', PharmacyController::class)->names('pharmacy');
    
    // Drugs routes (Converted to Blade)
    Route::get('/drugs', [DrugController::class, 'index'])->name('drugs.index');
    Route::get('/add_drugs', [DrugController::class, 'create'])->name('drugs.create');
    Route::post('/add_drugs', [DrugController::class, 'store'])->name('drugs.store');
    Route::get('/edit_drugs', [DrugController::class, 'edit'])->name('drugs.edit'); // Uses ?id= query param
    Route::put('/edit_drugs/update', [DrugController::class, 'update'])->name('drugs.update'); // Uses ?id= query param
    Route::delete('/edit_drugs/delete', [DrugController::class, 'destroy'])->name('drugs.destroy'); // Uses ?id= query param
    
    // Prescriptions routes (Converted to Blade)
    Route::get('/rese', [PrescriptionController::class, 'index'])->name('prescriptions.index');
    Route::get('/presc', [PrescriptionController::class, 'show'])->name('prescriptions.show'); // Uses ?id= query param
    Route::get('/add_presc', [PrescriptionController::class, 'create'])->name('prescriptions.create'); // Uses ?id= query param (client id)
    Route::post('/add_presc', [PrescriptionController::class, 'store'])->name('prescriptions.store'); // Uses ?id= query param (client id)
    Route::get('/print/presc_print', [LegacyController::class, 'handle'])->name('prescriptions.print'); // Print - legacy for now
    
    // Visits routes (Converted to Blade)
    Route::get('/visits', [VisitController::class, 'index'])->name('visits.index');
    Route::get('/add_visit', [VisitController::class, 'create'])->name('visits.create');
    Route::post('/add_visit', [VisitController::class, 'store'])->name('visits.store');
    Route::get('/edit_visit', [VisitController::class, 'edit'])->name('visits.edit'); // Uses ?id= query param
    Route::put('/edit_visit/update', [VisitController::class, 'update'])->name('visits.update'); // Uses ?id= query param
    Route::delete('/edit_visit/delete', [VisitController::class, 'destroy'])->name('visits.destroy'); // Uses ?id= query param
    
    // Visit Types routes (Converted to Blade)
    Route::get('/vtybes', [VisitTypeController::class, 'index'])->name('visit-types.index');
    Route::post('/vtybes', [VisitTypeController::class, 'store'])->name('visit-types.store');
    Route::put('/vtybes/update', [VisitTypeController::class, 'update'])->name('visit-types.update'); // Uses ?id= query param
    Route::delete('/vtybes/delete', [VisitTypeController::class, 'destroy'])->name('visit-types.destroy'); // Uses ?id= query param
    
    // Patients routes (Converted to Blade)
    Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
});
