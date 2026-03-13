<?php

use App\Http\Controllers\Web\BookController;
use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\Web\OrganizationController;
use App\Http\Controllers\Web\ServiceController;
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

//ORGANIZATION CONTROLLER
Route::prefix('organizations')->name('organizations.')->group(callback: function () {
    Route::get('', [OrganizationController::class, 'index'])->name('index');
    Route::get('create', [OrganizationController::class, 'create'])->name('create');
    Route::post('', [OrganizationController::class, 'store'])->name('store');
    Route::get('{organization}/show', [OrganizationController::class, 'show'])->name('show');
    Route::patch('{organization}', [OrganizationController::class, 'update'])->name('update');
    Route::delete('{organization}', [OrganizationController::class, 'destroy'])->name('destroy');
    Route::post('{organization}/restore', [OrganizationController::class, 'restore'])->name('restore');
});

//CATEGORY CONTROLLER
Route::prefix('categories')->name('categories.')->group(callback: function () {
    Route::get('', [CategoryController::class, 'index'])->name('index');
    Route::get('create', [CategoryController::class, 'create'])->name('create');
    Route::post('', [CategoryController::class, 'store'])->name('store');
    Route::get('{category}/show', [CategoryController::class, 'show'])->name('show');
    Route::patch('{category}', [CategoryController::class, 'update'])->name('update');
    Route::delete('{category}', [CategoryController::class, 'destroy'])->name('destroy');
    Route::post('{category}/restore', [CategoryController::class, 'restore'])->name('restore');
});

//SERVICE CONTROLLER
Route::prefix('services')->name('services.')->group(callback: function () {
    Route::get('', [ServiceController::class, 'index'])->name('index');
    Route::get('create', [ServiceController::class, 'create'])->name('create');
    Route::post('', [ServiceController::class, 'store'])->name('store');
    Route::get('{service}/show', [ServiceController::class, 'show'])->name('show');
    Route::patch('{service}', [ServiceController::class, 'update'])->name('update');
    Route::delete('{service}', [ServiceController::class, 'destroy'])->name('destroy');
    Route::post('{service}/restore', [ServiceController::class, 'restore'])->name('restore');
});

Auth::routes();

Route::get('/home', [\App\Http\Controllers\Web\HomeController::class, 'index'])->name('home');
