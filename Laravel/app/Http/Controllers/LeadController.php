<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Clients;
use App\Models\ClientType;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    /**
     * Display a listing of leads.
     */
    public function index()
    {
        $leads = Lead::all();
        return view('leads.index', compact('leads'));
    }

    /**
     * Show the form for creating a new lead.
     */
    public function create()
    {
        $clientTypes = ClientType::all();
        return view('leads.create', compact('clientTypes'));
    }

    /**
     * Store a newly created lead in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'Name' => 'required|string|max:255',
            'LastName' => 'required|string|max:255',
            'Email' => 'required|email|unique:Leads,Email',
            'Phone' => 'required|string|max:20',
            'Address' => 'nullable|string|max:255',
            'ClientTypeID' => 'required|integer|exists:ClientType,idClientType',
            'Source' => 'required|string|max:100',
            'Notes' => 'nullable|string',
        ]);

        // Obtener el idEmpresa del usuario autenticado desde la sesión
        $userId = session('user_id');
        $user = \DB::table('Users')->where('idUser', $userId)->first();
        
        if (!$user || !$user->idEmpresa) {
            return redirect()->back()->with('error', 'Error al crear lead: no se pudo determinar la empresa.');
        }
        
        // Asignar el idEmpresa al lead
        $leadData = $validated;
        $leadData['idEmpresa'] = $user->idEmpresa;
        $leadData['Status'] = 'New';
        $leadData['CreatedAt'] = now();
        $leadData['UpdatedAt'] = now();

        Lead::create($leadData);

        return redirect()->route('leads.index')
            ->with('success', 'Lead creado exitosamente.');
    }

    /**
     * Display the specified lead.
     */
    public function show($id)
    {
        $lead = Lead::findOrFail($id);
        return view('leads.show', compact('lead'));
    }

    /**
     * Show the form for editing the specified lead.
     */
    public function edit($id)
    {
        $lead = Lead::findOrFail($id);
        $clientTypes = ClientType::all();
        return view('leads.edit', compact('lead', 'clientTypes'));
    }

    /**
     * Update the specified lead in storage.
     */
    public function update(Request $request, $id)
    {
        $lead = Lead::findOrFail($id);
        
        $validated = $request->validate([
            'Name' => 'required|string|max:255',
            'LastName' => 'required|string|max:255',
            'Email' => 'required|email|unique:Leads,Email,' . $lead->idLead . ',idLead',
            'Phone' => 'required|string|max:20',
            'Address' => 'nullable|string|max:255',
            'ClientTypeID' => 'required|integer|exists:ClientType,idClientType',
            'Source' => 'required|string|max:100',
            'Status' => 'required|string|max:50',
            'Notes' => 'nullable|string',
        ]);

        $lead->update($validated);
        $lead->UpdatedAt = now();
        $lead->save();

        return redirect()->route('leads.index')
            ->with('success', 'Lead actualizado exitosamente.');
    }

    /**
     * Remove the specified lead from storage.
     */
    public function destroy($id)
    {
        $lead = Lead::findOrFail($id);
        $lead->delete();

        return redirect()->route('leads.index')
            ->with('success', 'Lead eliminado exitosamente.');
    }

    /**
     * Convert lead to client
     */
    public function convertToClient($id)
    {
        $lead = Lead::findOrFail($id);

        // Create new client from lead data
        $client = new Clients([
            'Name' => $lead->Name,
            'LastName' => $lead->LastName,
            'Email' => $lead->Email,
            'Phone' => $lead->Phone,
            'Address' => $lead->Address,
            'ClientTypeID' => $lead->ClientTypeID,
            'idEmpresa' => $lead->idEmpresa,
            'CreatedAt' => now(),
            'UpdatedAt' => now()
        ]);

        $client->save();
        
        // Optional: Delete lead after conversion or mark as converted
        $lead->Status = 'Converted';
        $lead->UpdatedAt = now();
        $lead->save();

        return redirect()->route('leads.index')
            ->with('success', 'Lead convertido a cliente exitosamente.');
    }
} 