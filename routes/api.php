<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\User\UserController;
use App\Http\Controllers\Api\V1\Auth\AuthController;

Route::prefix('v1')->group(function () { //Versionamento manual da rota

    Route::prefix('auth')->group(function () {
        Route::post('/', [AuthController::class, 'login'])->name('login');
        Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('logout');
        Route::post('refresh', [AuthController::class, 'refresh'])->middleware('auth:sanctum')->name('token.refresh');
        Route::get('/', [AuthController::class, 'getLoggedUser'])->middleware('auth:sanctum')->name('auth.user');
    });

    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'getAll']);
        Route::get('/{perPage}/{page?}', [UserController::class, 'getAllPaginated']);
        Route::post('/', [UserController::class, 'store']);
        Route::put('/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'destroy']);
    });

});