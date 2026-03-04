<?php

use App\Http\Controllers\API\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('books')->name('api.books.')->group(function () {
    Route::get('/',[BookController::class,'index'])->name('index');
    Route::post('/',[BookController::class,'store'])->name('store');
    Route::get('/{books}',[BookController::class,'show'])->name('show');
    Route::patch('/{books}',[BookController::class,'update'])->name('update');
    Route::delete('/{books}',[BookController::class,'destroy'])->name('destroy');
});
