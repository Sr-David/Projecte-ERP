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
        $request->validate([
            'Name' => 'required|string|max:255',
            'LastName' => 'required|string|max:255',
            'Email' => 'required|email|unique:clients,Email',
            'Phone' => 'required|string|max:20',
            'Address' => 'nullable|string|max:255',
            'ClientType_ID' => 'required|exists:ClientType,id',
        ]);

        Clients::create($request->all());

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
            'Email' => 'required|email|unique:clients,Email,' . $client->id,
            'Phone' => 'required|string|max:20',
            'Address' => 'nullable|string|max:255',
            'ClientType_ID' => 'required|exists:ClientType,id',
        ]);

        $client->update($request->all());

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