<?php

use Illuminate\Support\Facades\Route;
use Modules\Reservations\Http\Controllers\ReservationsController;
use Modules\Reservations\Http\Controllers\ReservationController;
use Modules\Reservations\Http\Controllers\BookingController;
use App\Http\Controllers\LegacyController;

Route::middleware('check.auth')->group(function () {
    // Resource routes
    Route::resource('reservations', ReservationsController::class)->names('reservations');
    
    // Reservations routes (Converted to Blade)
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/add_reservation', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/add_reservation', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/add_reservation/edit', [ReservationController::class, 'edit'])->name('reservations.edit'); // Uses ?id= query param
    Route::put('/add_reservation/update', [ReservationController::class, 'update'])->name('reservations.update'); // Uses ?id= query param
    Route::get('/add_reservation/delete', [ReservationController::class, 'destroy'])->name('reservations.destroy'); // Uses ?id= query param
    
    // Booking routes (Converted to Blade)
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index'); // Uses ?case= query param
    Route::get('/add_booking', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/add_booking', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/booking', [BookingController::class, 'scan'])->name('bookings.scan');
    
    // AJAX endpoints for booking
    Route::post('/bookings/get-barcode-info', [BookingController::class, 'getBarcodeInfo'])->name('bookings.get-barcode-info');
    Route::post('/bookings/reduce-remain', [BookingController::class, 'reduceRemain'])->name('bookings.reduce-remain');
    Route::post('/bookings/check-client', [BookingController::class, 'checkClient'])->name('bookings.check-client');
    Route::post('/bookings/check-barcode', [BookingController::class, 'checkBarcode'])->name('bookings.check-barcode');
    Route::post('/bookings/get-type-info', [BookingController::class, 'getBookingTypeInfo'])->name('bookings.get-type-info');
});
