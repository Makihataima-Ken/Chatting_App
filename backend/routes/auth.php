<?php


use App\Http\Controllers\Auth\RegisteredUserController;
//use App\Http\Controllers\Auth\LogController;
use App\Http\Controllers\LogController as ControllersLogController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->as('auth.')->group(function () {
    Route::post('register', [RegisteredUserController::class, 'store'])->name('register');
    Route::post('login', [ControllersLogController::class, 'login'])->name('login');
    Route::middleware('auth:snactum')->group(function () {
        Route::post('login_with_token', [ControllersLogController::class, 'loginWithToken'])->name('login_with_token');
        Route::get('logout', [ControllersLogController::class, 'logout'])->name('logout');
    });
   
});


