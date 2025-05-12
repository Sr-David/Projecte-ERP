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

// Ruta temporal para servir archivos CSS y JS si Nginx falla
Route::get('/build/assets/{file}', function ($file) {
    $path = public_path("build/assets/{$file}");
    if (file_exists($path)) {
        $contentType = 'text/plain';
        
        if (str_ends_with($file, '.js')) {
            $contentType = 'application/javascript';
        } else if (str_ends_with($file, '.css')) {
            $contentType = 'text/css';
        }
        
        return response()->file($path, ['Content-Type' => $contentType]);
    }
    
    return response("File not found: {$file}", 404);
})->where('file', '.*');

// Rutas protegidas para administradores
Route::middleware([AdminAuth::class])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    });
});
