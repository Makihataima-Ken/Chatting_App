<?php


use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LogsController;

Route::prefix('auth')->as('auth.')->group(function () {
    
    Route::post('register', [RegisteredUserController::class, 'store'])->name('register');
    Route::post('login', [LogsController::class, 'login'])->name('login');
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('login_with_token', [LogsController::class, 'loginWithToken'])->name('login_with_token');
        Route::get('logout', [LogsController::class, 'logout'])->name('logout');
    });
   
});


