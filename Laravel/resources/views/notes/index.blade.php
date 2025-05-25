@extends('layouts.app')

@section('title', 'Gestión de Notas')
@section('header', 'Gestión de Notas')
@section('breadcrumb', 'Notas')

@section('content')
    <!-- Banner -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 py-6 mb-8 rounded-xl shadow-lg border border-blue-700 animate__animated animate__fadeIn">
        <div class="container mx-auto px-6">
            <h2 class="text-2xl font-bold text-white mb-2 text-center">Gestión de Notas</h2>
            <p class="text-blue-100 text-center">Organiza tus ideas y recordatorios</p>
        </div>
    </div>
    
    <!-- Mensajes de estado -->
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm animate__animated animate__fadeIn" role="alert">
            <div class="flex items-center">
                <svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p>{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm animate__animated animate__fadeIn" role="alert">
            <div class="flex items-center">
                <svg class="h-5 w-5 text-red-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <p>{{ session('error') }}</p>
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
                        <input type="text" id="searchInput" placeholder="Buscar nota..." 
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
                            <option value="general">General</option>
                            <option value="client">Clientes</option>
                            <option value="lead">Leads</option>
                            <option value="project">Proyectos</option>
                            <option value="sale">Ventas</option>
                        </select>
                    </div>
                    
                    <!-- Botón de añadir nota -->
                    <a href="{{ route('notes.create') }}" 
                        class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-brand-blue rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 shadow-sm transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Nueva Nota
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Notas Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($notes as $note)
            <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 border border-gray-200 overflow-hidden note-card" data-related="{{ $note->RelatedTo }}">
                <div class="p-6">
                    <!-- Título y tipo de nota -->
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $note->Title }}</h3>
                        @php
                            $badgeColors = [
                                'general' => 'bg-gray-100 text-gray-800',
                                'client' => 'bg-blue-100 text-blue-800',
                                'lead' => 'bg-purple-100 text-purple-800',
                                'project' => 'bg-green-100 text-green-800',
                                'sale' => 'bg-yellow-100 text-yellow-800'
                            ];
                            $badgeLabels = [
                                'general' => 'General',
                                'client' => 'Cliente',
                                'lead' => 'Lead',
                                'project' => 'Proyecto',
                                'sale' => 'Venta'
                            ];
                            $badgeColor = $badgeColors[$note->RelatedTo] ?? 'bg-gray-100 text-gray-800';
                            $badgeLabel = $badgeLabels[$note->RelatedTo] ?? 'Otro';
                        @endphp
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeColor }}">
                            {{ $badgeLabel }}
                        </span>
                    </div>
                    
                    <!-- Contenido de la nota (limitado) -->
                    <div class="text-gray-700 text-sm mb-4 note-content">
                        {{ Str::limit($note->Content, 150) }}
                    </div>
                    
                    <!-- Metadatos y acciones -->
                    <div class="mt-4 border-t pt-4 flex justify-between items-center text-xs text-gray-500">
                        <div>
                            <span>Por: {{ $note->creator ? $note->creator->Name : 'Usuario' }}</span>
                            <span class="ml-3">{{ $note->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('notes.show', $note->idNote) }}" class="text-blue-600 hover:text-blue-800 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                            <a href="{{ route('notes.edit', $note->idNote) }}" class="text-indigo-600 hover:text-indigo-800 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <form method="POST" action="{{ route('notes.destroy', $note->idNote) }}" class="inline delete-note-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="text-red-600 hover:text-red-800 transition-colors delete-note" title="Eliminar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-lg shadow-sm p-8 text-center border border-gray-200">
                <div class="flex flex-col items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No hay notas disponibles</h3>
                    <p class="text-gray-600 mb-6">Comienza a crear notas para organizar tu información</p>
                    <a href="{{ route('notes.create') }}" class="bg-brand-blue hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md inline-flex items-center transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Crear primera nota
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Paginación -->
    <div class="mt-6">
        {{ $notes->links() }}
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Búsqueda en tiempo real
        const searchInput = document.getElementById('searchInput');
        const noteCards = document.querySelectorAll('.note-card');
        
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            
            noteCards.forEach(card => {
                const title = card.querySelector('h3').textContent.toLowerCase();
                const content = card.querySelector('.note-content').textContent.toLowerCase();
                
                if (title.includes(searchTerm) || content.includes(searchTerm)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
        
        // Filtrado por tipo
        const typeFilter = document.getElementById('filter-type');
        
        typeFilter.addEventListener('change', function() {
            const selectedType = this.value;
            
            if (selectedType === '') {
                // Mostrar todas las notas
                noteCards.forEach(card => {
                    card.style.display = '';
                });
            } else {
                // Filtrar por tipo seleccionado
                noteCards.forEach(card => {
                    if (card.dataset.related === selectedType) {
                        card.style.display = '';
                    } else {
                        card.style.display = 'none';
                    }
                });
            }
        });
        
        // Confirmación para eliminar notas
        document.querySelectorAll('.delete-note').forEach(button => {
            button.addEventListener('click', function() {
                if (confirm('¿Estás seguro de que deseas eliminar esta nota? Esta acción no se puede deshacer.')) {
                    this.closest('form').submit();
                }
            });
        });
    });
</script>
@endsection 