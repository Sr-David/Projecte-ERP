@extends('layouts.app')

@section('title', 'Propuestas de Venta')
@section('header', 'Propuestas de Venta')
@section('breadcrumb')
    <a href="javascript:history.back()"
       class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-700 rounded hover:bg-gray-200 text-xs font-medium mr-2 transition-colors">
        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        Volver
    </a>
    Ventas / Propuestas
@endsection

@section('content')
    <div class="max-w-5xl mx-auto py-8">


    
        <h1 class="text-2xl font-bold mb-6">Propuestas de Venta</h1>

        <div class="mb-4 flex justify-end">
            <a href="{{ route('ventas.propuestas.create') }}"
                class="inline-flex items-center px-4 py-2 bg-brand-blue text-white rounded hover:bg-blue-700 text-sm font-medium shadow">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Nueva Propuesta
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($propuestas as $propuesta)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-2">{{ $propuesta->idSalesProposals ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $propuesta->client->Name ?? 'Sin cliente' }}</td>
                                <td class="px-4 py-2">
                                    @if($propuesta->State === 'Efectuada')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            {{ $propuesta->State }}
                                        </span>
                                    @elseif($propuesta->State === 'Cancelada')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            {{ $propuesta->State }}
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            {{ $propuesta->State }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-2">
                                    {{ $propuesta->CreatedAt ? \Carbon\Carbon::parse($propuesta->CreatedAt)->format('d/m/Y') : '-' }}
                                </td>
                                <td class="px-4 py-2">
                                    @if($propuesta->State === 'Cancelada')
                                        <form action="{{ route('ventas.propuestas.rehabilitar', $propuesta->idSalesProposals) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="inline-flex items-center px-3 py-1 bg-yellow-500 text-white rounded text-xs hover:bg-yellow-600 transition-colors"
                                                onclick="return confirm('¿Seguro que quieres volver a habilitar esta propuesta?')">
                                                Volver a habilitar
                                            </button>
                                        </form>
                                    @elseif($propuesta->State !== 'Efectuada')
                                        <a href="{{ route('ventas.propuestas.confirmar', $propuesta->idSalesProposals) }}"
                                        class="inline-flex items-center px-3 py-1 bg-brand-blue text-white rounded text-xs hover:bg-blue-700 mr-2 transition-colors">
                                            Confirmar
                                        </a>
                                        <form action="{{ route('ventas.propuestas.cancelar', $propuesta->idSalesProposals) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="inline-flex items-center px-3 py-1 bg-red-500 text-white rounded text-xs hover:bg-red-600 transition-colors"
                                                onclick="return confirm('¿Seguro que quieres cancelar esta propuesta?')">
                                                Cancelar
                                            </button>
                                        </form>
                                    @elseif($propuesta->State === 'Efectuada')
                                        <span class="inline-flex items-center px-3 py-1 bg-gray-400 text-white rounded text-xs cursor-not-allowed mr-2">
                                            Efectuada
                                        </span>
                                        <a href="{{ route('ventas.propuestas.confirmar', $propuesta->idSalesProposals) }}"
                                        class="inline-flex items-center px-3 py-1 bg-brand-blue text-white rounded text-xs hover:bg-blue-700">
                                            Volver a realizar
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-4 text-center text-gray-500">No hay propuestas registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $propuestas->links() }}
            </div>
        </div>
    </div>
@endsection