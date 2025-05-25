@extends('layouts.app')

@section('title', 'Detalles del Cliente')
@section('header', 'Detalles del Cliente')
@section('breadcrumb')
    <p class="text-sm font-medium text-gray-500 hover:text-gray-900">
        <a href="{{ route('dashboard') }}">Inicio</a> / <a href="{{ route('clients.index') }}">Clientes</a> / Detalles del Cliente
    </p>

@endsection

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Acciones Rápidas -->
        <div class="mb-6 flex justify-end space-x-3">
            <a href="{{ route('clients.edit', $client) }}" 
               class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Editar Cliente
            </a>
            
            <form action="{{ route('clients.destroy', $client) }}" method="POST" class="inline" 
                  onsubmit="return confirm('¿Está seguro que desea eliminar este cliente? Esta acción es irreversible.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Eliminar Cliente
                </button>
            </form>
        </div>

        <!-- Ficha del Cliente -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
            <div class="flex items-center p-6 border-b border-gray-200">
                <div class="flex-shrink-0 h-20 w-20 bg-blue-100 rounded-full flex items-center justify-center">
                    <span class="text-brand-blue font-bold text-2xl">
                        {{ substr($client->Name, 0, 1) }}{{ substr($client->LastName, 0, 1) }}
                    </span>
                </div>
                <div class="ml-6">
                    <h2 class="text-2xl font-bold text-gray-900">
                        {{ $client->Name }} {{ $client->LastName }}
                    </h2>
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                        {{ $client->clientType->ClientType ?? 'Sin tipo asignado' }}
                    </span>
                </div>
            </div>

            <div class="border-b border-gray-200">
                <div class="px-6 py-5 grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <h3 class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Información de Contacto</h3>
                        <dl>
                            <div class="py-2 flex justify-between">
                                <dt class="text-sm font-medium text-gray-500">Email:</dt>
                                <dd class="text-sm text-gray-900">{{ $client->Email }}</dd>
                            </div>
                            <div class="py-2 flex justify-between">
                                <dt class="text-sm font-medium text-gray-500">Teléfono:</dt>
                                <dd class="text-sm text-gray-900">{{ $client->Phone }}</dd>
                            </div>
                            <div class="py-2 flex justify-between">
                                <dt class="text-sm font-medium text-gray-500">Dirección:</dt>
                                <dd class="text-sm text-gray-900">{{ $client->Address ?: 'No especificada' }}</dd>
                            </div>
                        </dl>
                    </div>
                    <div>
                        <h3 class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Información Adicional</h3>
                        <dl>
                            <div class="py-2 flex justify-between">
                                <dt class="text-sm font-medium text-gray-500">ID Cliente:</dt>
                                <dd class="text-sm text-gray-900">#{{ $client->id }}</dd>
                            </div>
                            <div class="py-2 flex justify-between">
                                <dt class="text-sm font-medium text-gray-500">Fecha de Registro:</dt>
                                <dd class="text-sm text-gray-900">{{ $client->created_at ? $client->created_at->format('d/m/Y') : 'No disponible' }}</dd>
                            </div>
                            <div class="py-2 flex justify-between">
                                <dt class="text-sm font-medium text-gray-500">Última Actualización:</dt>
                                <dd class="text-sm text-gray-900">{{ $client->updated_at ? $client->updated_at->format('d/m/Y H:i') : 'No disponible' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Aquí podríamos agregar secciones adicionales como proyectos, facturas, etc. relacionados con el cliente -->
            <div class="px-6 py-5">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Historial de Proyectos</h3>
                <p class="text-sm text-gray-500">En esta sección se mostrarán los proyectos asociados a este cliente una vez que se implemente la funcionalidad.</p>
                
                <!-- Placeholder para proyectos futuros -->
                <div class="mt-4 bg-gray-50 rounded-lg p-4 text-center">
                    <p class="text-gray-500">No hay proyectos asociados actualmente</p>
                    <a href="#" class="mt-2 inline-flex items-center text-sm font-medium text-brand-blue hover:underline">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Crear Nuevo Proyecto
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection 