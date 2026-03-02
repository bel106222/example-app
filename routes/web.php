<?php

use App\Http\Controllers\Web\BookController;
use App\Http\Controllers\Web\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    //dd('Hello World!');
    return view('welcome');
});

Route::get('/test', function () {
    //dd('Test');
    return view('welcome');
});

//Route::prefix('users')->group(function () {
//    Route::get('', [UserController::class, 'index'])->name('users.index');
//    Route::get('create', [UserController::class, 'create'])->name('users.create');
//    Route::get('{id}', [UserController::class, 'show'])->name('users.show');
//    Route::delete('destroy', [UserController::class, 'destroy'])->name('users.destroy');
//});

//Route::middleware('auth')->resource('users', UserController::class);
Route::resource('users', UserController::class);

//BOOKS CONTROLLER
Route::prefix('books')->name('books.')->group(callback: function () {
    Route::get('', [BookController::class, 'index'])->name('index');
    Route::get('create', [BookController::class, 'create'])->name('create');
    Route::get('{book}/edit', [BookController::class, 'edit'])->name('edit');
    Route::patch('{book}', [BookController::class, 'update'])->name('update');
    Route::delete('{book}', [BookController::class, 'destroy'])->name('destroy');
    Route::post('{book}/restore', [BookController::class, 'restore'])->name('restore');
});

Auth::routes();

Route::get('/home', [\App\Http\Controllers\Web\HomeController::class, 'index'])->name('home');
