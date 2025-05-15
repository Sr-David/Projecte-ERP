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

        Clients::create($clientData);

        return redirect()->route('clients.index')
            ->with('success', 'Cliente creado exitosamente.');
    }

    /**
     * Display the specified client.
     */
    public function show(Clients $client)
    {
        return view('clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified client.
     */
    public function edit(Clients $client)
    {
        $clientTypes = ClientType::all();
        return view('clients.edit', compact('client', 'clientTypes'));
    }

    /**
     * Update the specified client in storage.
     */
    public function update(Request $request, Clients $client)
    {
        $request->validate([
            'Name' => 'required|string|max:255',
            'LastName' => 'required|string|max:255',
            'Email' => 'required|email|unique:clients,Email,' . $client->idClient,
            'Phone' => 'required|string|max:20',
            'Address' => 'nullable|string|max:255',
            'clientTypeId' => 'required|integer|exists:ClientType,idClientType',
        ]);

        // Mapear el nombre del campo para que coincida con la columna de la base de datos
        $clientData = $request->all();
        $clientData['ClientTypeID'] = $clientData['clientTypeId'];
        unset($clientData['clientTypeId']);

        $client->update($clientData);

        return redirect()->route('clients.index')
            ->with('success', 'Cliente actualizado exitosamente.');
    }

    /**
     * Remove the specified client from storage.
     */
    public function destroy(Clients $client)
    {
        $client->delete();

        return redirect()->route('clients.index')
            ->with('success', 'Cliente eliminado exitosamente.');
    }
} 