@extends('layouts.app')

@section('title', 'Gestión de Notas')
@section('header', 'Gestión de Notas')
@section('breadcrumb', 'Notas')

@section('styles')
<style>
    /* Estilos para notas tipo sticky */
    .sticky-notes-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 24px;
        padding: 20px 0;
    }
    
    .sticky-note {
        position: relative;
        min-height: 200px;
        padding: 16px;
        border-radius: 2px;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
        transition: all 0.2s ease;
        transform-origin: center;
    }
    
    .sticky-note::before {
        content: '';
        position: absolute;
        top: 0;
        right: 20px;
        width: 25px;
        height: 25px;
        background-color: rgba(0, 0, 0, 0.1);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        transform: translate(2px, -14px) rotate(45deg);
        z-index: -1;
    }
    
    .sticky-note:hover {
        transform: scale(1.02);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.19), 0 6px 6px rgba(0, 0, 0, 0.23);
    }
    
    /* Colores por tipo */
    .sticky-note-general {
        background: linear-gradient(135deg, #f9f9f9 0%, #ececec 100%);
        transform: rotate(-1deg);
    }
    
    .sticky-note-client {
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
        transform: rotate(1deg);
    }
    
    .sticky-note-lead {
        background: linear-gradient(135deg, #f3e5f5 0%, #e1bee7 100%);
        transform: rotate(-0.5deg);
    }
    
    .sticky-note-project {
        background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
        transform: rotate(0.7deg);
    }
    
    .sticky-note-sale {
        background: linear-gradient(135deg, #fff8e1 0%, #ffecb3 100%);
        transform: rotate(-0.8deg);
    }
    
    /* Contenido */
    .sticky-note-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 12px;
        padding-bottom: 8px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        word-break: break-word;
    }
    
    .sticky-note-content {
        font-size: 14px;
        color: #555;
        margin-bottom: 18px;
        flex-grow: 1;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 4;
        -webkit-box-orient: vertical;
    }
    
    .sticky-note-footer {
        border-top: 1px dashed rgba(0, 0, 0, 0.1);
        padding-top: 12px;
        margin-top: auto;
        font-size: 12px;
        color: #777;
        display: flex;
        justify-content: space-between;
    }
    
    .sticky-note-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        font-size: 11px;
        font-weight: 500;
        padding: 3px 8px;
        border-radius: 12px;
        opacity: 0.8;
    }
    
    /* Ajustes para notas */
    .sticky-note {
        display: flex;
        flex-direction: column;
    }
    
    /* Animaciones */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .sticky-note {
        animation: fadeIn 0.5s ease forwards;
        animation-delay: calc(var(--animation-order) * 0.1s);
        opacity: 0;
    }
</style>
@endsection

@section('content')
    <!-- Banner -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 py-6 mb-8 rounded-xl shadow-lg border border-blue-700 animate__animated animate__fadeIn">
        <div class="container mx-auto px-6">
            <h2 class="text-2xl font-bold text-white mb-2 text-center">Gestión de Notas</h2>
            <p class="text-blue-100 text-center">Organiza tus ideas y recordatorios</p>
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

    <!-- Notas Grid - Ahora como sticky notes -->
    <div class="sticky-notes-grid">
        @forelse($notes as $index => $note)
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
            
            <div class="sticky-note sticky-note-{{ $note->RelatedTo }} note-card" 
                data-related="{{ $note->RelatedTo }}" 
                style="--animation-order: {{ $index }}">
                
                <span class="sticky-note-badge {{ $badgeColor }}">
                    {{ $badgeLabel }}
                </span>
                
                <h3 class="sticky-note-title">{{ $note->Title }}</h3>
                <div class="sticky-note-content">
                    {{ Str::limit($note->Content, 150) }}
                </div>
                
                <div class="sticky-note-footer">
                    <div>
                        <span>Por: {{ $note->creator ? $note->creator->Name : 'Usuario' }}</span>
                        <span class="ml-3">{{ $note->created_at->format('d/m/Y') }}</span>
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
                const title = card.querySelector('.sticky-note-title').textContent.toLowerCase();
                const content = card.querySelector('.sticky-note-content').textContent.toLowerCase();
                
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
        
        // Aplicar rotaciones aleatorias adicionales para un efecto más natural
        document.querySelectorAll('.sticky-note').forEach(note => {
            // Pequeña variación aleatoria en la rotación (-0.5 a 0.5 grados)
            const extraRotation = (Math.random() - 0.5) * 1;
            const currentTransform = note.style.transform || '';
            
            if (currentTransform.includes('rotate')) {
                // Ajustar la rotación existente
                note.style.transform = currentTransform.replace(
                    /rotate\(([^)]+)\)/, 
                    (match, angle) => `rotate(${parseFloat(angle) + extraRotation}deg)`
                );
            } else {
                // Añadir rotación si no existe
                note.style.transform = currentTransform + ` rotate(${extraRotation}deg)`;
            }
        });
    });
</script>
@endsection 