@extends('layouts.app')

@section('title', 'Gestión de Clientes')
@section('header', 'Gestión de Clientes')
@section('breadcrumb', 'Clientes')

@section('content')
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
                    <div>
                        <select id="filter-type" 
                            class="bg-white border border-gray-300 rounded-lg text-gray-700 px-4 py-2 pr-8 text-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Todos los tipos</option>
                            @foreach(\App\Models\ClientType::all() as $type)
                                <option value="{{ $type->id }}">{{ $type->ClientType }}</option>
                            @endforeach
                        </select>
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
                                @if($client->clientType)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800" data-type-id="{{ $client->ClientType_ID }}">
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
                                        data-client-id="{{ $client->id }}"
                                        data-client-name="{{ $client->Name }}"
                                        data-client-lastname="{{ $client->LastName }}"
                                        data-client-email="{{ $client->Email }}"
                                        data-client-phone="{{ $client->Phone }}"
                                        data-client-address="{{ $client->Address }}"
                                        data-client-type="{{ $client->clientType->ClientType ?? 'Sin asignar' }}"
                                        data-client-created="{{ $client->created_at ? $client->created_at->format('d/m/Y') : 'No disponible' }}"
                                        data-client-updated="{{ $client->updated_at ? $client->updated_at->format('d/m/Y H:i') : 'No disponible' }}"
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
@endsection

@section('scripts')
<script>
    // Filtro de búsqueda en tiempo real
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search-clients');
        const typeFilter = document.getElementById('filter-type');
        const tableRows = document.querySelectorAll('tbody tr');
        
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
                
                if (confirm(`¿Está seguro que desea eliminar el cliente "${clientName}"?`)) {
                    form.submit();
                }
            });
        });

        // Funcionalidad del modal de detalles del cliente
        const modal = document.getElementById('clientDetailsModal');
        const viewButtons = document.querySelectorAll('.view-client-details');
        const closeButtons = document.querySelectorAll('#closeClientModal, #closeModalButton');
        
        // Funciones para mostrar y ocultar el modal
        function showModal() {
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }
        
        function hideModal() {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
        
        // Event listeners para los botones de ver detalles
        viewButtons.forEach(button => {
            button.addEventListener('click', function() {
                const clientId = this.getAttribute('data-client-id');
                const name = this.getAttribute('data-client-name');
                const lastName = this.getAttribute('data-client-lastname');
                const email = this.getAttribute('data-client-email');
                const phone = this.getAttribute('data-client-phone');
                const address = this.getAttribute('data-client-address') || 'No especificada';
                const type = this.getAttribute('data-client-type');
                const createdAt = this.getAttribute('data-client-created');
                const updatedAt = this.getAttribute('data-client-updated');
                
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
                document.getElementById('clientCreatedAt').textContent = createdAt;
                document.getElementById('clientUpdatedAt').textContent = updatedAt;
                
                // Actualizar enlace de edición
                document.getElementById('editClientLink').href = `/clientes/${clientId}/edit`;
                
                showModal();
            });
        });
        
        // Event listeners para cerrar el modal
        closeButtons.forEach(button => {
            button.addEventListener('click', hideModal);
        });
        
        // Cerrar modal al hacer clic fuera de él
        window.addEventListener('click', function(event) {
            if (event.target === modal.querySelector('.fixed.inset-0.bg-black.bg-opacity-50')) {
                hideModal();
            }
        });
        
        // Cerrar modal con la tecla ESC
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
                hideModal();
            }
        });
    });
</script>
@endsection 