<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalesDetails;
use App\Models\SalesProposal;

use App\Models\Clients;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ventas = \App\Models\SalesDetails::with('client')->orderBy('idSaleDetail', 'desc')->paginate(10);

        return view('ventas.ventas', compact('ventas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }



    public function resumen()
    {
        $ventasCount = \App\Models\SalesDetails::count();
        $propuestasCount = \App\Models\SalesProposals::count();
        return view('ventas.resumen', compact('ventasCount', 'propuestasCount'));
    }

    public function propuestas()
    {
        $propuestas = \App\Models\SalesProposals::with('client')->orderBy('CreatedAt', 'desc')->paginate(10);
        return view('ventas.propuestas', compact('propuestas'));
    }

    public function crearPropuesta()
    {
        $clientes = \App\Models\Clients::all();
        return view('ventas.crear-propuesta', compact('clientes'));
    }

    public function guardarPropuesta(Request $request)
    {
        $request->validate([
            'ClientID' => 'required|exists:Clients,idClient',
            'State' => 'required|string|max:50',
            'Details' => 'nullable|string',
        ]);

        \App\Models\SalesProposals::create([
            'ClientID' => $request->ClientID,
            'State' => $request->State,
            'Details' => $request->Details,
            'CreatedAt' => now(),
        ]);

        return redirect()->route('ventas.propuestas')->with('success', 'Propuesta creada correctamente');
    }

}
