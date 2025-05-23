<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\User\UserController;
use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Event\EventController;
use App\Http\Controllers\Api\V1\Room\RoomController;
use App\Http\Controllers\Api\V1\CoffeeRoom\CoffeeRoomController;
use App\Http\Controllers\Api\V1\Person\PersonController;

Route::prefix('v1')->group(function () { //Versionamento manual da rota
    
    Route::prefix('auth')->group(function () {
        Route::post('/', [AuthController::class, 'login'])->name('login');
        Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('logout');
        Route::post('refresh', [AuthController::class, 'refresh'])->middleware('auth:sanctum')->name('token.refresh');
        Route::get('/', [AuthController::class, 'getLoggedUser'])->middleware('auth:sanctum')->name('auth.user');
    });

    //As rotas abaixo estarão protegidas pelo middleware do sanctum, ou seja, precisa ter autenticação
    
    Route::prefix('users')->middleware('auth:sanctum')->group(function () {
        Route::get('/', [UserController::class, 'getAll']);
        Route::get('/{perPage}/{page?}', [UserController::class, 'getAllPaginated']);
        Route::post('/', [UserController::class, 'store']);
        Route::put('/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'destroy']);
    });

    Route::prefix('people')->middleware('auth:sanctum')->group(function () {
        Route::get('/{person}/events', [PersonController::class, 'getEventsByPeople']);

        Route::get('/', [PersonController::class, 'getAll']);
        Route::get('/{perPage}/{page?}', [PersonController::class, 'getAllPaginated']);
        Route::post('/', [PersonController::class, 'store']);
        Route::put('/{id}', [PersonController::class, 'update']);
        Route::delete('/{id}', [PersonController::class, 'destroy']);
    });

    Route::prefix('events')->middleware('auth:sanctum')->group(function () {
        Route::post('/{event}/people', [EventController::class, 'attachPerson']); //associar pessoa ao evento
        Route::delete('/{event}/people/{person}', [EventController::class, 'detachPerson']); //desassociar pessoa ao evento
        Route::get('/{event}/people', [EventController::class, 'getPeople']);

        Route::get('/', [EventController::class, 'getAll']);
        Route::get('/{perPage}/{page?}', [EventController::class, 'getAllPaginated']);
        Route::post('/', [EventController::class, 'store']);
        Route::put('/{id}', [EventController::class, 'update']);
        Route::delete('/{id}', [EventController::class, 'destroy']);
    });

    Route::prefix('rooms')->middleware('auth:sanctum')->group(function () {
        Route::get('/', [RoomController::class, 'getAll']);
        Route::get('/{perPage}/{page?}', [RoomController::class, 'getAllPaginated']);
        Route::post('/', [RoomController::class, 'store']);
        Route::put('/{id}', [RoomController::class, 'update']);
        Route::delete('/{id}', [RoomController::class, 'destroy']);
    });

    Route::prefix('coffee-rooms')->middleware('auth:sanctum')->group(function () {
        Route::get('/', [CoffeeRoomController::class, 'getAll']);
        Route::get('/{perPage}/{page?}', [CoffeeRoomController::class, 'getAllPaginated']);
        Route::post('/', [CoffeeRoomController::class, 'store']);
        Route::put('/{id}', [CoffeeRoomController::class, 'update']);
        Route::delete('/{id}', [CoffeeRoomController::class, 'destroy']);
    });

});