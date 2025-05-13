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
                                    <a href="{{ route('clients.show', $client) }}" class="text-blue-600 hover:text-blue-900 transition-colors" title="Ver detalles">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
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
    });
</script>
@endsection 