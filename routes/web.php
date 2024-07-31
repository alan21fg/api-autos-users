<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AutosController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;

Route::apiResource('autos', AutosController::class);
Route::apiResource('users', UserController::class);

Route::get('/', function () {
    return view('welcome');
});
