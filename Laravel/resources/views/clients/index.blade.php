@extends('layouts.app')

@section('title', 'Gestión de Clientes')
@section('header', 'Gestión de Clientes')
@section('breadcrumb', 'Clientes')

@section('content')
    <!-- Mensajes de estado -->
    <!-- Los mensajes de estado ahora son manejados desde app.blade.php en un formato unificado -->

    <!-- Panel de control -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200 mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Panel de Control</h3>
        </div>
        
        <div class="p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <!-- Búsqueda -->
                <div class="w-full md:w-1/3">
                    <div class="relative">
                        <input type="text" id="search-clients" placeholder="Buscar cliente..." 
                            class="w-full pl-10 pr-4 py-2 border rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-3">
                    <!-- Filtro por tipo -->
                    <div class="relative">
                        <select id="filter-type" 
                            class="bg-white border border-gray-300 rounded-lg text-gray-700 px-4 py-2 pr-12 text-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Todos los tipos</option>
                            @foreach(\App\Models\ClientType::all() as $type)
                                <option value="{{ $type->idClientType }}">{{ $type->ClientType }}</option>
                            @endforeach
                        </select>
                        <button type="button" id="new-client-type-btn" 
                            class="absolute right-2 top-0 h-full px-2 text-gray-500 hover:text-blue-600 transition-colors"
                            title="Crear nuevo tipo">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Botón de añadir cliente -->
                    <a href="{{ route('clients.create') }}" 
                        class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-brand-blue rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 shadow-sm transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Nuevo Cliente
                    </a>
                </div>
            </div>
        </div>
    </div>



    <!-- Tabla de Clientes -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nombre
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Email
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Teléfono
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tipo
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($clients as $client)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <span class="text-brand-blue font-medium text-sm">
                                            {{ substr($client->Name, 0, 1) }}{{ substr($client->LastName, 0, 1) }}
                                        </span>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $client->Name }} {{ $client->LastName }}
                                        </div>
                                        @if($client->Address)
                                            <div class="text-xs text-gray-500">
                                                {{ Str::limit($client->Address, 30) }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $client->Email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $client->Phone }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if(isset($client->clientType) && $client->clientType)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800" data-type-id="{{ $client->ClientTypeID }}">
                                        {{ $client->clientType->ClientType }}
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Sin asignar
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-3">
                                    <button 
                                        type="button" 
                                        class="text-blue-600 hover:text-blue-900 transition-colors view-client-details" 
                                        title="Ver detalles"
                                        data-client-id="{{ $client->idClient }}"
                                        data-client-name="{{ $client->Name }}"
                                        data-client-lastname="{{ $client->LastName ?? '' }}"
                                        data-client-email="{{ $client->Email ?? '' }}"
                                        data-client-phone="{{ $client->Phone ?? '' }}"
                                        data-client-address="{{ $client->Address ?? '' }}"
                                        data-client-type="{{ isset($client->clientType) && $client->clientType ? $client->clientType->ClientType : 'Sin asignar' }}"
                                        data-client-type-id="{{ $client->ClientTypeID ?? '' }}"
                                        data-client-created="{{ isset($client->CreatedAt) && $client->CreatedAt ? date('d/m/Y', strtotime($client->CreatedAt)) : 'No disponible' }}"
                                        data-client-updated="{{ isset($client->UpdatedAt) && $client->UpdatedAt ? date('d/m/Y H:i', strtotime($client->UpdatedAt)) : 'No disponible' }}"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                    <a href="{{ route('clients.edit', $client) }}" class="text-indigo-600 hover:text-indigo-900 transition-colors" title="Editar">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('clients.destroy', $client) }}" method="POST" class="inline delete-form" data-client-name="{{ $client->Name }} {{ $client->LastName }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="text-red-600 hover:text-red-900 transition-colors confirm-delete" title="Eliminar">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 whitespace-nowrap text-sm text-gray-500 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="h-10 w-10 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                    <p class="text-gray-500 text-base mb-3">No hay clientes registrados.</p>
                                    <a href="{{ route('clients.create') }}" class="text-brand-blue hover:text-blue-700 font-medium hover:underline">
                                        Registrar un nuevo cliente
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

<div class="flex flex-col items-center mb-10">
    <h2 class="text-2xl font-bold text-gray-700 mb-2 flex items-center gap-2">
        Análisis de Tipos de Cliente
    </h2>
</div>

<div class="rounded-xl shadow-lg p-8 w-full max-w-4xl mx-auto border border-gray-200 bg-white hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
    <div class="flex flex-col items-center">
        <h3 class="text-xl font-semibold text-blue-700 mb-6 text-center">Distribución por tipo de cliente</h3>
        <div class="w-full max-w-2xl">
            <canvas id="clientTypesPieChart" class="animate__animated animate__fadeIn"></canvas>
        </div>
    </div>
</div>



    <!-- Modal de Detalles del Cliente -->
    <div id="clientDetailsModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity backdrop-blur-sm"></div>
        
        <div class="flex items-center justify-center min-h-screen p-2 sm:p-4">
            <div class="bg-white rounded-lg shadow-2xl w-full max-w-4xl mx-auto overflow-hidden relative z-10">
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-4 sm:p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-12 h-12 sm:w-16 sm:h-16 rounded-full bg-white flex items-center justify-center flex-shrink-0 shadow-md">
                                <span id="clientInitials" class="text-blue-700 text-xl sm:text-2xl font-bold"></span>
                            </div>
                            <div class="ml-3 sm:ml-4 text-white">
                                <h2 id="clientFullName" class="text-xl sm:text-2xl font-bold"></h2>
                                <div class="flex items-center">
                                    <span id="clientType" class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-white text-blue-800 mt-1"></span>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="closeClientModal" class="text-white hover:text-gray-200 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <!-- Modal Content -->
                <div class="p-4 sm:p-6 overflow-y-auto max-h-[70vh]">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                        <!-- Información Personal -->
                        <div class="bg-gray-50 rounded-lg p-4 sm:p-5 shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                            <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Información Personal
                            </h3>
                            <div class="space-y-3">
                                <div class="flex items-center">
                                    <span class="w-24 text-sm font-medium text-gray-500">Nombre:</span>
                                    <span id="clientName" class="text-gray-900 font-medium"></span>
                                </div>
                                <div class="flex items-center">
                                    <span class="w-24 text-sm font-medium text-gray-500">Apellido:</span>
                                    <span id="clientLastName" class="text-gray-900 font-medium"></span>
                                </div>
                                <div class="flex items-center">
                                    <span class="w-24 text-sm font-medium text-gray-500">ID Cliente:</span>
                                    <span id="clientId" class="text-gray-900 font-mono bg-gray-100 px-2 py-1 rounded text-sm"></span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Información de Contacto -->
                        <div class="bg-gray-50 rounded-lg p-4 sm:p-5 shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                            <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                Información de Contacto
                            </h3>
                            <div class="space-y-3">
                                <div class="flex items-center">
                                    <span class="w-24 text-sm font-medium text-gray-500">Email:</span>
                                    <a id="clientEmail" href="#" class="text-blue-600 hover:underline break-all"></a>
                                </div>
                                <div class="flex items-center">
                                    <span class="w-24 text-sm font-medium text-gray-500">Teléfono:</span>
                                    <span id="clientPhone" class="text-gray-900 font-medium"></span>
                                </div>
                                <div class="flex items-start">
                                    <span class="w-24 text-sm font-medium text-gray-500">Dirección:</span>
                                    <span id="clientAddress" class="text-gray-900 break-words"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Timeline y Fechas -->
                    <div class="mt-4 sm:mt-6 bg-gray-50 rounded-lg p-4 sm:p-5 shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Historial
                        </h3>
                        <div class="space-y-2">
                            <div class="flex items-center border-l-4 border-green-500 pl-3 py-1">
                                <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-sm text-gray-500">Fecha de registro:</span>
                                <span id="clientCreatedAt" class="ml-2 text-sm font-medium"></span>
                            </div>
                            <div class="flex items-center border-l-4 border-blue-500 pl-3 py-1">
                                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                <span class="text-sm text-gray-500">Última actualización:</span>
                                <span id="clientUpdatedAt" class="ml-2 text-sm font-medium"></span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Proyectos (Placeholder para futura implementación) -->
                    <div class="mt-4 sm:mt-6 bg-gray-50 rounded-lg p-4 sm:p-5 shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Proyectos
                        </h3>
                        <div class="text-center py-6 sm:py-8 bg-gray-100 rounded-lg">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No hay proyectos</h3>
                            <p class="mt-1 text-sm text-gray-500">En esta sección se mostrarán los proyectos asociados a este cliente.</p>
                            <div class="mt-3">
                                <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Crear Proyecto
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer with Actions -->
                <div class="bg-gray-50 px-4 sm:px-6 py-3 sm:py-4 flex justify-end space-x-3 border-t border-gray-200 sticky bottom-0">
                    <a id="editClientLink" href="#" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Editar Cliente
                    </a>
                    <button type="button" id="closeModalButton" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Edición del Cliente -->
    <div id="clientEditModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity backdrop-blur-sm"></div>
        
        <div class="flex items-center justify-center min-h-screen p-2 sm:p-4">
            <div class="bg-white rounded-lg shadow-2xl w-full max-w-2xl mx-auto overflow-hidden relative z-10">
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-indigo-600 to-purple-700 p-4 sm:p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-12 h-12 rounded-full bg-white flex items-center justify-center flex-shrink-0 shadow-md">
                                <span id="editClientInitials" class="text-indigo-700 text-xl font-bold"></span>
                            </div>
                            <div class="ml-3 sm:ml-4 text-white">
                                <h2 class="text-xl sm:text-2xl font-bold">Editar Cliente</h2>
                                <p class="text-indigo-100 text-sm">Actualiza la información del cliente</p>
                            </div>
                        </div>
                        <button type="button" id="closeEditModal" class="text-white hover:text-gray-200 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <!-- Modal Content -->
                <div class="p-4 sm:p-6">
                    <form id="editClientForm" method="POST" action="">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="edit_client_id" name="idClient">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Nombre -->
                            <div>
                                <label for="edit_name" class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                                <input type="text" name="Name" id="edit_name" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                            </div>
                            
                            <!-- Apellido -->
                            <div>
                                <label for="edit_lastname" class="block text-sm font-medium text-gray-700 mb-1">Apellido</label>
                                <input type="text" name="LastName" id="edit_lastname" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                            </div>
                            
                            <!-- Email -->
                            <div>
                                <label for="edit_email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" name="Email" id="edit_email" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                            </div>
                            
                            <!-- Teléfono -->
                            <div>
                                <label for="edit_phone" class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                                <input type="text" name="Phone" id="edit_phone" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                            </div>
                            
                            <!-- Tipo de Cliente -->
                            <div class="md:col-span-2">
                                <label for="edit_client_type" class="block text-sm font-medium text-gray-700 mb-1">Tipo de Cliente</label>
                                <select name="clientTypeId" id="edit_client_type" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                    @foreach(\App\Models\ClientType::all() as $type)
                                        <option value="{{ $type->idClientType }}">{{ $type->ClientType }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- Dirección -->
                            <div class="md:col-span-2">
                                <label for="edit_address" class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
                                <textarea name="Address" id="edit_address" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                            </div>
                        </div>
                        
                        <div class="mt-6 flex justify-end space-x-3">
                            <button type="button" id="cancelEditButton" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                Cancelar
                            </button>
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para crear nuevo tipo de cliente -->
    <div id="clientTypeModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full relative z-10">
                <!-- Modal Header -->
                <div class="bg-blue-600 text-white px-6 py-4 rounded-t-lg">
                    <h3 class="text-lg font-medium leading-6">Crear nuevo tipo de cliente</h3>
                </div>
                <!-- Modal Body -->
                <div class="px-6 py-4">
                    <form id="newClientTypeForm">
                        <div class="mb-4">
                            <label for="client_type_name" class="block text-sm font-medium text-gray-700 mb-1">Nombre del tipo *</label>
                            <input type="text" id="client_type_name" name="ClientType" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                        </div>
                        <div class="mb-4">
                            <label for="client_type_description" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                            <textarea id="client_type_description" name="Description" rows="3" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"></textarea>
                        </div>
                        <div id="client-type-error" class="text-red-600 text-sm mb-4 hidden"></div>
                    </form>
                </div>
                <!-- Modal Footer -->
                <div class="bg-gray-50 px-6 py-3 flex justify-end space-x-2 rounded-b-lg border-t">
                    <button id="closeClientTypeModal" type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancelar
                    </button>
                    <button id="saveClientType" type="button" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Filtro de búsqueda en tiempo real
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search-clients');
        const typeFilter = document.getElementById('filter-type');
        const tableRows = document.querySelectorAll('tbody tr');
        
        // Función auxiliar para manejar nombres y apellidos
        function fixNameCase(str) {
            if (!str) return '';
            return str.charAt(0).toUpperCase() + str.slice(1).toLowerCase();
        }
        
        // Función para filtrar la tabla
        function filterTable() {
            const searchValue = searchInput.value.toLowerCase();
            const typeValue = typeFilter.value;
            
            tableRows.forEach(row => {
                const name = row.querySelector('td:first-child').textContent.toLowerCase();
                const type = row.querySelector('td:nth-child(4)').textContent.trim();
                const typeId = row.querySelector('td:nth-child(4) span').getAttribute('data-type-id') || '';
                
                const matchesSearch = name.includes(searchValue);
                const matchesType = !typeValue || typeId === typeValue;
                
                if (matchesSearch && matchesType) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
        
        // Eventos para filtrado
        if (searchInput) {
            searchInput.addEventListener('input', filterTable);
        }
        
        if (typeFilter) {
            typeFilter.addEventListener('change', filterTable);
        }
        
        // Confirmación para eliminar
        const deleteButtons = document.querySelectorAll('.confirm-delete');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('.delete-form');
                const clientName = form.getAttribute('data-client-name');
                
                // Añadir más información en la consola para verificar
                console.log('Intentando eliminar cliente:', {
                    name: clientName,
                    action: form.action
                });
                
                if (confirm(`¿Está seguro que desea eliminar el cliente "${clientName}"? Esta acción no se puede deshacer.`)) {
                    form.submit();
                }
            });
        });

        // Funcionalidad del modal de detalles del cliente
        const detailsModal = document.getElementById('clientDetailsModal');
        const editModal = document.getElementById('clientEditModal');
        const viewButtons = document.querySelectorAll('.view-client-details');
        const closeDetailButtons = document.querySelectorAll('#closeClientModal, #closeModalButton');
        const closeEditButtons = document.querySelectorAll('#closeEditModal, #cancelEditButton');
        const editButtons = document.querySelectorAll('.edit-client'); // Botones de editar en la tabla
        
        // Funciones para mostrar y ocultar los modales
        function showDetailsModal() {
            detailsModal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }
        
        function hideDetailsModal() {
            detailsModal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
        
        function showEditModal() {
            editModal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }
        
        function hideEditModal() {
            editModal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
        
        // Event listeners para los botones de ver detalles
        viewButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Marcar este botón como activo y quitar la marca de los demás
                document.querySelectorAll('.view-client-details').forEach(btn => {
                    btn.removeAttribute('data-active');
                });
                this.setAttribute('data-active', 'true');
                
                const clientId = this.getAttribute('data-client-id');
                const name = this.getAttribute('data-client-name');
                const lastName = this.getAttribute('data-client-lastname');
                const email = this.getAttribute('data-client-email');
                const phone = this.getAttribute('data-client-phone');
                const address = this.getAttribute('data-client-address') || 'No especificada';
                const type = this.getAttribute('data-client-type');
                const typeId = this.getAttribute('data-client-type-id');
                const createdAt = this.getAttribute('data-client-created');
                const updatedAt = this.getAttribute('data-client-updated');
                
                // Debug - Mostrar los datos extraídos del botón
                console.log('Datos del botón de detalles:', {
                    id: clientId,
                    nombre: name,
                    apellido: lastName,
                    email: email,
                    teléfono: phone,
                    dirección: address,
                    tipo: type,
                    tipoId: typeId,
                    creado: createdAt,
                    actualizado: updatedAt
                });
                
                // Guardar el nombre completo original para usarlo después
                this.setAttribute('data-client-fullname', `${name} ${lastName}`);
                
                // Actualizar contenido del modal
                document.getElementById('clientInitials').textContent = name.charAt(0) + lastName.charAt(0);
                document.getElementById('clientFullName').textContent = name + ' ' + lastName;
                document.getElementById('clientType').textContent = type;
                document.getElementById('clientName').textContent = name;
                document.getElementById('clientLastName').textContent = lastName;
                document.getElementById('clientId').textContent = '#' + clientId;
                document.getElementById('clientEmail').textContent = email;
                document.getElementById('clientEmail').href = 'mailto:' + email;
                document.getElementById('clientPhone').textContent = phone;
                document.getElementById('clientAddress').textContent = address;
                
                // Formatear y mostrar correctamente las fechas
                document.getElementById('clientCreatedAt').textContent = createdAt && createdAt !== 'No disponible' 
                    ? createdAt 
                    : 'No disponible';
                    
                document.getElementById('clientUpdatedAt').textContent = updatedAt && updatedAt !== 'No disponible' 
                    ? updatedAt 
                    : 'No disponible';
                
                // Guardar los datos originales en atributos data para usarlos posteriormente
                document.getElementById('clientFullName').setAttribute('data-original-name', name);
                document.getElementById('clientFullName').setAttribute('data-original-lastname', lastName);
                document.getElementById('clientType').setAttribute('data-original-type-id', typeId);
                
                // Actualizar enlace de edición
                document.getElementById('editClientLink').href = '/clientes/' + clientId + '/edit';
                
                showDetailsModal();
            });
        });
        
        // Event listener para el botón "Editar Cliente" en el modal de detalles
        document.getElementById('editClientLink').addEventListener('click', function(e) {
            e.preventDefault();
            
            try {
                // Obtener el botón activo que abrió el modal
                const activeButton = document.querySelector('.view-client-details[data-active="true"]');
                
                if (!activeButton) {
                    console.error('Error crítico: No se encontró el botón activo');
                    alert('Error al obtener datos del cliente. Por favor inténtelo de nuevo.');
                    return;
                }
                
                // Obtener datos DIRECTAMENTE de los atributos del botón sin ningún procesamiento
                const clientId = activeButton.getAttribute('data-client-id');
                const name = activeButton.getAttribute('data-client-name');
                const lastName = activeButton.getAttribute('data-client-lastname');
                
                // Usar console.error para asegurar visibilidad en la consola
                console.error('DATOS FINALES PARA EDITAR:', {
                    'ID Cliente': clientId,
                    'Nombre': name,
                    'Apellido': lastName
                });
                
                // ESTABLECER DIRECTAMENTE los valores en los campos del formulario
                const nameField = document.getElementById('edit_name');
                const lastNameField = document.getElementById('edit_lastname');
                const emailField = document.getElementById('edit_email');
                const phoneField = document.getElementById('edit_phone');
                const addressField = document.getElementById('edit_address');
                
                nameField.value = name || '';
                lastNameField.value = lastName || '';
                emailField.value = activeButton.getAttribute('data-client-email') || '';
                phoneField.value = activeButton.getAttribute('data-client-phone') || '';
                
                const address = activeButton.getAttribute('data-client-address');
                addressField.value = (address && address !== 'No especificada') ? address : '';
                
                // Seleccionar tipo de cliente
                const typeId = activeButton.getAttribute('data-client-type-id');
                document.querySelectorAll('#edit_client_type option').forEach(option => {
                    option.selected = option.value === typeId;
                });
                
                // Establecer URL del formulario
                const clientUrl = `/clientes/${clientId}`;
                document.getElementById('editClientForm').action = clientUrl;
                
                // Iniciales para mostrar (solo visual)
                document.getElementById('editClientInitials').textContent = (name?.charAt(0) || '') + (lastName?.charAt(0) || '');
                
                // Cambiar entre modales
                hideDetailsModal();
                showEditModal();
                
                // Verificación final
                setTimeout(() => {
                    console.log('VERIFICACIÓN FINAL - Valores de los campos:');
                    console.log('Nombre field value:', nameField.value);
                    console.log('Apellido field value:', lastNameField.value);
                }, 100);
                
            } catch (error) {
                console.error('Error crítico en la edición:', error);
                // Mostrar error usando la función de alerta personalizada si está disponible
                if (typeof showAlert === 'function') {
                    showAlert('Ha ocurrido un error al preparar el formulario de edición. Por favor inténtelo nuevamente.', 'error');
                } else {
                    alert('Ha ocurrido un error al preparar el formulario de edición. Por favor inténtelo nuevamente.');
                }
            }
        });
        
        // Event listeners para los botones de editar en la tabla
        document.querySelectorAll('a[href*="/clientes/"][href$="/edit"]').forEach(button => {
            button.addEventListener('click', function(e) {
                console.log('Botón de editar en tabla clickeado', this);
                e.preventDefault();
                
                try {
                    const clientRow = this.closest('tr');
                    const clientUrl = this.getAttribute('href');
                    const clientId = clientUrl.substring(clientUrl.lastIndexOf('/') + 1).replace('/edit', '');
                    
                    // Encontrar el botón de detalles relacionado para obtener sus datos
                    const detailsButton = clientRow.querySelector('.view-client-details');
                    
                    if (!detailsButton) {
                        console.error('No se pudo encontrar el botón de detalles relacionado');
                        
                        // Intentar extraer datos directamente de la fila como respaldo
                        const nameCell = clientRow.querySelector('td:first-child');
                        const emailCell = clientRow.querySelector('td:nth-child(2)');
                        const phoneCell = clientRow.querySelector('td:nth-child(3)');
                        const typeCell = clientRow.querySelector('td:nth-child(4)');
                        
                        if (!nameCell) {
                            throw new Error('No se pudieron encontrar las celdas necesarias');
                        }
                        
                        // Extraer datos de las celdas
                        const nameElement = nameCell.querySelector('.text-sm.font-medium');
                        const fullName = nameElement ? nameElement.textContent.trim() : '';
                        const nameParts = fullName.split(' ');
                        const name = nameParts[0] || '';
                        const lastName = nameParts.slice(1).join(' ') || '';
                        const email = emailCell ? emailCell.textContent.trim() : '';
                        const phone = phoneCell ? phoneCell.textContent.trim() : '';
                        const typeElement = typeCell ? typeCell.querySelector('span') : null;
                        const type = typeElement ? typeElement.textContent.trim() : '';
                        const typeId = typeElement ? typeElement.getAttribute('data-type-id') : '';
                        
                        // Rellenar el formulario con los datos extraídos
                        document.getElementById('edit_name').value = name;
                        document.getElementById('edit_lastname').value = lastName;
                        document.getElementById('edit_email').value = email;
                        document.getElementById('edit_phone').value = phone;
                        
                        // Seleccionar tipo de cliente si está disponible
                        if (typeId) {
                            document.querySelectorAll('#edit_client_type option').forEach(option => {
                                option.selected = option.value === typeId;
                            });
                        }
                    } else {
                        // Extraer datos del botón de detalles (más confiable)
                        const name = detailsButton.getAttribute('data-client-name');
                        const lastName = detailsButton.getAttribute('data-client-lastname');
                        const email = detailsButton.getAttribute('data-client-email');
                        const phone = detailsButton.getAttribute('data-client-phone');
                        const address = detailsButton.getAttribute('data-client-address');
                        const typeId = detailsButton.getAttribute('data-client-type-id');
                        
                        // Rellenar el formulario
                        document.getElementById('edit_name').value = name || '';
                        document.getElementById('edit_lastname').value = lastName || '';
                        document.getElementById('edit_email').value = email || '';
                        document.getElementById('edit_phone').value = phone || '';
                        document.getElementById('edit_address').value = address !== 'No especificada' ? address || '' : '';
                        
                        // Seleccionar tipo de cliente
                        document.querySelectorAll('#edit_client_type option').forEach(option => {
                            option.selected = option.value === typeId;
                        });
                        
                        // Iniciales para mostrar
                        document.getElementById('editClientInitials').textContent = (name?.charAt(0) || '') + (lastName?.charAt(0) || '');
                    }
                    
                    // Establecer URL del formulario
                    document.getElementById('editClientForm').action = clientUrl.replace('/edit', '');
                    
                    // Verificación
                    console.log('Editando desde tabla, valores finales:', {
                        nombre: document.getElementById('edit_name').value,
                        apellido: document.getElementById('edit_lastname').value
                    });
                    
                    // Mostrar el modal de edición
                    showEditModal();
                    
                } catch (error) {
                    console.error('Error al editar desde tabla:', error);
                    alert('Ha ocurrido un error al preparar el formulario de edición. Por favor inténtelo nuevamente.');
                }
            });
        });
        
        // Event listeners para cerrar el modal de detalles
        closeDetailButtons.forEach(button => {
            button.addEventListener('click', hideDetailsModal);
        });
        
        // Event listeners para cerrar el modal de edición
        closeEditButtons.forEach(button => {
            button.addEventListener('click', hideEditModal);
        });
        
        // Cerrar modal al hacer clic fuera de él
        window.addEventListener('click', function(event) {
            if (event.target === detailsModal.querySelector('.fixed.inset-0.bg-black.bg-opacity-50')) {
                hideDetailsModal();
            }
            
            if (event.target === editModal.querySelector('.fixed.inset-0.bg-black.bg-opacity-50')) {
                hideEditModal();
            }
        });
        
        // Cerrar modal con la tecla ESC
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                if (!detailsModal.classList.contains('hidden')) {
                    hideDetailsModal();
                }
                
                if (!editModal.classList.contains('hidden')) {
                    hideEditModal();
                }
            }
        });

        // Modal para nuevo tipo de cliente
        const clientTypeModal = document.getElementById('clientTypeModal');
        const newClientTypeBtn = document.getElementById('new-client-type-btn');
        const closeClientTypeModal = document.getElementById('closeClientTypeModal');
        const saveClientType = document.getElementById('saveClientType');

        function showClientTypeModal() {
            clientTypeModal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
            
            // Asegurar que el formulario esté limpio
            document.getElementById('client_type_name').value = '';
            document.getElementById('client_type_description').value = '';
            document.getElementById('client-type-error').classList.add('hidden');
            
            // Dar foco al input principal
            setTimeout(() => {
                document.getElementById('client_type_name').focus();
            }, 100);
        }

        function hideClientTypeModal() {
            clientTypeModal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        newClientTypeBtn.addEventListener('click', showClientTypeModal);
        closeClientTypeModal.addEventListener('click', hideClientTypeModal);

        saveClientType.addEventListener('click', function() {
            const name = document.getElementById('client_type_name').value.trim();
            const description = document.getElementById('client_type_description').value.trim();
            const errorElement = document.getElementById('client-type-error');
            
            if (!name) {
                showAlert('El nombre del tipo es obligatorio.', 'error');
                return;
            }

            // Enviar petición AJAX para crear el tipo
            fetch('/api/client-types', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    ClientType: name,
                    Description: description,
                    idEmpresa: {{ session('empresa_id') }} // Usar el ID de empresa de la sesión
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Añadir el nuevo tipo al select
                    const filterSelect = document.getElementById('filter-type');
                    const editClientTypeSelect = document.getElementById('edit_client_type');
                    
                    const newOption = document.createElement('option');
                    newOption.value = data.clientType.idClientType;
                    newOption.textContent = data.clientType.ClientType;
                    
                    filterSelect.appendChild(newOption);
                    
                    if (editClientTypeSelect) {
                        const editOption = newOption.cloneNode(true);
                        editClientTypeSelect.appendChild(editOption);
                    }
                    
                    hideClientTypeModal();
                    
                    // Mostrar mensaje de éxito con la alerta personalizada
                    showAlert('Tipo de cliente creado correctamente!');
                } else {
                    // Mostrar mensajes de error con la alerta personalizada
                    if (data.errors) {
                        const errorMessages = Object.values(data.errors).flat().join('. ');
                        showAlert(`${data.message || 'Datos inválidos'}: ${errorMessages}`, 'error');
                    } else {
                        showAlert(data.message || 'Error al crear el tipo de cliente.', 'error');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Error al procesar la solicitud.', 'error');
            });
        });
        
        // Función para mostrar alertas con un estilo consistente
        function showAlert(message, type = 'success') {
            const alertClass = type === 'success' ? 'app-alert-success' : 
                               type === 'warning' ? 'app-alert-warning' : 
                               type === 'info' ? 'app-alert-info' : 'app-alert-error';
            
            const iconPath = type === 'success' ? 
                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />' : 
                type === 'info' ?
                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />' :
                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />';
            
            // Crear un contenedor para la alerta si no existe
            let alertContainer = document.getElementById('custom-alert-container');
            if (!alertContainer) {
                alertContainer = document.createElement('div');
                alertContainer.id = 'custom-alert-container';
                alertContainer.style.position = 'fixed';
                alertContainer.style.top = '1rem';
                alertContainer.style.right = '1rem';
                alertContainer.style.zIndex = '9999';
                alertContainer.style.maxWidth = '24rem';
                document.body.appendChild(alertContainer);
            }
            
            // Crear la alerta
            const alertElement = document.createElement('div');
            alertElement.className = `app-alert ${alertClass} shadow-lg mb-3 transform transition-all duration-300 ease-in-out`;
            alertElement.style.opacity = '0';
            alertElement.style.transform = 'translateX(1rem)';
            alertElement.innerHTML = `
                <svg class="app-alert-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    ${iconPath}
                </svg>
                <span>${message}</span>
            `;
            
            // Añadir la alerta al contenedor
            alertContainer.appendChild(alertElement);
            
            // Animación de entrada
            setTimeout(() => {
                alertElement.style.opacity = '1';
                alertElement.style.transform = 'translateX(0)';
            }, 10);
            
            // Ocultar después de 5 segundos
            setTimeout(() => {
                alertElement.style.opacity = '0';
                alertElement.style.transform = 'translateX(1rem)';
                
                // Eliminar el elemento después de la animación
                setTimeout(() => {
                    alertContainer.removeChild(alertElement);
                    
                    // Eliminar el contenedor si no tiene más alertas
                    if (alertContainer.childNodes.length === 0) {
                        document.body.removeChild(alertContainer);
                    }
                }, 300);
            }, 5000);
        }
    });



