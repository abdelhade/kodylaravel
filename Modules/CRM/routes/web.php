<?php

use Illuminate\Support\Facades\Route;
use Modules\CRM\Http\Controllers\ActivityController;
use Modules\CRM\Http\Controllers\ContactController;
use Modules\CRM\Http\Controllers\CRMController;
use Modules\CRM\Http\Controllers\LeadController;
use Modules\CRM\Http\Controllers\OpportunityController;

Route::middleware('check.auth')->group(function () {
    // Dashboard
    Route::get('/crm', [CRMController::class, 'dashboard'])->name('crm.dashboard');
    
    // Leads routes
    Route::get('/crm/leads', [LeadController::class, 'index'])->name('leads.index');
    Route::post('/crm/leads/store', [LeadController::class, 'store'])->name('leads.store');
    Route::post('/crm/leads/update', [LeadController::class, 'update'])->name('leads.update');
    Route::get('/crm/leads/delete', [LeadController::class, 'destroy'])->name('leads.destroy');

    // Opportunities routes
    Route::get('/crm/opportunities', [OpportunityController::class, 'index'])->name('opportunities.index');
    Route::get('/crm/opportunities/create', [OpportunityController::class, 'create'])->name('opportunities.create');
    Route::post('/crm/opportunities/store', [OpportunityController::class, 'store'])->name('opportunities.store');
    Route::get('/crm/opportunities/edit', [OpportunityController::class, 'edit'])->name('opportunities.edit');
    Route::put('/crm/opportunities/update', [OpportunityController::class, 'update'])->name('opportunities.update');
    Route::delete('/crm/opportunities/delete', [OpportunityController::class, 'destroy'])->name('opportunities.destroy');

    // Contacts routes
    Route::get('/crm/contacts', [ContactController::class, 'index'])->name('contacts.index');
    Route::get('/crm/contacts/create', [ContactController::class, 'create'])->name('contacts.create');
    Route::post('/crm/contacts/store', [ContactController::class, 'store'])->name('contacts.store');
    Route::get('/crm/contacts/edit', [ContactController::class, 'edit'])->name('contacts.edit');
    Route::put('/crm/contacts/update', [ContactController::class, 'update'])->name('contacts.update');
    Route::delete('/crm/contacts/delete', [ContactController::class, 'destroy'])->name('contacts.destroy');

    // Activities routes
    Route::get('/crm/activities', [ActivityController::class, 'index'])->name('activities.index');
    Route::get('/crm/activities/create', [ActivityController::class, 'create'])->name('activities.create');
    Route::post('/crm/activities/store', [ActivityController::class, 'store'])->name('activities.store');
    Route::post('/crm/activities/update', [ActivityController::class, 'update'])->name('activities.update');
    Route::get('/crm/activities/delete', [ActivityController::class, 'destroy'])->name('activities.destroy');
});
