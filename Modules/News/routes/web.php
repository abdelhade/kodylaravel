<?php

use Illuminate\Support\Facades\Route;
use Modules\News\Http\Controllers\NewsController;

Route::middleware('check.auth')->group(function () {
    // News routes (Converted to Blade)
    Route::get('/news', [NewsController::class, 'index'])->name('news.index');
    Route::get('/add_news', [NewsController::class, 'create'])->name('news.create');
    Route::post('/add_news', [NewsController::class, 'store'])->name('news.store');
    Route::get('/blogcontent', [NewsController::class, 'show'])->name('news.show'); // Uses ?id= query param
    Route::delete('/news/delete', [NewsController::class, 'destroy'])->name('news.destroy'); // Uses ?id= query param
});
