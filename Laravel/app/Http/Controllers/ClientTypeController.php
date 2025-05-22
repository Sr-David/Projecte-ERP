<?php

namespace App\Http\Controllers;

use App\Models\ClientType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientTypes = ClientType::all();
        return response()->json(['success' => true, 'data' => $clientTypes]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar la petición
        $validator = Validator::make($request->all(), [
            'ClientType' => 'required|string|max:45',
            'Description' => 'nullable|string',
            'idEmpresa' => 'required|integer|exists:UserAdministration,idEmpresa',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Datos invalidos',
                'errors' => $validator->errors()
            ], 422);
        }

        // Crear el nuevo tipo de cliente
        $clientType = new ClientType();
        $clientType->ClientType = $request->ClientType;
        $clientType->Description = $request->Description;
        $clientType->idEmpresa = $request->idEmpresa;
        $clientType->save();

        return response()->json([
            'success' => true,
            'message' => 'Tipo de cliente creado correctamente',
            'clientType' => $clientType
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(ClientType $clientType)
    {
        return response()->json(['success' => true, 'data' => $clientType]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ClientType $clientType)
    {
        // Validar la petición
        $validator = Validator::make($request->all(), [
            'ClientType' => 'required|string|max:45',
            'Description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Datos invalidos',
                'errors' => $validator->errors()
            ], 422);
        }

        // Actualizar el tipo de cliente
        $clientType->ClientType = $request->ClientType;
        $clientType->Description = $request->Description;
        $clientType->save();

        return response()->json([
            'success' => true,
            'message' => 'Tipo de cliente actualizado correctamente',
            'clientType' => $clientType
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClientType $clientType)
    {
        // Verificar si el tipo de cliente está en uso
        if ($clientType->clients()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede eliminar el tipo de cliente porque está en uso'
            ], 400);
        }

        $clientType->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tipo de cliente eliminado correctamente'
        ]);
    }
} 