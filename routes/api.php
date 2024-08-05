<?php

use App\Http\Controllers\AutosController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Cors;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;


Route::middleware([Cors::class])->group(function () {
    Route::post('/users/login', [UserController::class, 'login']); // Login route
    Route::post('/users/register', [UserController::class, 'store']); // Register route
    Route::apiResource('/autos', AutosController::class);

});

Route::middleware([Cors::class, VerifyCsrfToken::class])->group(function () {
    Route::apiResource('/users', UserController::class);
});
