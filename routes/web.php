<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/form-page', 'form-page');
Route::post('/start-communication', \App\Http\Controllers\StartCommunicationController::class);
