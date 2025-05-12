<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\AdminAuth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/shadcn', function () {
    return view('shadcn-example');
});

// Rutas de autenticación
Route::post('/api/login', [AuthController::class, 'login']);
Route::post('/api/logout', [AuthController::class, 'logout']);
Route::get('/api/check-auth', [AuthController::class, 'check']);

// Ruta para la página de login
Route::get('/login', function () {
    return view('login');
});

// Rutas protegidas para administradores
Route::middleware([AdminAuth::class])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    });
});
