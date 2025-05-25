@extends('layouts.app')

@section('title', 'Detalles de Lead')
@section('header', 'Detalles de Lead')
@section('breadcrumb', 'Leads / Detalles')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Mensajes de estado -->
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm" role="alert">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Información del Lead -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">Información de Lead</h3>
                <div class="flex space-x-2">
                    <a href="{{ route('leads.edit', $lead->idLead) }}" 
                        class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-sm rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                        Editar
                    </a>
                    
                    @if($lead->Status !== 'Converted')
                        <form action="{{ route('leads.convert', $lead->idLead) }}" method="POST" class="inline-block">
                            @csrf
                            <button type="submit" 
                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm rounded-md text-white bg-green-600 hover:bg-green-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Convertir a Cliente
                            </button>
                        </form>
                    @endif
                </div>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Información básica -->
                    <div>
                        <div class="flex flex-col space-y-4">
                            <div>
                                <h4 class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Nombre completo</h4>
                                <p class="text-sm text-gray-900">{{ $lead->Name }} {{ $lead->LastName }}</p>
                            </div>
                            
                            <div>
                                <h4 class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Email</h4>
                                <p class="text-sm text-gray-900">{{ $lead->Email }}</p>
                            </div>
                            
                            <div>
                                <h4 class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Teléfono</h4>
                                <p class="text-sm text-gray-900">{{ $lead->Phone }}</p>
                            </div>
                            
                            <div>
                                <h4 class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Dirección</h4>
                                <p class="text-sm text-gray-900">{{ $lead->Address ?? 'No especificada' }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Información de clasificación -->
                    <div>
                        <div class="flex flex-col space-y-4">
                            <div>
                                <h4 class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Tipo de Cliente</h4>
                                <p class="text-sm text-gray-900">{{ $lead->clientType ? $lead->clientType->ClientType : 'No asignado' }}</p>
                            </div>
                            
                            <div>
                                <h4 class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Origen</h4>
                                <p class="text-sm text-gray-900">{{ $lead->Source }}</p>
                            </div>
                            
                            <div>
                                <h4 class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Estado</h4>
                                @php
                                    $statusColors = [
                                        'New' => 'bg-blue-100 text-blue-800',
                                        'Contacted' => 'bg-purple-100 text-purple-800',
                                        'Qualified' => 'bg-green-100 text-green-800',
                                        'Negotiation' => 'bg-yellow-100 text-yellow-800',
                                        'Lost' => 'bg-red-100 text-red-800',
                                        'Converted' => 'bg-teal-100 text-teal-800'
                                    ];
                                    $statusLabels = [
                                        'New' => 'Nuevo',
                                        'Contacted' => 'Contactado',
                                        'Qualified' => 'Calificado',
                                        'Negotiation' => 'En Negociación',
                                        'Lost' => 'Perdido',
                                        'Converted' => 'Convertido'
                                    ];
                                    $statusColor = $statusColors[$lead->Status] ?? 'bg-gray-100 text-gray-800';
                                    $statusLabel = $statusLabels[$lead->Status] ?? $lead->Status;
                                @endphp
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColor }}">
                                    {{ $statusLabel }}
                                </span>
                            </div>
                            
                            <div>
                                <h4 class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Fechas</h4>
                                <p class="text-sm text-gray-900">
                                    <span class="block">Creado: {{ $lead->CreatedAt ? date('d/m/Y H:i', strtotime($lead->CreatedAt)) : 'No disponible' }}</span>
                                    <span class="block">Actualizado: {{ $lead->UpdatedAt ? date('d/m/Y H:i', strtotime($lead->UpdatedAt)) : 'No disponible' }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Notas -->
                    <div class="md:col-span-2 mt-4">
                        <h4 class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Notas</h4>
                        <div class="bg-gray-50 p-4 rounded-md border border-gray-200">
                            <p class="text-sm text-gray-900 whitespace-pre-wrap">{{ $lead->Notes ?? 'Sin notas registradas.' }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-between mt-8">
                    <a href="{{ route('leads.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Volver a Leads
                    </a>
                    
                    <form action="{{ route('leads.destroy', $lead->idLead) }}" method="POST" class="inline-block" id="delete-lead-form">
                        @csrf
                        @method('DELETE')
                        <button type="button" 
                            class="inline-flex items-center px-4 py-2 border border-red-300 rounded-md shadow-sm text-sm font-medium text-red-700 bg-white hover:bg-red-50"
                            onclick="confirmDelete()">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Eliminar Lead
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
    <script>
        function confirmDelete() {
            if (confirm('¿Estás seguro de que deseas eliminar este lead? Esta acción no se puede deshacer.')) {
                document.getElementById('delete-lead-form').submit();
            }
        }
    </script>
    @endsection
@endsection 