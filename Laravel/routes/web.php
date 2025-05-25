<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
<<<<<<< Updated upstream
=======
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\LeadController;
>>>>>>> Stashed changes
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
<<<<<<< Updated upstream
    });
=======
    })->name('dashboard');
    
    // Rutas de Leads
    Route::resource('leads', LeadController::class);
    Route::post('/leads/{id}/convert', [LeadController::class, 'convertToClient'])->name('leads.convert');
    
    // Rutas de Clientes
    Route::resource('clientes', ClientsController::class)->names([
        'index' => 'clients.index',
        'create' => 'clients.create',
        'store' => 'clients.store',
        'show' => 'clients.show',
        'edit' => 'clients.edit',
        'update' => 'clients.update',
        'destroy' => 'clients.destroy',
    ]);

    // Ruta de Reportes
    Route::get('/reportes', function () {
        return view('reportes.index');
    })->name('reportes.index');

    Route::get('/ventas', [VentaController::class, 'resumen'])->name('ventas.resumen');
    Route::get('/ventas/confirmadas', [VentaController::class, 'index'])->name('ventas.ventas');
    Route::get('/ventas/propuestas', [VentaController::class, 'propuestas'])->name('ventas.propuestas');
    Route::get('/ventas/propuestas/crear', [VentaController::class, 'crearPropuesta'])->name('ventas.propuestas.create');
    Route::post('/ventas/propuestas', [VentaController::class, 'guardarPropuesta'])->name('ventas.propuestas.store');




    Route::get('/ventas/propuestas/{id}/confirmar', [VentaController::class, 'confirmarPropuesta'])->name('ventas.propuestas.confirmar');
    Route::post('/ventas/propuestas/{id}/confirmar', [VentaController::class, 'efectuarPropuesta'])->name('ventas.propuestas.efectuar');

    Route::post('/ventas/propuestas/{id}/cancelar', [VentaController::class, 'cancelarPropuesta'])->name('ventas.propuestas.cancelar');
    Route::post('/ventas/propuestas/{id}/rehabilitar', [VentaController::class, 'rehabilitarPropuesta'])->name('ventas.propuestas.rehabilitar');
    
    
    Route::get('/ventas/propuestas/{id}/edit', [VentaController::class, 'editPropuesta'])->name('ventas.propuestas.edit');
    Route::put('/ventas/propuestas/{id}', [VentaController::class, 'updatePropuesta'])->name('ventas.propuestas.update');

>>>>>>> Stashed changes
});
