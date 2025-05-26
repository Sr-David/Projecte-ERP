<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\ProductsServicesController;
use App\Http\Controllers\ProjectController;
use App\Http\Middleware\AdminAuth;
use App\Http\Middleware\CheckUserPermissions;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\NotesController;

Route::get('/', function (\Illuminate\Http\Request $request) {
    if ($request->session()->has('auth_token') && $request->session()->has('user_id')) {
        return redirect('/dashboard');
    }
    return view('welcome');
});

Route::get('/shadcn', function () {
    return view('shadcn-example');
});

// Rutas de autenticación
Route::post('/api/login', [AuthController::class, 'login']);
Route::post('/api/logout', [AuthController::class, 'logout']);
Route::get('/api/check-auth', [AuthController::class, 'check']);
Route::get('/api/user-permissions', function(\Illuminate\Http\Request $request) {
    // Si no hay sesión iniciada o no es una solicitud AJAX, rechazar
    if (!$request->session()->has('user_id') || !$request->ajax()) {
        return response()->json(['success' => false, 'message' => 'No autorizado'], 401);
    }
    
    // Si es un administrador, dar todos los permisos
    if ($request->session()->get('user_type') === 'admin') {
        return response()->json([
            'success' => true,
            'is_admin' => true,
            'permissions' => []
        ]);
    }
    
    // Obtener los permisos del usuario
    $userId = $request->session()->get('user_id');
    $user = DB::table('Users')->where('idUser', $userId)->first();
    
    if (!$user) {
        return response()->json(['success' => false, 'message' => 'Usuario no encontrado'], 404);
    }
    
    $permisos = json_decode($user->Permissions ?? '{}', true);
    
    return response()->json([
        'success' => true,
        'is_admin' => false,
        'permissions' => $permisos
    ]);
});

// API para tipos de clientes
Route::post('/api/client-types', [App\Http\Controllers\ClientTypeController::class, 'store'])->name('api.clienttypes.store');

