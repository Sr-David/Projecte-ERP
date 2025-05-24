@extends('layouts.app')

@section('title', 'Ventas Confirmadas')
@section('header', 'Ventas Confirmadas')
@section('breadcrumb')
    <a href="javascript:history.back()"
       class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-700 rounded hover:bg-gray-200 text-xs font-medium mr-2 transition-colors">
        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        Volver
    </a>
    Ventas / Confirmadas
@endsection

@section('content')
    <div class="max-w-5xl mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Ventas Confirmadas</h1>
        <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Producto</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Importe Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($ventas as $venta)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-2">{{ $venta->idSaleDetail ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $venta->salesProposal->client->Name ?? 'Sin cliente' }}</td>
                                <td class="px-4 py-2">{{ $venta->productService->Name ?? 'Sin producto' }}</td>
                                <td class="px-4 py-2">{{ $venta->QuantitySold }}</td>
                                <td class="px-4 py-2">
                                    {{ number_format($venta->UnitPrice * $venta->QuantitySold, 2) }} €
                                </td>
                                <td class="px-4 py-2">
                                    @if($venta->salesProposal->State === 'Efectuada')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            {{ $venta->salesProposal->State }}
                                        </span>
                                    @elseif($venta->salesProposal->State === 'Cancelada')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            {{ $venta->salesProposal->State }}
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            {{ $venta->salesProposal->State }}
                                        </span>
                                    @endif
                                </td>
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
            </div>
            <div class="mt-4">
                {{ $ventas->links() }}
            </div>
        </div>
    </div>
@endsection