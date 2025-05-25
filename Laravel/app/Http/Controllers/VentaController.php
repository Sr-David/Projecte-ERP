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

        // Ventas por fecha
        $ventasPorFecha = \App\Models\SalesDetails::selectRaw('DATE(created_at) as fecha, SUM(QuantitySold) as total')
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();
        $labels = $ventasPorFecha->pluck('fecha')->map(fn($fecha) => \Carbon\Carbon::parse($fecha)->format('d/m/Y'))->toArray();
        $valores = $ventasPorFecha->pluck('total')->toArray();

        // Ventas por producto
        $ventasPorProducto = \App\Models\SalesDetails::selectRaw('ProductServiceID, COUNT(*) as total')
            ->groupBy('ProductServiceID')
            ->with('productService')
            ->get();

        $productosLabels = $ventasPorProducto->map(fn($v) => $v->productService->Name ?? 'Desconocido')->toArray();
        $productosValores = $ventasPorProducto->pluck('total')->toArray();


        $productos = \App\Models\ProductsServices::all();
        $ventasPorProductoYFecha = \App\Models\SalesDetails::selectRaw('ProductServiceID, DATE(created_at) as fecha, COUNT(*) as total')
            ->groupBy('ProductServiceID', 'fecha')
            ->orderBy('fecha')
            ->get();



        $fechasUnicas = $ventasPorProductoYFecha->pluck('fecha')->unique()->sort()->values()->toArray();

        $productosUnicos = $ventasPorProductoYFecha->pluck('productService')->unique('id')->values();


        $fechasTodas = $ventasPorProductoYFecha->pluck('fecha')->unique()->sort()->values()->toArray();


        $ventasTotalesPorFecha = [];
        foreach ($fechasTodas as $fecha) {
            $ventasTotalesPorFecha[$fecha] = $ventasPorProductoYFecha->where('fecha', $fecha)->sum('total');
        }



        $ventasPorProductoParaSelector = [
            'all' => [
                'nombre' => 'Todos los productos',
                'fechas' => array_map(fn($f) => \Carbon\Carbon::parse($f)->format('d/m/Y'), $fechasTodas),
                'valores' => array_values($ventasTotalesPorFecha),
            ]
        ];
        foreach ($productos as $producto) {
            $ventas = $ventasPorProductoYFecha->where('ProductServiceID', $producto->idProductService)->keyBy('fecha');
            $valores = [];
            foreach ($fechasTodas as $fecha) {
                $valores[] = isset($ventas[$fecha]) ? $ventas[$fecha]->total : 0;
            }
            $ventasPorProductoParaSelector[$producto->idProductService] = [
                'nombre' => $producto->Name,
                'fechas' => array_map(fn($f) => \Carbon\Carbon::parse($f)->format('d/m/Y'), $fechasTodas),
                'valores' => $valores,
            ];
        }





        return view('ventas.resumen', compact(
            'ventasCount',
            'propuestasCount',
            'labels',
            'valores', // <-- Añade esta línea
            'productosLabels',
            'productosValores',
            'fechasUnicas',
            'productos',
            'ventasPorProductoParaSelector'
        ));
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

        // Obtener el idEmpresa del usuario autenticado
        $userId = session('user_id');
        $user = \DB::table('Users')->where('idUser', $userId)->first();
        if (!$user || !$user->idEmpresa) {
            return redirect()->back()->with('error', 'No se pudo determinar la empresa.');
        }

        \App\Models\SalesProposals::create([
            'ClientID' => $request->ClientID,
            'State' => $request->State,
            'Details' => $request->Details,
            'CreatedAt' => now(),
            'idEmpresa' => $user->idEmpresa, // <-- Añade esto
        ]);

        return redirect()->route('ventas.propuestas')->with('success', 'Propuesta creada correctamente');
    }



    public function confirmarPropuesta($id)
    {
        $propuesta = \App\Models\SalesProposals::findOrFail($id);
        $productos = \App\Models\ProductsServices::all();
        $ultimoDetalle = \App\Models\SalesDetails::where('ProposalID', $propuesta->idSalesProposals)
            ->orderByDesc('created_at')
            ->first();

        return view('ventas.confirmar-propuesta', compact('propuesta', 'productos', 'ultimoDetalle'));
    }


    public function efectuarPropuesta(Request $request, $id)
    {
        $propuesta = \App\Models\SalesProposals::findOrFail($id);

        $request->validate([
            'ProductServiceID' => 'required|exists:ProductsServices,idProductService',
            'QuantitySold' => 'required|integer|min:1',
            'UnitPrice' => 'required|numeric|min:0',
        ]);

        // Actualizar estado de la propuesta
        $propuesta->State = 'Efectuada';
        $propuesta->save();

        // Crear detalle de venta
        \App\Models\SalesDetails::create([
            'ProposalID' => $propuesta->idSalesProposals,
            'ProductServiceID' => $request->ProductServiceID,
            'QuantitySold' => $request->QuantitySold,
            'UnitPrice' => $request->UnitPrice,
            'idEmpresa' => $propuesta->idEmpresa,
            'created_at' => now()
        ]);

        // Reducir el stock del producto
        $producto = \App\Models\ProductsServices::findOrFail($request->ProductServiceID);
        $producto->Stock = max(0, $producto->Stock - $request->QuantitySold);
        $producto->save();

        return redirect()->route('ventas.ventas')->with('success', 'Propuesta confirmada como venta.');
    }



    public function cancelarPropuesta($id)
    {
        $propuesta = \App\Models\SalesProposals::findOrFail($id);
        $propuesta->State = 'Cancelada';
        $propuesta->save();

        return redirect()->route('ventas.propuestas')->with('success', 'Propuesta cancelada correctamente.');
    }



    public function rehabilitarPropuesta($id)
    {
        $propuesta = \App\Models\SalesProposals::findOrFail($id);
        $propuesta->State = 'En negociación';
        $propuesta->save();

        return redirect()->route('ventas.propuestas')->with('success', 'Propuesta habilitada correctamente.');
    }


    public function editPropuesta($id)
    {
        $propuesta = \App\Models\SalesProposals::with('client')->findOrFail($id);
        $clientes = \App\Models\Clients::all();
        return view('ventas.editar-propuesta', compact('propuesta', 'clientes'));
    }


    public function updatePropuesta(Request $request, $id)
    {
        $propuesta = \App\Models\SalesProposals::findOrFail($id);

        $request->validate([
            'ClientID' => 'required|exists:Clients,idClient',
            'State' => 'required|string|max:50',
            'Details' => 'nullable|string',
        ]);

        $propuesta->ClientID = $request->ClientID;
        $propuesta->State = $request->State;
        $propuesta->Details = $request->Details;
        $propuesta->save();

        return redirect()->route('ventas.propuestas')->with('success', 'Propuesta actualizada correctamente.');
    }


}
