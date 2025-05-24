@extends('layouts.app')

@section('title', 'Editar Propuesta de Venta')
@section('header', 'Editar Propuesta de Venta')
@section('breadcrumb', 'Ventas / Propuestas / Editar')

@section('content')
<div class="max-w-xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Editar Propuesta de Venta</h1>
    <form action="{{ route('ventas.propuestas.update', $propuesta->idSalesProposals) }}" method="POST" class="bg-white rounded shadow p-6 space-y-6">
        @csrf
        @method('PUT')
        <div>
            <label for="ClientID" class="block text-sm font-medium text-gray-700 mb-1">Cliente *</label>
            <select name="ClientID" id="ClientID" class="w-full rounded border-gray-300" required>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->idClient }}" {{ $propuesta->ClientID == $cliente->idClient ? 'selected' : '' }}>
                        {{ $cliente->Name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="State" class="block text-sm font-medium text-gray-700 mb-1">Estado *</label>
            <select name="State" id="State" class="w-full rounded border-gray-300" required>
                <option value="En negociación" {{ $propuesta->State == 'En negociación' ? 'selected' : '' }}>En negociación</option>
                <option value="Cancelada" {{ $propuesta->State == 'Cancelada' ? 'selected' : '' }}>Cancelada</option>
                <option value="Efectuada" {{ $propuesta->State == 'Efectuada' ? 'selected' : '' }}>Efectuada</option>
            </select>
        </div>
        <div>
            <label for="Details" class="block text-sm font-medium text-gray-700 mb-1">Detalles</label>
            <textarea name="Details" id="Details" rows="4" class="w-full rounded border-gray-300">{{ old('Details', $propuesta->Details) }}</textarea>
        </div>
        <div class="flex justify-end space-x-2">
            <a href="{{ route('ventas.propuestas') }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Cancelar</a>
            <button type="submit" class="px-4 py-2 bg-brand-blue text-white rounded hover:bg-blue-700">Guardar cambios</button>
        </div>
    </form>
</div>
@endsection