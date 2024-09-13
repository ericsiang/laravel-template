<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/filter',[UserController::class, 'filter']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(AuthController::class)->prefix('auth')->group(function () {
    Route::get('login', 'login')->name('user.login');
});

Route::middleware('auth:api-user')->prefix('user')->group(function () {
    Route::get('info', [UserController::class, 'index'])->name('user.index');
    Route::get('info/{id}', [UserController::class, 'show'])->name('user.show');
});
