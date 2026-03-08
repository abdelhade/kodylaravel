<?php

use Illuminate\Support\Facades\Route;
use Modules\Mobile\Http\Controllers\Api\AuthController;
use Modules\Mobile\Http\Controllers\Api\ProductController;

/*
 * Mobile API Routes
 * Base URL: /api/mobile/v1
 */

Route::prefix('v1')->group(function () {
    
    // Authentication
    Route::prefix('auth')->group(function () {
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
        Route::get('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');
    });
    
    // Products (Public - No Auth Required)
    Route::prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'index']);
        Route::get('/{id}', [ProductController::class, 'show']);
    });
    
    // Categories & Groups
    Route::get('/categories', [ProductController::class, 'categories']);
    Route::get('/groups', [ProductController::class, 'groups']);
    
});
