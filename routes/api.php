<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AutosController;
use App\Http\Controllers\UserController;

// Define las rutas para los recursos de Autos
Route::apiResource('autos', AutosController::class);

// Define las rutas para los recursos de Usuarios
Route::apiResource('users', UserController::class);

// Puedes agregar otras rutas de API aquí si es necesario
