<?php
use App\Http\Controllers\UserController;
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

Route::resource('users', UserController::class);
