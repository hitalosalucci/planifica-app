<?php

use Illuminate\Support\Facades\Route;

//Para Utilização do Vuejs
Route::get('/{any}', function () {
    return view('welcome'); // Viwe principal que carrega o vuejs
})->where('any', '.*');