document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('clientTypesPieChart').getContext('2d');
    const data = {
        labels: {!! json_encode($clientTypeCounts->pluck('label')->toArray()) !!},
        datasets: [{
            data: {!! json_encode($clientTypeCounts->pluck('count')->toArray()) !!},
            backgroundColor: [
                '#3F95FF', '#6366F1', '#16BA81', '#F59E42', '#F43F5E', '#A855F7', '#FACC15', '#10B981'
            ],
            borderColor: '#fff',
            borderWidth: 3,
            hoverOffset: 15,
            borderRadius: 5
        }]
    };
  new Chart(ctx, {
        type: 'doughnut',
        data: data,
        options: {
            responsive: true,
            maintainAspectRatio: true,
            cutout: '65%',
            layout: {
                padding: 20
            },
            animation: {
                animateScale: true,
                animateRotate: true,
                duration: 2000,
                easing: 'easeOutQuart'
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        generateLabels: function(chart) {
                            const data = chart.data;
                            if (data.labels.length && data.datasets.length) {
                                return data.labels.map((label, i) => {
                                    const value = data.datasets[0].data[i];
                                    return {
                                        text: `${label} (${value})`,
                                        fillStyle: data.datasets[0].backgroundColor[i],
                                        strokeStyle: data.datasets[0].borderColor,
                                        lineWidth: data.datasets[0].borderWidth,
                                        hidden: isNaN(data.datasets[0].data[i]) || chart.getDataVisibility(i) === false,
                                        index: i
                                    };
                                });
                            }
                            return [];
                        },
                        padding: 20,
                        font: {
                            size: 12,
                            weight: 'bold'
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    bodyFont: {
                        size: 14
                    },
                    padding: 15,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.raw;
                            const total = context.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                            const percentage = Math.round((value / total) * 100);
                            return `${label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
});

</script>
@endsection 