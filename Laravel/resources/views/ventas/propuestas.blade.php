@extends('layouts.app')

@section('title', 'Propuestas de Venta')
@section('header', 'Propuestas de Venta')
@section('breadcrumb', 'Ventas / Propuestas')

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

        <div class="bg-white rounded shadow p-6">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                        <th class="px-4 py-2"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($propuestas as $propuesta)
                        <tr>
                            <td class="px-4 py-2">{{ $propuesta->idSalesProposals ?? $propuesta->idSalesProposals ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $propuesta->client->Name ?? 'Sin cliente' }}</td>
                            <td class="px-4 py-2">{{ $propuesta->State }}</td>
                            <td class="px-4 py-2">
                                {{ $propuesta->CreatedAt ? \Carbon\Carbon::parse($propuesta->CreatedAt)->format('d/m/Y') : '-' }}
                            </td>
                           <td class="px-4 py-2">
                                @if($propuesta->State !== 'Efectuada')
                                    <a href="{{ route('ventas.propuestas.confirmar', $propuesta->idSalesProposals) }}"
                                    class="inline-flex items-center px-3 py-1 bg-green-600 text-white rounded text-xs hover:bg-green-700 mr-2">
                                        Confirmar
                                    </a>
                                    
                                     <form action="{{ route('ventas.propuestas.cancelar', $propuesta->idSalesProposals) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-3 py-1 bg-red-600 text-white rounded text-xs hover:bg-red-700"
                                            onclick="return confirm('¿Seguro que quieres cancelar esta propuesta?')">
                                            Cancelar
                                        </button>
                                    </form>
                                @elseif($propuesta->State === 'Efectuada')
                                    <button type="submit" class="inline-flex items-center px-3 py-1 bg-red-600 text-white rounded text-xs hover:bg-red-700">
                                        Efectuada
                                    </button>

                                    <a href="{{ route('ventas.propuestas.confirmar', $propuesta->idSalesProposals) }}"
                                    class="inline-flex items-center px-3 py-1 bg-green-600 text-white rounded text-xs hover:bg-green-700 mr-2">
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
            <div class="mt-4">
                {{ $propuestas->links() }}
            </div>
        </div>
    </div>
@endsection