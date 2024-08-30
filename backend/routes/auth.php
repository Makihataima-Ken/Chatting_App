<?php


use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LogsController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ChatMessageController;
use App\Http\Controllers\UserController;

Route::prefix('auth')->as('auth.')->group(function () {
    
    Route::post('register', [RegisteredUserController::class, 'store'])->name('register');
    Route::post('login', [LogsController::class, 'login'])->name('login');
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('login_with_token', [LogsController::class, 'loginWithToken'])->name('login_with_token');
        Route::get('logout', [LogsController::class, 'logout'])->name('logout');
    });
   
});
Route::middleware('auth:sanctum')->group(function(){
    Route::apiResource('chat',ChatController::class)->only(['index','store','show']);
    Route::apiResource('chat_message',ChatMessageController::class)->only(['index','store']);
    Route::apiResource('user',UserController::class)->only(['index']);
});


