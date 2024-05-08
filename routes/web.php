<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/start-communication', \App\Http\Controllers\StartCommunicationController::class);
