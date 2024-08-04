<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AutosController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Cors;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
Route::middleware([Cors::class])->group(function () {
    Route::post('/users/login', [UserController::class, 'login']); // Ruta para el login
    Route::post('/users/register', [UserController::class, 'store']); // Ruta para el registro
    Route::apiResource('/autos', AutosController::class);

});

Route::middleware([Cors::class, VerifyCsrfToken::class])->group(function () {
    Route::apiResource('/users', UserController::class);
});
