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
        $products = ProductsServices::all();
        return view('productos.index', compact('products'));
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