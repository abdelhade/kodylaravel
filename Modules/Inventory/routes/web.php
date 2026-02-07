<?php

use Illuminate\Support\Facades\Route;
use Modules\Inventory\Http\Controllers\InventoryController;
use Modules\Inventory\Http\Controllers\ItemController;
use Modules\Inventory\Http\Controllers\UnitController;
use Modules\Inventory\Http\Controllers\GroupController;
use Modules\Inventory\Http\Controllers\CategoryController;
use Modules\Inventory\Http\Controllers\ItemStartBalanceController;
use Modules\Inventory\Http\Controllers\StoreController;
use Modules\Inventory\Http\Controllers\BarcodeController;

// Public API routes (no authentication required)
Route::get('/api/public/barcode/price', [BarcodeController::class, 'pricePublic'])->name('barcode.price.public');

Route::middleware('check.auth')->group(function () {
    // Resource routes
    Route::resource('inventories', InventoryController::class)->names('inventory');
    
    // Items routes (Converted to Blade)
    Route::get('/myitems', [ItemController::class, 'index'])->name('items.index');
    Route::get('/add_item', [ItemController::class, 'create'])->name('items.create');
    Route::post('/add_item', [ItemController::class, 'store'])->name('items.store');
    Route::get('/add_item/edit', [ItemController::class, 'edit'])->name('items.edit'); // Uses ?edit=id query param
    Route::put('/add_item/update', [ItemController::class, 'update'])->name('items.update'); // Uses ?edit=id query param
    Route::delete('/add_item/delete', [ItemController::class, 'destroy'])->name('items.destroy'); // Uses ?id=id query param
    
    // Additional item routes (to be implemented)
    Route::get('/items/{id}/summary', [ItemController::class, 'summary'])->name('items.summary');
    Route::post('/items/recost', [ItemController::class, 'recost'])->name('items.recost');
    Route::post('/items/upload', [ItemController::class, 'upload'])->name('items.upload');
    
    // Units routes (Converted to Blade)
    Route::get('/myunits', [UnitController::class, 'index'])->name('units.index');
    Route::post('/myunits', [UnitController::class, 'store'])->name('units.store');
    Route::put('/myunits/update', [UnitController::class, 'update'])->name('units.update'); // Uses ?id= query param
    Route::delete('/myunits/delete', [UnitController::class, 'destroy'])->name('units.destroy'); // Uses ?id= query param
    
    // Groups routes (Converted to Blade)
    Route::get('/mygroups', [GroupController::class, 'index'])->name('groups.index');
    Route::post('/mygroups', [GroupController::class, 'store'])->name('groups.store');
    Route::put('/mygroups/update', [GroupController::class, 'update'])->name('groups.update'); // Uses ?id= query param
    Route::delete('/mygroups/delete', [GroupController::class, 'destroy'])->name('groups.destroy'); // Uses ?id= query param
    
    // Categories routes (Converted to Blade)
    Route::get('/item_categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/item_categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('/item_categories/update', [CategoryController::class, 'update'])->name('categories.update'); // Uses ?id= query param
    Route::delete('/item_categories/delete', [CategoryController::class, 'destroy'])->name('categories.destroy'); // Uses ?id= query param
    
    // Items Start Balance routes (Converted to Blade)
    Route::get('/items_start_balance', [ItemStartBalanceController::class, 'index'])->name('items-start-balance.index');
    Route::post('/items_start_balance', [ItemStartBalanceController::class, 'store'])->name('items-start-balance.store');
    Route::post('/items_start_balance/reset', [ItemStartBalanceController::class, 'reset'])->name('items-start-balance.reset');
    
    // Stores routes (Converted to Blade)
    Route::get('/mystores', [StoreController::class, 'index'])->name('stores.index');
    Route::get('/add_store', [StoreController::class, 'create'])->name('stores.create');
    Route::post('/add_store', [StoreController::class, 'store'])->name('stores.store');
    Route::get('/add_store/edit', [StoreController::class, 'edit'])->name('stores.edit'); // Uses ?id= query param
    Route::put('/add_store/update', [StoreController::class, 'update'])->name('stores.update'); // Uses ?id= query param
    Route::delete('/add_store/delete', [StoreController::class, 'destroy'])->name('stores.destroy'); // Uses ?id= query param
    
    // Barcode price lookup routes (Converted to Blade)
    Route::get('/barcode_search', [BarcodeController::class, 'index'])->name('barcode_search');
    
    // Authenticated API routes
    Route::get('/api/barcode/price', [BarcodeController::class, 'price'])->name('barcode.price');
});