// Ruta para la página de login
Route::get('/login', function (\Illuminate\Http\Request $request) {
    if ($request->session()->has('auth_token') && $request->session()->has('user_id')) {
        return redirect('/dashboard');
    }
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

// Rutas protegidas (requieren autenticación)
Route::middleware(\App\Http\Middleware\AdminAuth::class)->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    
    // Rutas de Leads
    Route::middleware(\App\Http\Middleware\CheckUserPermissions::class.':leads,ver')->group(function () {
        Route::get('leads', [LeadController::class, 'index'])->name('leads.index');
    });

    Route::middleware(\App\Http\Middleware\CheckUserPermissions::class.':leads,crear')->group(function () {
        Route::get('leads/create', [LeadController::class, 'create'])->name('leads.create');
        Route::post('leads', [LeadController::class, 'store'])->name('leads.store');
    });

    Route::middleware(\App\Http\Middleware\CheckUserPermissions::class.':leads,ver')->group(function () {
        Route::get('leads/{lead}', [LeadController::class, 'show'])->name('leads.show');
    });

    Route::middleware(\App\Http\Middleware\CheckUserPermissions::class.':leads,editar')->group(function () {
        Route::get('leads/{lead}/edit', [LeadController::class, 'edit'])->name('leads.edit');
        Route::put('leads/{lead}', [LeadController::class, 'update'])->name('leads.update');
        Route::patch('leads/{lead}', [LeadController::class, 'update']);
        Route::post('/leads/{id}/convert', [LeadController::class, 'convertToClient'])->name('leads.convert');
    });

    Route::middleware(\App\Http\Middleware\CheckUserPermissions::class.':leads,borrar')->group(function () {
        Route::delete('leads/{lead}', [LeadController::class, 'destroy'])->name('leads.destroy');
    });
    
    // Rutas de Clientes
    Route::middleware(\App\Http\Middleware\CheckUserPermissions::class.':clientes,ver')->group(function () {
        Route::get('clientes', [ClientsController::class, 'index'])->name('clients.index');
    });

    Route::middleware(\App\Http\Middleware\CheckUserPermissions::class.':clientes,crear')->group(function () {
        Route::get('clientes/create', [ClientsController::class, 'create'])->name('clients.create');
        Route::post('clientes', [ClientsController::class, 'store'])->name('clients.store');
    });

    Route::middleware(\App\Http\Middleware\CheckUserPermissions::class.':clientes,ver')->group(function () {
        Route::get('clientes/{cliente}', [ClientsController::class, 'show'])->name('clients.show');
    });

    Route::middleware(\App\Http\Middleware\CheckUserPermissions::class.':clientes,editar')->group(function () {
        Route::get('clientes/{cliente}/edit', [ClientsController::class, 'edit'])->name('clients.edit');
        Route::put('clientes/{cliente}', [ClientsController::class, 'update'])->name('clients.update');
        Route::patch('clientes/{cliente}', [ClientsController::class, 'update']);
    });

    Route::middleware(\App\Http\Middleware\CheckUserPermissions::class.':clientes,borrar')->group(function () {
        Route::delete('clientes/{cliente}', [ClientsController::class, 'destroy'])->name('clients.destroy');
    });

    // Rutas de Productos
    Route::middleware(\App\Http\Middleware\CheckUserPermissions::class.':productos,ver')->group(function () {
        Route::get('productos', [ProductsServicesController::class, 'index'])->name('productos.index');
    });

    Route::middleware(\App\Http\Middleware\CheckUserPermissions::class.':productos,crear')->group(function () {
        Route::get('productos/create', [ProductsServicesController::class, 'create'])->name('productos.create');
        Route::post('productos', [ProductsServicesController::class, 'store'])->name('productos.store');
    });

    Route::middleware(\App\Http\Middleware\CheckUserPermissions::class.':productos,ver')->group(function () {
        Route::get('productos/{producto}', [ProductsServicesController::class, 'show'])->name('productos.show');
    });

    Route::middleware(\App\Http\Middleware\CheckUserPermissions::class.':productos,editar')->group(function () {
        Route::get('productos/{producto}/edit', [ProductsServicesController::class, 'edit'])->name('productos.edit');
        Route::put('productos/{producto}', [ProductsServicesController::class, 'update'])->name('productos.update');
        Route::patch('productos/{producto}', [ProductsServicesController::class, 'update']);
    });

    Route::middleware(\App\Http\Middleware\CheckUserPermissions::class.':productos,borrar')->group(function () {
        Route::delete('productos/{producto}', [ProductsServicesController::class, 'destroy'])->name('productos.destroy');
    });

    // Ruta de Reportes
    Route::middleware(\App\Http\Middleware\CheckUserPermissions::class.':reportes,ver')->group(function () {
        Route::get('/reportes', [App\Http\Controllers\ReportesController::class, 'index'])->name('reportes.index');
    });

    // Rutas de Ventas
    Route::middleware(\App\Http\Middleware\CheckUserPermissions::class.':ventas,ver')->group(function () {
        Route::get('/ventas', [VentaController::class, 'resumen'])->name('ventas.resumen');
        Route::get('/ventas/confirmadas', [VentaController::class, 'index'])->name('ventas.ventas');
        Route::get('/ventas/propuestas', [VentaController::class, 'propuestas'])->name('ventas.propuestas');
    });

    Route::middleware(\App\Http\Middleware\CheckUserPermissions::class.':ventas,crear')->group(function () {
        Route::get('/ventas/propuestas/crear', [VentaController::class, 'crearPropuesta'])->name('ventas.propuestas.create');
        Route::post('/ventas/propuestas', [VentaController::class, 'guardarPropuesta'])->name('ventas.propuestas.store');
    });

    Route::middleware(\App\Http\Middleware\CheckUserPermissions::class.':ventas,editar')->group(function () {
        Route::get('/ventas/propuestas/{id}/edit', [VentaController::class, 'editPropuesta'])->name('ventas.propuestas.edit');
        Route::put('/ventas/propuestas/{id}', [VentaController::class, 'updatePropuesta'])->name('ventas.propuestas.update');
        Route::get('/ventas/propuestas/{id}/confirmar', [VentaController::class, 'confirmarPropuesta'])->name('ventas.propuestas.confirmar');
        Route::post('/ventas/propuestas/{id}/confirmar', [VentaController::class, 'efectuarPropuesta'])->name('ventas.propuestas.efectuar');
    });

    Route::middleware(\App\Http\Middleware\CheckUserPermissions::class.':ventas,borrar')->group(function () {
        Route::post('/ventas/propuestas/{id}/cancelar', [VentaController::class, 'cancelarPropuesta'])->name('ventas.propuestas.cancelar');
        Route::post('/ventas/propuestas/{id}/rehabilitar', [VentaController::class, 'rehabilitarPropuesta'])->name('ventas.propuestas.rehabilitar');
    });

    // Sistema - Configuración del sistema (solo para administradores)
    Route::prefix('sistema')->middleware(\App\Http\Middleware\AdminAuth::class)->group(function () {
        Route::get('/', [App\Http\Controllers\AdminController::class, 'sistema'])->name('sistema');
        Route::post('/usuario', [App\Http\Controllers\AdminController::class, 'saveUser'])->name('sistema.save-user');
        Route::delete('/usuario/{id}', [App\Http\Controllers\AdminController::class, 'deleteUser'])->name('sistema.delete-user');
    });
    
    // Ajustes - Permisos de usuarios (solo para administradores)
    Route::middleware(\App\Http\Middleware\AdminAuth::class)->group(function () {
        Route::get('/ajustes', [App\Http\Controllers\AdminController::class, 'permisos'])->name('ajustes');
        Route::post('/ajustes/permisos', [App\Http\Controllers\AdminController::class, 'savePermisos'])->name('ajustes.save-permisos');
    });

    // Projects routes
    Route::middleware(\App\Http\Middleware\CheckUserPermissions::class.':proyectos,ver')->group(function () {
        Route::get('/proyectos', [ProjectController::class, 'index'])->name('proyectos.index');
    });

    Route::middleware(\App\Http\Middleware\CheckUserPermissions::class.':proyectos,crear')->group(function () {
        Route::get('/proyectos/create', [ProjectController::class, 'create'])->name('proyectos.create');
        Route::post('/proyectos', [ProjectController::class, 'store'])->name('proyectos.store');
    });

    Route::middleware(\App\Http\Middleware\CheckUserPermissions::class.':proyectos,ver')->group(function () {
        Route::get('/proyectos/{id}', [ProjectController::class, 'show'])->name('proyectos.show');
    });

    Route::middleware(\App\Http\Middleware\CheckUserPermissions::class.':proyectos,editar')->group(function () {
        Route::get('/proyectos/{id}/edit', [ProjectController::class, 'edit'])->name('proyectos.edit');
        Route::put('/proyectos/{id}', [ProjectController::class, 'update'])->name('proyectos.update');
        Route::patch('/proyectos/{id}', [ProjectController::class, 'update']);
    });

    Route::middleware(\App\Http\Middleware\CheckUserPermissions::class.':proyectos,borrar')->group(function () {
        Route::delete('/proyectos/{id}', [ProjectController::class, 'destroy'])->name('proyectos.destroy');
    });

    // Notes routes
    Route::resource('notas', NotesController::class)->names([
        'index' => 'notes.index',
        'create' => 'notes.create',
        'store' => 'notes.store',
        'show' => 'notes.show',
        'edit' => 'notes.edit',
        'update' => 'notes.update',
        'destroy' => 'notes.destroy',
    ]);

    // API para los desplegables de notas
    Route::prefix('api')->group(function () {
        Route::get('/clientes', function (\Illuminate\Http\Request $request) {
            $idEmpresa = $request->session()->get('empresa_id');
            $clients = DB::table('Clients')->where('idEmpresa', $idEmpresa)->get(['idClient', 'Name']);
            return response()->json(['success' => true, 'items' => $clients]);
        });
        
        Route::get('/leads', function (\Illuminate\Http\Request $request) {
            $idEmpresa = $request->session()->get('empresa_id');
            $leads = DB::table('Leads')->where('idEmpresa', $idEmpresa)->get(['idLead', 'Name']);
            return response()->json(['success' => true, 'items' => $leads]);
        });
        
        Route::get('/proyectos', function (\Illuminate\Http\Request $request) {
            $idEmpresa = $request->session()->get('empresa_id');
            $projects = DB::table('Projects')->where('idEmpresa', $idEmpresa)->get(['idProject', 'Name']);
            return response()->json(['success' => true, 'items' => $projects]);
        });
        
        Route::get('/ventas/propuestas', function (\Illuminate\Http\Request $request) {
            $idEmpresa = $request->session()->get('empresa_id');
            $sales = DB::table('SalesProposals')->where('idEmpresa', $idEmpresa)->get(['idSalesProposals', 'Title']);
            return response()->json(['success' => true, 'items' => $sales]);
        });
    });
});
