<?php

use App\Http\Controllers\API\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('books')->group(function () {
    Route::get('/',[BookController::class,'index']);
    Route::get('{books}',[BookController::class,'show']);
});
