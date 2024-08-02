<?php

use App\Http\Controllers\AutosController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Cors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
Route::middleware([Cors::class])->group(function () {
    Route::apiResource('autos', AutosController::class);
    Route::apiResource('users', UserController::class);
});
