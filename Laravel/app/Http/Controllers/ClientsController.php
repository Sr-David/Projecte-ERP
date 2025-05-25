<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\PermissionService;
use App\Models\Clients;
use App\Models\ClientType;

class ClientsController extends Controller
{
    protected $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!$this->permissionService->hasPermission('clientes', 'ver')) {
            return redirect('/dashboard')->with('error', 'No tienes permiso para ver clientes');
        }
        
        // Usamos el modelo Eloquent y cargamos la relación clientType con paginación
        $clients = Clients::with('clientType')->paginate(10);
        
        // Obtenemos los tipos de cliente para los filtros
        $clientTypes = ClientType::all();
        
        // Calculamos el conteo de clientes por tipo
        $clientTypeCounts = $clientTypes->map(function($type) {
            return [
                'label' => $type->ClientType,
                'count' => $type->clients()->count(),
            ];
        });

        $clientsByAddress = \App\Models\Clients::selectRaw('Address as address, COUNT(*) as count')
    ->whereNotNull('Address')
    ->where('Address', '!=', '')
    ->groupBy('Address')
    ->orderByDesc('count')
    ->limit(10)
    ->get();
        
    return view('clients.index', compact('clients', 'clientTypeCounts', 'clientsByAddress'));

}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!$this->permissionService->hasPermission('clientes', 'crear')) {
            return redirect('/dashboard')->with('error', 'No tienes permiso para crear clientes');
        }
        
        // Obtener tipos de cliente para el formulario
        $clientTypes = ClientType::all();
        return view('clients.create', compact('clientTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!$this->permissionService->hasPermission('clientes', 'crear')) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'No tienes permiso para crear clientes'], 403);
            }
            return redirect('/dashboard')->with('error', 'No tienes permiso para crear clientes');
        }

        // Log para depuración
        \Illuminate\Support\Facades\Log::info("Creando cliente: Inicio del proceso");
        \Illuminate\Support\Facades\Log::info("Datos recibidos:", $request->all());
        
        // Validación y creación del cliente
        $validated = $request->validate([
            'Name' => 'required|string|max:100',
            'LastName' => 'nullable|string|max:100',
            'Email' => 'required|email|max:100',
            'Phone' => 'nullable|string|max:20',
            'Address' => 'nullable|string|max:255',
            'ClientTypeID' => 'nullable|exists:ClientType,idClientType'
        ]);
        
        \Illuminate\Support\Facades\Log::info("Datos validados:", $validated);

        try {
            // Obtener el ID de empresa directamente de la sesión
            $userId = session('user_id');
            $empresaId = session('empresa_id');
            $userType = session('user_type');
            
            \Illuminate\Support\Facades\Log::info("Información de sesión:", [
                'userId' => $userId, 
                'empresaId' => $empresaId,
                'userType' => $userType
            ]);
            
            if (!$userId || !$empresaId) {
                \Illuminate\Support\Facades\Log::error("No se encontró información de usuario/empresa en la sesión");
                return redirect()->route('clients.create')->with('error', 'Error de sesión. Por favor, vuelve a iniciar sesión.');
            }
            
            // Si es un usuario administrador, usar directamente su ID como ID de empresa
            if ($userType === 'admin') {
                \Illuminate\Support\Facades\Log::info("Usuario es administrador, usando idEmpresa directamente: $empresaId");
            } else {
                // Verificar que el usuario exista
                $user = DB::table('Users')->where('idUser', $userId)->first();
                
                if (!$user) {
                    \Illuminate\Support\Facades\Log::error("No se encontró usuario con ID: $userId");
                    return redirect()->route('clients.create')->with('error', 'No se pudo verificar tu cuenta. Por favor, vuelve a iniciar sesión.');
                }
                
                \Illuminate\Support\Facades\Log::info("Usuario encontrado:", ['idUser' => $user->idUser, 'idEmpresa' => $user->idEmpresa ?? 'No especificado']);
                
                if (!isset($user->idEmpresa)) {
                    \Illuminate\Support\Facades\Log::error("Usuario no tiene idEmpresa asignado");
                    return redirect()->route('clients.create')->with('error', 'Tu cuenta no tiene una empresa asignada');
                }
                
                // Verificar que el ID de empresa coincida con el de la sesión
                if ($user->idEmpresa != $empresaId) {
                    \Illuminate\Support\Facades\Log::warning("Discrepancia en idEmpresa: Usuario tiene {$user->idEmpresa}, sesión tiene {$empresaId}");
                    // Corregir el ID de empresa para usar el del usuario
                    $empresaId = $user->idEmpresa;
                }
            }
            
            // Crear el cliente usando el modelo
            $client = new Clients([
                'Name' => $validated['Name'],
                'LastName' => $validated['LastName'] ?? '',
                'Email' => $validated['Email'],
                'Phone' => $validated['Phone'] ?? null,
                'Address' => $validated['Address'] ?? null,
                'ClientTypeID' => $validated['ClientTypeID'] ?? null,
                'idEmpresa' => $empresaId,
            ]);
            
            \Illuminate\Support\Facades\Log::info("Cliente a guardar:", $client->toArray());
            
            $saved = $client->save();
            
            if (!$saved) {
                \Illuminate\Support\Facades\Log::error("Error al guardar el cliente");
                return redirect()->route('clients.create')->with('error', 'No se pudo guardar el cliente');
            }
            
            \Illuminate\Support\Facades\Log::info("Cliente guardado con éxito, ID: " . $client->idClient);
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'Cliente creado correctamente']);
            }
            
            return redirect()->route('clients.index')->with('success', 'Cliente creado correctamente. ID: ' . $client->idClient);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Excepción al crear cliente: " . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('clients.create')->with('error', 'Error al crear cliente: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (!$this->permissionService->hasPermission('clientes', 'ver')) {
            return redirect('/dashboard')->with('error', 'No tienes permiso para ver clientes');
        }
        
        // Usar el modelo y cargar la relación
        $client = Clients::with('clientType')->find($id);
        if (!$client) {
            return redirect()->route('clients.index')->with('error', 'Cliente no encontrado');
        }
        
        return view('clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (!$this->permissionService->hasPermission('clientes', 'editar')) {
            return redirect('/dashboard')->with('error', 'No tienes permiso para editar clientes');
        }
        
        // Usar el modelo y cargar la relación
        $client = Clients::find($id);
        if (!$client) {
            return redirect()->route('clients.index')->with('error', 'Cliente no encontrado');
        }
        
        // Obtener tipos de cliente para el formulario
        $clientTypes = ClientType::all();
        
        return view('clients.edit', compact('client', 'clientTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (!$this->permissionService->hasPermission('clientes', 'editar')) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'No tienes permiso para editar clientes'], 403);
            }
            return redirect('/dashboard')->with('error', 'No tienes permiso para editar clientes');
        }
        
        // Validación
        $validated = $request->validate([
            'Name' => 'required|string|max:100',
            'LastName' => 'nullable|string|max:100',
            'Email' => 'required|email|max:100',
            'Phone' => 'nullable|string|max:20',
            'Address' => 'nullable|string|max:255',
            'ClientTypeID' => 'nullable|exists:ClientType,idClientType'
        ]);
        
        // Encontrar y actualizar cliente usando el modelo
        $client = Clients::find($id);
        if (!$client) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Cliente no encontrado'], 404);
            }
            return redirect()->route('clients.index')->with('error', 'Cliente no encontrado');
        }
        
        $client->fill([
            'Name' => $validated['Name'],
            'LastName' => $validated['LastName'] ?? $client->LastName,
            'Email' => $validated['Email'],
            'Phone' => $validated['Phone'] ?? $client->Phone,
            'Address' => $validated['Address'] ?? $client->Address,
            'ClientTypeID' => $validated['ClientTypeID'] ?? $client->ClientTypeID,
        ]);
        
        $client->save();
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Cliente actualizado correctamente']);
        }
        
        return redirect()->route('clients.index', $id)->with('success', 'Cliente actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        if (!$this->permissionService->hasPermission('clientes', 'borrar')) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'No tienes permiso para eliminar clientes'], 403);
            }
            return redirect('/dashboard')->with('error', 'No tienes permiso para eliminar clientes');
        }
        
        // Verificar que el cliente exista usando el modelo
        $client = Clients::find($id);
        if (!$client) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Cliente no encontrado'], 404);
            }
            return redirect()->route('clients.index')->with('error', 'Cliente no encontrado');
        }
        
        // Eliminar cliente
        $client->delete();
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Cliente eliminado correctamente']);
        }
        
        return redirect()->route('clients.index')->with('success', 'Cliente eliminado correctamente');
    }
} 