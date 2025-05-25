<?php

namespace App\Http\Controllers;

use App\Models\ProductsServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductsServicesController extends Controller
{
    /**
     * Display a listing of products and services.
     */
public function index()
{
    $products = \App\Models\ProductsServices::all();

    // Ventas por producto
    $ventasPorProducto = \App\Models\SalesDetails::selectRaw('ProductServiceID, COUNT(*) as total')
        ->groupBy('ProductServiceID')
        ->with('productService')
        ->get();

    $productosLabels = $ventasPorProducto->map(fn($v) => $v->productService->Name ?? 'Desconocido')->toArray();
    $productosValores = $ventasPorProducto->pluck('total')->toArray();

    // Fechas únicas de ventas (ordenadas)
    $fechas = \App\Models\SalesDetails::selectRaw('DATE(created_at) as fecha')
        ->distinct()
        ->orderBy('fecha')
        ->pluck('fecha')
        ->map(fn($f) => \Carbon\Carbon::parse($f)->format('d/m/Y'))
        ->toArray();

    // Productos por fecha de entrada
    $productosPorFecha = \App\Models\ProductsServices::selectRaw('DATE(EntryDate) as fecha, COUNT(*) as total')
        ->groupBy('fecha')
        ->orderBy('fecha')
        ->get();

    $productosFechasLabels = $productosPorFecha->pluck('fecha')->map(fn($f) => \Carbon\Carbon::parse($f)->format('d/m/Y'))->toArray();
    $productosFechasValores = $productosPorFecha->pluck('total')->toArray();

    // Gráfico de líneas: ventas por producto y fecha
    $productos = \App\Models\ProductsServices::all();
    $ventasPorProductoYFecha = \App\Models\SalesDetails::selectRaw('ProductServiceID, DATE(created_at) as fecha, COUNT(*) as total')
        ->groupBy('ProductServiceID', 'fecha')
        ->get();

    $lineChartDatasets = [];
    $colores = ['#3F95FF', '#6366F1', '#16BA81', '#F59E42', '#F43F5E', '#A855F7', '#FACC15', '#10B981', '#FFB6C1', '#FF6347', '#20B2AA', '#FFD700'];

    foreach ($productos as $i => $producto) {
        $ventasPorFecha = [];
        foreach ($fechas as $fecha) {
            $ventas = $ventasPorProductoYFecha->where('ProductServiceID', $producto->idProductService)
                ->where('fecha', \Carbon\Carbon::createFromFormat('d/m/Y', $fecha)->format('Y-m-d'))
                ->first();
            $ventasPorFecha[] = $ventas ? $ventas->total : 0;
        }
        $lineChartDatasets[] = [
            'label' => $producto->Name,
            'data' => $ventasPorFecha,
            'borderColor' => $colores[$i % count($colores)],
            'backgroundColor' => $colores[$i % count($colores)],
            'tension' => 0.3,
            'fill' => false,
        ];
    }

    return view('productos.index', compact(
        'products',
        'productosLabels',
        'productosValores',
        'productosFechasLabels',
        'productosFechasValores',
        'fechas',
        'lineChartDatasets'
    ));
}

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        return view('productos.create');
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'Name' => 'required|string|max:45',
            'Description' => 'nullable|string',
            'Price' => 'required|numeric|min:0',
            'Stock' => 'required|integer|min:0',
        ]);

        // Get the idEmpresa from the authenticated user
        $userId = session('user_id');
        $user = DB::table('Users')->where('idUser', $userId)->first();
        
        if (!$user || !$user->idEmpresa) {
            return redirect()->back()->with('error', 'Error al crear producto: no se pudo determinar la empresa.');
        }
        
        // Add additional data to the product
        $productData = $validated;
        $productData['idEmpresa'] = $user->idEmpresa;
        $productData['EntryDate'] = now();

        ProductsServices::create($productData);

        return redirect()->route('productos.index')
            ->with('success', 'Producto creado exitosamente.');
    }

    /**
     * Display the specified product.
     */
    public function show($id)
    {
        $product = ProductsServices::findOrFail($id);
        return view('productos.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit($id)
    {
        $product = ProductsServices::findOrFail($id);
        return view('productos.edit', compact('product'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, $id)
    {
        $product = ProductsServices::findOrFail($id);
        
        $validated = $request->validate([
            'Name' => 'required|string|max:45',
            'Description' => 'nullable|string',
            'Price' => 'required|numeric|min:0',
            'Stock' => 'required|integer|min:0',
        ]);

        $product->update($validated);

        return redirect()->route('productos.index')
            ->with('success', 'Producto actualizado exitosamente.');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy($id)
    {
        $product = ProductsServices::findOrFail($id);
        
        // Check if the product is referenced in SalesDetails
        $salesDetailCount = DB::table('SalesDetails')
            ->where('ProductServiceID', $id)
            ->count();
        
        if ($salesDetailCount > 0) {
            return redirect()->route('productos.index')
                ->with('error', 'No se puede eliminar el producto porque está asociado a ventas.');
        }
        
        $product->delete();

        return redirect()->route('productos.index')
            ->with('success', 'Producto eliminado exitosamente.');
    }
} 