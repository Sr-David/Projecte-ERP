@extends('layouts.app')

@section('title', 'Gestión de Leads')
@section('header', 'Gestión de Leads')
@section('breadcrumb', 'Leads')

@section('content')
    <!-- Banner -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 py-6 mb-8 rounded-xl shadow-lg border border-blue-700 animate__animated animate__fadeIn">
        <div class="container mx-auto px-6">
            <h2 class="text-2xl font-bold text-white mb-2 text-center">Gestión de Leads</h2>
            <p class="text-blue-100 text-center">Administra tus oportunidades de negocio</p>
        </div>
    </div>
    
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
                        <input type="text" id="search-leads" placeholder="Buscar lead..." 
                            class="w-full pl-10 pr-4 py-2 border rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Filtros -->
                <div class="flex flex-col sm:flex-row gap-3">
                    <!-- Filtro por estado -->
                    <div class="relative">
                        <select id="filter-status" 
                            class="bg-white border border-gray-300 rounded-lg text-gray-700 px-4 py-2 pr-8 text-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Todos los estados</option>
                            <option value="New">Nuevo</option>
                            <option value="Contacted">Contactado</option>
                            <option value="Qualified">Calificado</option>
                            <option value="Negotiation">En Negociación</option>
                            <option value="Lost">Perdido</option>
                            <option value="Converted">Convertido</option>
                        </select>
                    </div>
                    
                    <!-- Filtro por tipo -->
                    <div class="relative">
                        <select id="filter-type" 
                            class="bg-white border border-gray-300 rounded-lg text-gray-700 px-4 py-2 pr-12 text-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Todos los tipos</option>
                            @foreach(\App\Models\ClientType::all() as $type)
                                <option value="{{ $type->idClientType }}">{{ $type->ClientType }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Botón de añadir lead -->
                    <a href="{{ route('leads.create') }}" 
                        class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-brand-blue rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 shadow-sm transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Nuevo Lead
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Leads -->
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
                            Origen
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Estado
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($leads as $lead)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <span class="text-brand-blue font-medium text-sm">
                                            {{ substr($lead->Name, 0, 1) }}{{ substr($lead->LastName, 0, 1) }}
                                        </span>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $lead->Name }} {{ $lead->LastName }}
                                        </div>
                                        @if($lead->Address)
                                            <div class="text-xs text-gray-500">
                                                {{ Str::limit($lead->Address, 30) }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $lead->Email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $lead->Phone }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $lead->Source }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
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
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColor }}">
                                    {{ $statusLabel }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-3">
                                    <a href="{{ route('leads.show', $lead->idLead) }}" class="text-blue-600 hover:text-blue-900 transition-colors" title="Ver detalles">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('leads.edit', $lead->idLead) }}" class="text-indigo-600 hover:text-indigo-900 transition-colors" title="Editar">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    @if($lead->Status !== 'Converted')
                                        <form action="{{ route('leads.convert', $lead->idLead) }}" method="POST" class="inline convert-form" data-lead-name="{{ $lead->Name }} {{ $lead->LastName }}">
                                            @csrf
                                            <button type="button" class="text-green-600 hover:text-green-900 transition-colors confirm-convert" title="Convertir a Cliente">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                    <form action="{{ route('leads.destroy', $lead->idLead) }}" method="POST" class="inline delete-form" data-lead-name="{{ $lead->Name }} {{ $lead->LastName }}">
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
                            <td colspan="6" class="px-6 py-10 whitespace-nowrap text-sm text-gray-500 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="h-10 w-10 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                    <p class="text-gray-500 text-base mb-3">No hay leads registrados.</p>
                                    <a href="{{ route('leads.create') }}" class="text-brand-blue hover:text-blue-700 font-medium hover:underline">
                                        Registrar un nuevo lead
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal de confirmación para eliminar -->
    <div id="delete-modal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Confirmar Eliminación
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500" id="delete-message">
                                    ¿Estás seguro de que deseas eliminar este lead? Esta acción no se puede deshacer.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" id="confirm-delete-btn" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Eliminar
                    </button>
                    <button type="button" id="cancel-delete-btn" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de confirmación para convertir a cliente -->
    <div id="convert-modal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Confirmar Conversión
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500" id="convert-message">
                                    ¿Estás seguro de que deseas convertir este lead a cliente? Se creará un nuevo cliente con la información del lead.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" id="confirm-convert-btn" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Convertir
                    </button>
                    <button type="button" id="cancel-convert-btn" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Manejo de eliminación
            const deleteModal = document.getElementById('delete-modal');
            const deleteMessage = document.getElementById('delete-message');
            const confirmDeleteBtn = document.getElementById('confirm-delete-btn');
            const cancelDeleteBtn = document.getElementById('cancel-delete-btn');
            let currentDeleteForm = null;

            // Mostrar modal de eliminación
            document.querySelectorAll('.confirm-delete').forEach(button => {
                button.addEventListener('click', function() {
                    currentDeleteForm = this.closest('.delete-form');
                    const leadName = currentDeleteForm.getAttribute('data-lead-name');
                    deleteMessage.textContent = `¿Estás seguro de que deseas eliminar el lead "${leadName}"? Esta acción no se puede deshacer.`;
                    deleteModal.classList.remove('hidden');
                });
            });

            // Confirmar eliminación
            confirmDeleteBtn.addEventListener('click', function() {
                if (currentDeleteForm) {
                    currentDeleteForm.submit();
                }
                deleteModal.classList.add('hidden');
            });

            // Cancelar eliminación
            cancelDeleteBtn.addEventListener('click', function() {
                deleteModal.classList.add('hidden');
                currentDeleteForm = null;
            });

            // Manejo de conversión a cliente
            const convertModal = document.getElementById('convert-modal');
            const convertMessage = document.getElementById('convert-message');
            const confirmConvertBtn = document.getElementById('confirm-convert-btn');
            const cancelConvertBtn = document.getElementById('cancel-convert-btn');
            let currentConvertForm = null;

            // Mostrar modal de conversión
            document.querySelectorAll('.confirm-convert').forEach(button => {
                button.addEventListener('click', function() {
                    currentConvertForm = this.closest('.convert-form');
                    const leadName = currentConvertForm.getAttribute('data-lead-name');
                    convertMessage.textContent = `¿Estás seguro de que deseas convertir el lead "${leadName}" a cliente? Se creará un nuevo cliente con la información del lead.`;
                    convertModal.classList.remove('hidden');
                });
            });

            // Confirmar conversión
            confirmConvertBtn.addEventListener('click', function() {
                if (currentConvertForm) {
                    currentConvertForm.submit();
                }
                convertModal.classList.add('hidden');
            });

            // Cancelar conversión
            cancelConvertBtn.addEventListener('click', function() {
                convertModal.classList.add('hidden');
                currentConvertForm = null;
            });

            // Filtro de búsqueda
            const searchInput = document.getElementById('search-leads');
            const rows = document.querySelectorAll('tbody tr');

            searchInput.addEventListener('keyup', function() {
                const searchTerm = this.value.toLowerCase();
                
                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(searchTerm) ? '' : 'none';
                });
            });

            // Filtro por estado
            const statusFilter = document.getElementById('filter-status');
            statusFilter.addEventListener('change', function() {
                const selectedStatus = this.value.toLowerCase();
                
                rows.forEach(row => {
                    if (!selectedStatus) {
                        row.style.display = '';
                        return;
                    }
                    
                    const status = row.querySelector('td:nth-child(5) span').textContent.toLowerCase();
                    row.style.display = status.includes(selectedStatus) ? '' : 'none';
                });
            });

            // Filtro por tipo
            const typeFilter = document.getElementById('filter-type');
            typeFilter.addEventListener('change', function() {
                const selectedType = this.value;
                
                rows.forEach(row => {
                    if (!selectedType) {
                        row.style.display = '';
                        return;
                    }
                    
                    const typeSpan = row.querySelector('td:nth-child(4) span[data-type-id]');
                    if (!typeSpan) {
                        row.style.display = 'none';
                        return;
                    }
                    
                    const typeId = typeSpan.getAttribute('data-type-id');
                    row.style.display = typeId === selectedType ? '' : 'none';
                });
            });
        });
    </script>
    @endsection
@endsection 