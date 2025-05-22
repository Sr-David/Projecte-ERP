<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use App\Models\ClientType;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    /**
     * Display a listing of clients.
     */
    public function index()
    {
        $clients = Clients::all();
        return view('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new client.
     */
    public function create()
    {
        $clientTypes = ClientType::all();
        return view('clients.create', compact('clientTypes'));
    }

    /**
     * Store a newly created client in storage.
     */
    public function store(Request $request)
    {
        \Log::info('Request completo antes de validación:', $request->all());
        \Log::info('clientTypeId recibido: ' . $request->input('clientTypeId', 'NO RECIBIDO'));
        
        $validated = $request->validate([
            'Name' => 'required|string|max:255',
            'LastName' => 'required|string|max:255',
            'Email' => 'required|email|unique:clients,Email',
            'Phone' => 'required|string|max:20',
            'Address' => 'nullable|string|max:255',
            'clientTypeId' => 'required|integer|exists:ClientType,idClientType',
        ]);

        \Log::info('Datos validados:', $validated);

        // Mapear el nombre del campo para que coincida con la columna de la base de datos
        $clientData = $request->all();
        $clientData['ClientTypeID'] = $clientData['clientTypeId'];
        unset($clientData['clientTypeId']);
        
        // Obtener el idEmpresa del usuario autenticado desde la sesión
        $userId = session('user_id');
        $user = \DB::table('Users')->where('idUser', $userId)->first();
        
        if (!$user || !$user->idEmpresa) {
            \Log::error('No se pudo obtener el idEmpresa del usuario: ' . $userId);
            return redirect()->back()->with('error', 'Error al crear cliente: no se pudo determinar la empresa.');
        }
        
        // Asignar el idEmpresa al cliente
        $clientData['idEmpresa'] = $user->idEmpresa;
        
        \Log::info('Datos del cliente a crear:', $clientData);

        Clients::create($clientData);

        return redirect()->route('clients.index')
            ->with('success', 'Cliente creado exitosamente.');
    }

    /**
     * Display the specified client.
     */
    public function show($id)
    {
        $client = Clients::findOrFail($id);
        return view('clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified client.
     */
    public function edit($id)
    {
        $client = Clients::findOrFail($id);
        $clientTypes = ClientType::all();
        return view('clients.edit', compact('client', 'clientTypes'));
    }

    /**
     * Update the specified client in storage.
     */
    public function update(Request $request, $id)
    {
        // Buscar el cliente directamente por su ID
        $client = Clients::findOrFail($id);
        
        \Log::info('Solicitud de update recibida: ', [
            'cliente_id' => $id,
            'datos' => $request->all()
        ]);
        
        $validated = $request->validate([
            'Name' => 'required|string|max:255',
            'LastName' => 'required|string|max:255',
            'Email' => 'required|email|unique:clients,Email,' . $client->idClient . ',idClient',
            'Phone' => 'required|string|max:20',
            'Address' => 'nullable|string|max:255',
            'clientTypeId' => 'required|integer|exists:ClientType,idClientType',
        ]);

        // Preparar los datos para la actualización
        $clientData = [
            'Name' => $request->input('Name'),
            'LastName' => $request->input('LastName'),
            'Email' => $request->input('Email'),
            'Phone' => $request->input('Phone'),
            'Address' => $request->input('Address'),
            'ClientTypeID' => $request->input('clientTypeId')
        ];

        // Actualizar directamente en la base de datos
        $updated = Clients::where('idClient', $id)
                         ->update($clientData);
        
        \Log::info('Resultado de la actualización: ', [
            'cliente_id' => $id,
            'actualizado' => $updated,
            'datos_enviados' => $clientData
        ]);

        return redirect()->route('clients.index')
            ->with('success', 'Cliente actualizado exitosamente.');
    }

    /**
     * Remove the specified client from storage.
     */
    public function destroy($id)
    {
        \Log::info('Solicitud de eliminación recibida para el cliente con ID: ' . $id);
        
        // Buscar el cliente directamente por su ID
        $client = Clients::find($id);
        
        if (!$client) {
            \Log::error('Cliente no encontrado con ID: ' . $id);
            return redirect()->route('clients.index')
                ->with('error', 'Cliente no encontrado.');
        }
        
        \Log::info('Cliente encontrado:', [
            'clientID' => $client->idClient,
            'nombre' => $client->Name . ' ' . $client->LastName
        ]);
        
        try {
            // Intentar eliminación directa
            $deleted = Clients::where('idClient', $id)->delete();
            
            \Log::info('Resultado de la eliminación: ' . ($deleted ? 'Éxito' : 'Fallo'));
            
            if ($deleted) {
                return redirect()->route('clients.index')
                    ->with('success', 'Cliente eliminado exitosamente.');
            } else {
                return redirect()->route('clients.index')
                    ->with('error', 'No se pudo eliminar el cliente. Puede estar siendo usado en otras tablas.');
            }
        } catch (\Exception $e) {
            \Log::error('Error al eliminar cliente: ' . $e->getMessage());
            return redirect()->route('clients.index')
                ->with('error', 'Error al eliminar el cliente: ' . $e->getMessage());
        }
    }
} 