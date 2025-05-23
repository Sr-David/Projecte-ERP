@extends('layouts.app')

@section('title', 'Ventas Confirmadas')
@section('header', 'Ventas Confirmadas')
@section('breadcrumb', 'Ventas / Confirmadas')

@section('content')
    <div class="max-w-5xl mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Ventas Confirmadas</h1>
        <div class="bg-white rounded shadow p-6">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Producto</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Cantidad</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Importe Total</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                        <th class="px-4 py-2"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ventas as $venta)
                        <tr>
                            <td class="px-4 py-2">{{ $venta->idSaleDetail ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $venta->salesProposal->client->Name ?? 'Sin cliente' }}</td>
                            <td class="px-4 py-2">{{ $venta->productService->Name ?? 'Sin producto' }}</td>
                            <td class="px-4 py-2">{{ $venta->QuantitySold }}</td>
                            <td class="px-4 py-2">
                                {{ number_format($venta->UnitPrice * $venta->QuantitySold, 2) }} €
                            </td>
                            <td class="px-4 py-2">{{ $venta->salesProposal->State ?? '-' }}</td>
                            <td class="px-4 py-2">
                                {{ $venta->created_at ? \Carbon\Carbon::parse($venta->created_at)->format('d/m/Y') : '-' }}
                            </td>
                            <td class="px-4 py-2">
                                <a href="#" class="text-brand-blue hover:underline text-sm">Ver</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-4 text-center text-gray-500">No hay ventas confirmadas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4">
                {{ $ventas->links() }}
            </div>
        </div>
    </div>
@endsection