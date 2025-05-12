<?php
// filepath: d:\CFGS DAM\Segundo año\Sistemes gestió empresarial\Projecte Final\Projecte-ERP\Laravel\routes\api.php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientsController;


// Rutas de autenticación
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/check-auth', [AuthController::class, 'check']);



Route::get('/clients', [ClientsController::class, 'index']);

Route::get('/prueba', function () {
    return response()->json(['mensaje' => 'Funciona!']);
});