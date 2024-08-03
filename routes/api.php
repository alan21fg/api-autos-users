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
Route::middleware([Cors::class, VerifyCsrfToken::class])->group(function () {
    Route::apiResource('/autos', AutosController::class);
    Route::apiResource('/users', UserController::class);
    Route::post('/login', [AuthController::class, 'login']);
});
