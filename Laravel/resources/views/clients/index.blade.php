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
            <div id="clientTypesPieChart" class="animate__animated animate__fadeIn"></div>
        </div>
    </div>
</div>


<div class="flex flex-col items-center mb-10 mt-12">
    <h2 class="text-2xl font-bold text-gray-700 mb-2 flex items-center gap-2">
  
    </h2>
</div>

<div class="rounded-xl shadow-lg p-8 w-full max-w-4xl mx-auto border border-gray-200 bg-white hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 mt-8">
    <div class="flex flex-col items-center">
        <h3 class="text-xl font-semibold text-blue-700 mb-6 text-center">Distribución por ubicación</h3>
        <div class="w-full max-w-2xl">
            <div id="clientsByAddressChart" class="animate__animated animate__fadeIn"></div>
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
<script>
    // Delete confirmation
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            if (confirm('¿Estás seguro que deseas eliminar este cliente? Esta acción no se puede deshacer.')) {
                this.submit();
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        // Manejo del modal de tipo de cliente
        const newClientTypeBtn = document.getElementById('new-client-type-btn');
        const clientTypeModal = document.getElementById('clientTypeModal');
        const closeClientTypeModal = document.getElementById('closeClientTypeModal');
        const saveClientType = document.getElementById('saveClientType');
        const newClientTypeForm = document.getElementById('newClientTypeForm');
        const clientTypeError = document.getElementById('client-type-error');
        
        // Abrir modal de tipo de cliente
        if (newClientTypeBtn) {
            newClientTypeBtn.addEventListener('click', function() {
                clientTypeModal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            });
        }
        
        // Cerrar modal de tipo de cliente
        if (closeClientTypeModal) {
            closeClientTypeModal.addEventListener('click', function() {
                clientTypeModal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
                newClientTypeForm.reset();
                clientTypeError.classList.add('hidden');
                clientTypeError.textContent = '';
            });
        }
        
        // Cerrar modal de tipo de cliente haciendo clic fuera
        if (clientTypeModal) {
            clientTypeModal.addEventListener('click', function(e) {
                if (e.target === this.querySelector('.fixed.inset-0.bg-black.bg-opacity-50') || e.target === this) {
                    clientTypeModal.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                    newClientTypeForm.reset();
                    clientTypeError.classList.add('hidden');
                    clientTypeError.textContent = '';
                }
            });
        }
        
        // Eventos para tecla ESC para cerrar modal de tipo de cliente
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !clientTypeModal.classList.contains('hidden')) {
                clientTypeModal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
                newClientTypeForm.reset();
                clientTypeError.classList.add('hidden');
                clientTypeError.textContent = '';
            }
        });
        
        // Manejar eventos para el modal de detalles del cliente
        const clientDetailsModal = document.getElementById('clientDetailsModal');
        const closeClientModal = document.getElementById('closeClientModal');
        const closeModalButton = document.getElementById('closeModalButton');
        const viewClientButtons = document.querySelectorAll('.view-client-details');
        
        // Abrir modal de detalles del cliente
        if (viewClientButtons) {
            viewClientButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Obtener los datos del cliente del botón
                    const clientId = this.dataset.clientId;
                    const clientName = this.dataset.clientName;
                    const clientLastName = this.dataset.clientLastname;
                    const clientEmail = this.dataset.clientEmail;
                    const clientPhone = this.dataset.clientPhone;
                    const clientAddress = this.dataset.clientAddress;
                    const clientType = this.dataset.clientType;
                    const clientCreated = this.dataset.clientCreated;
                    const clientUpdated = this.dataset.clientUpdated;
                    
                    // Actualizar el modal con los datos del cliente
                    document.getElementById('clientInitials').textContent = 
                        (clientName ? clientName.charAt(0) : '') + 
                        (clientLastName ? clientLastName.charAt(0) : '');
                    document.getElementById('clientFullName').textContent = 
                        (clientName || '') + ' ' + (clientLastName || '');
                    document.getElementById('clientType').textContent = clientType;
                    document.getElementById('clientName').textContent = clientName || 'No disponible';
                    document.getElementById('clientLastName').textContent = clientLastName || 'No disponible';
                    document.getElementById('clientId').textContent = clientId;
                    
                    const emailElement = document.getElementById('clientEmail');
                    if (clientEmail) {
                        emailElement.textContent = clientEmail;
                        emailElement.href = `mailto:${clientEmail}`;
                    } else {
                        emailElement.textContent = 'No disponible';
                        emailElement.href = '#';
                    }
                    
                    document.getElementById('clientPhone').textContent = clientPhone || 'No disponible';
                    document.getElementById('clientAddress').textContent = clientAddress || 'No disponible';
                    document.getElementById('clientCreatedAt').textContent = clientCreated;
                    document.getElementById('clientUpdatedAt').textContent = clientUpdated;
                    
                    // Actualizar la URL para el botón de editar
                    document.getElementById('editClientLink').href = `/clientes/${clientId}/edit`;
                    
                    // Mostrar el modal
                    clientDetailsModal.classList.remove('hidden');
                    document.body.classList.add('overflow-hidden');
                });
            });
        }
        
        // Cerrar modal de detalles del cliente con botón X
        if (closeClientModal) {
            closeClientModal.addEventListener('click', function() {
                clientDetailsModal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            });
        }
        
        // Cerrar modal de detalles del cliente con botón Cerrar
        if (closeModalButton) {
            closeModalButton.addEventListener('click', function() {
                clientDetailsModal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            });
        }
        
        // Cerrar modal de detalles del cliente haciendo clic fuera
        if (clientDetailsModal) {
            clientDetailsModal.addEventListener('click', function(e) {
                if (e.target === this.querySelector('.fixed.inset-0.bg-black.bg-opacity-50') || e.target === this) {
                    clientDetailsModal.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                }
            });
        }
        
        // Eventos para tecla ESC para cerrar modal de detalles
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !clientDetailsModal.classList.contains('hidden')) {
                clientDetailsModal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        });
        
        // Modal de edición de cliente
        const clientEditModal = document.getElementById('clientEditModal');
        const closeEditModal = document.getElementById('closeEditModal');
        const cancelEditButton = document.getElementById('cancelEditButton');
        
        // Cerrar modal de edición con botón X
        if (closeEditModal) {
            closeEditModal.addEventListener('click', function() {
                clientEditModal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            });
        }
        
        // Cerrar modal de edición con botón Cancelar
        if (cancelEditButton) {
            cancelEditButton.addEventListener('click', function() {
                clientEditModal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            });
        }
        
        // Cerrar modal de edición haciendo clic fuera
        if (clientEditModal) {
            clientEditModal.addEventListener('click', function(e) {
                if (e.target === this.querySelector('.fixed.inset-0.bg-black.bg-opacity-50') || e.target === this) {
                    clientEditModal.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                }
            });
        }
        
        // Activar botones de confirmar eliminación
        const confirmDeleteButtons = document.querySelectorAll('.confirm-delete');
        if (confirmDeleteButtons) {
            confirmDeleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('.delete-form');
                    const clientName = form.dataset.clientName;
                    
                    if (confirm(`¿Estás seguro que deseas eliminar a ${clientName}? Esta acción no se puede deshacer.`)) {
                        form.submit();
                    }
                });
            });
        }
        
        // Guardar nuevo tipo de cliente
        if (saveClientType) {
            saveClientType.addEventListener('click', function() {
                const clientTypeName = document.getElementById('client_type_name').value.trim();
                const clientTypeDescription = document.getElementById('client_type_description').value.trim();
                
                if (!clientTypeName) {
                    clientTypeError.textContent = 'El nombre del tipo de cliente es obligatorio';
                    clientTypeError.classList.remove('hidden');
                    return;
                }
                
                // Desactivar el botón mientras se procesa
                saveClientType.disabled = true;
                saveClientType.classList.add('opacity-75', 'cursor-not-allowed');
                saveClientType.innerHTML = '<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Guardando...';
                
                // Enviar solicitud para guardar el nuevo tipo
                fetch('{{ route('api.clienttypes.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        ClientType: clientTypeName,
                        Description: clientTypeDescription
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Añadir el nuevo tipo al selector
                        const filterType = document.getElementById('filter-type');
                        if (filterType) {
                            const option = document.createElement('option');
                            option.value = data.idClientType;
                            option.textContent = clientTypeName;
                            filterType.appendChild(option);
                        }
                        
                        // Cerrar el modal y limpiar
                        clientTypeModal.classList.add('hidden');
                        document.body.classList.remove('overflow-hidden');
                        newClientTypeForm.reset();
                        
                        // Mostrar mensaje de éxito
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: 'Tipo de cliente creado correctamente',
                            confirmButtonColor: '#3085d6'
                        }).then(() => {
                            // Actualizar la página para reflejar los cambios
                            window.location.reload();
                        });
                    } else {
                        clientTypeError.textContent = data.message || 'Error al crear el tipo de cliente';
                        clientTypeError.classList.remove('hidden');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    clientTypeError.textContent = 'Error de conexión. Por favor, inténtalo de nuevo.';
                    clientTypeError.classList.remove('hidden');
                })
                .finally(() => {
                    // Restaurar el botón
                    saveClientType.disabled = false;
                    saveClientType.classList.remove('opacity-75', 'cursor-not-allowed');
                    saveClientType.innerHTML = 'Guardar';
                });
            });
        }

        // Datos para los gráficos
        const clientTypesLabels = {!! json_encode($clientTypeCounts->pluck('label')->toArray()) !!};
        const clientTypesCounts = {!! json_encode($clientTypeCounts->pluck('count')->toArray()) !!};
        const clientsByAddressLabels = {!! json_encode($clientsByAddress->pluck('address')->toArray()) !!};
        const clientsByAddressCounts = {!! json_encode($clientsByAddress->pluck('count')->toArray()) !!};

        console.log('Datos de tipos de cliente:', { labels: clientTypesLabels, counts: clientTypesCounts });
        console.log('Datos de clientes por dirección:', { labels: clientsByAddressLabels, counts: clientsByAddressCounts });

        // Verificar si hay datos para mostrar en los gráficos
        const clientTypeContainer = document.getElementById('clientTypesPieChart');
        const clientsByAddressContainer = document.getElementById('clientsByAddressChart');

        // Colores para los gráficos
        const colors = [
            '#3F95FF', '#10b981', '#8b5cf6', '#f59e0b', '#ef4444',
            '#06b6d4', '#ec4899', '#14b8a6', '#6366f1', '#f97316'
        ];

        // Gráfico de tipos de cliente
        if (clientTypeContainer && clientTypesLabels.length > 0) {
            const clientTypesOptions = {
                series: clientTypesCounts,
                chart: {
                    type: 'donut',
                    height: 350,
                    fontFamily: 'Poppins, sans-serif',
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 800,
                        animateGradually: {
                            enabled: true,
                            delay: 150
                        },
                        dynamicAnimation: {
                            enabled: true,
                            speed: 350
                        }
                    }
                },
                labels: clientTypesLabels,
                colors: colors.slice(0, clientTypesLabels.length),
                plotOptions: {
                    pie: {
                        donut: {
                            size: '60%',
                            labels: {
                                show: true,
                                name: {
                                    show: true,
                                    fontSize: '16px'
                                },
                                value: {
                                    show: true,
                                    fontSize: '20px'
                                },
                                total: {
                                    show: true,
                                    label: 'Total',
                                    fontSize: '16px'
                                }
                            }
                        }
                    }
                },
                dataLabels: {
                    enabled: false
                },
                legend: {
                    position: 'bottom',
                    fontSize: '14px',
                    fontFamily: 'Poppins, sans-serif',
                    markers: {
                        width: 12,
                        height: 12,
                        strokeWidth: 0,
                        radius: 12
                    },
                    itemMargin: {
                        horizontal: 8,
                        vertical: 5
                    }
                },
                tooltip: {
                    theme: 'dark'
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 300
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };

            const clientTypesPieChart = new ApexCharts(clientTypeContainer, clientTypesOptions);
            clientTypesPieChart.render();
        } else if (clientTypeContainer) {
            clientTypeContainer.innerHTML = '<div class="flex items-center justify-center h-full"><div class="text-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg><p class="mt-2 text-gray-500">No hay datos disponibles para mostrar</p></div></div>';
        }

        // Gráfico de clientes por dirección
        if (clientsByAddressContainer && clientsByAddressLabels.length > 0) {
            const clientsByAddressOptions = {
                series: [{
                    name: 'Clientes',
                    data: clientsByAddressCounts
                }],
                chart: {
                    type: 'bar',
                    height: 350,
                    fontFamily: 'Poppins, sans-serif',
                    toolbar: {
                        show: true
                    },
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 800,
                        dynamicAnimation: {
                            enabled: true,
                            speed: 350
                        }
                    }
                },
                colors: ['#3F95FF'],
                plotOptions: {
                    bar: {
                        borderRadius: 5,
                        columnWidth: '60%',
                        dataLabels: {
                            position: 'top'
                        }
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: function(val) {
                        return val;
                    },
                    offsetY: -20,
                    style: {
                        fontSize: '12px',
                        colors: ["#304758"]
                    }
                },
                xaxis: {
                    categories: clientsByAddressLabels,
                    labels: {
                        style: {
                            fontSize: '12px',
                            fontFamily: 'Poppins, sans-serif'
                        },
                        rotate: -45,
                        rotateAlways: false
                    }
                },
                yaxis: {
                    title: {
                        text: 'Número de clientes',
                        style: {
                            fontSize: '14px',
                            fontFamily: 'Poppins, sans-serif',
                            fontWeight: 600
                        }
                    }
                },
                tooltip: {
                    theme: 'dark'
                },
                grid: {
                    borderColor: '#e0e0e0',
                    strokeDashArray: 5,
                    yaxis: {
                        lines: {
                            show: true
                        }
                    }
                }
            };

            const clientsByAddressChart = new ApexCharts(clientsByAddressContainer, clientsByAddressOptions);
            clientsByAddressChart.render();
        } else if (clientsByAddressContainer) {
            clientsByAddressContainer.innerHTML = '<div class="flex items-center justify-center h-full"><div class="text-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg><p class="mt-2 text-gray-500">No hay datos disponibles para mostrar</p></div></div>';
        }
    });
</script>
@endsection 