<?php

use App\Http\Controllers\API\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('books')->group(function () {
    Route::get('/',[BookController::class,'index']);
    Route::post('/',[BookController::class,'store']);
    Route::get('/{books}',[BookController::class,'show']);
    Route::patch('/{books}',[BookController::class,'update']);
    Route::delete('/{books}',[BookController::class,'destroy']);
});
