@extends('layouts.app')

@section('title', 'Confirmar Propuesta de Venta')
@section('content')
    <div class="max-w-xl mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Confirmar Propuesta #{{ $propuesta->idSalesProposals }}</h1>
        <form action="{{ route('ventas.propuestas.efectuar', $propuesta->idSalesProposals) }}" method="POST"
            class="bg-white rounded shadow p-6 space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Producto/Servicio *</label>
                <select name="ProductServiceID" class="w-full rounded border-gray-300" required>
                    <option value="">Selecciona un producto/servicio</option>
                    @foreach($productos as $producto)
                        <option value="{{ $producto->idProductService }}"
                            {{ $loop->first ? 'selected' : '' }}>
                            {{ $producto->Name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Cantidad *</label>
                <input type="number" name="QuantitySold" class="w-full rounded border-gray-300" min="1" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Precio Unitario *</label>
                <input type="number" name="UnitPrice" class="w-full rounded border-gray-300 bg-gray-100"
                    value="{{ count($productos) ? $productos[0]->Price : '' }}" min="0" step="0.01" readonly required>
            </div>
            <div class="flex justify-end space-x-2">
                <a href="{{ route('ventas.propuestas') }}"
                    class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Cancelar</a>
                <button type="submit" class="px-4 py-2 bg-brand-blue text-white rounded hover:bg-blue-700">Confirmar
                    Venta</button>
            </div>
        </form>
    </div>
@endsection