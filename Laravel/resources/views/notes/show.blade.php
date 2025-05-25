@extends('layouts.app')

@section('title', 'Detalle de Nota')
@section('header', 'Detalle de Nota')
@section('breadcrumb', 'Notas / Ver')

@section('content')
    <!-- Banner -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 py-6 mb-8 rounded-xl shadow-lg border border-blue-700 animate__animated animate__fadeIn">
        <div class="container mx-auto px-6">
            <h2 class="text-2xl font-bold text-white mb-2 text-center">Detalle de Nota</h2>
            <p class="text-blue-100 text-center">Información completa sobre la nota</p>
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

    <!-- Contenido de la nota -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200 animate__animated animate__fadeIn">
        <div class="border-b border-gray-200 p-6">
            <div class="flex justify-between items-start">
                <h1 class="text-2xl font-bold text-gray-800">{{ $note->Title }}</h1>
                
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
                
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $badgeColor }}">
                    {{ $badgeLabel }}
                    @if($note->RelatedID)
                    <span class="ml-2 text-xs bg-white bg-opacity-50 px-2 py-1 rounded-full">#{{ $note->RelatedID }}</span>
                    @endif
                </span>
            </div>
        </div>
        
        <div class="p-6">
            <div class="prose max-w-none">
                {!! nl2br(e($note->Content)) !!}
            </div>
            
            <!-- Metadatos -->
            <div class="mt-8 border-t border-gray-200 pt-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Creado por: <span class="font-medium text-gray-900">{{ $note->creator ? $note->creator->Name : 'Usuario' }}</span></p>
                        <p class="text-sm text-gray-500">Fecha de creación: <span class="font-medium text-gray-900">{{ $note->created_at->format('d/m/Y H:i:s') }}</span></p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-500">Última actualización: <span class="font-medium text-gray-900">{{ $note->updated_at->format('d/m/Y H:i:s') }}</span></p>
                        @if($note->RelatedTo !== 'general' && $note->RelatedID)
                            <p class="text-sm text-gray-500">Relacionado con: 
                                <a href="{{ 
                                    $note->RelatedTo === 'client' ? route('clients.show', $note->RelatedID) : 
                                    ($note->RelatedTo === 'lead' ? route('leads.show', $note->RelatedID) : 
                                    ($note->RelatedTo === 'project' ? route('proyectos.show', $note->RelatedID) : 
                                    ($note->RelatedTo === 'sale' ? route('ventas.propuestas.show', $note->RelatedID) : '#')))
                                }}" class="font-medium text-blue-600 hover:text-blue-800">
                                    Ver {{ $badgeLabel }} #{{ $note->RelatedID }}
                                </a>
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Acciones -->
        <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3 border-t border-gray-200">
            <a href="{{ route('notes.index') }}" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Volver
            </a>
            <a href="{{ route('notes.edit', $note->idNote) }}" class="px-4 py-2 border border-blue-300 rounded-md shadow-sm text-sm font-medium text-blue-700 bg-blue-50 hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Editar
            </a>
            <form method="POST" action="{{ route('notes.destroy', $note->idNote) }}" class="inline" id="deleteNoteForm">
                @csrf
                @method('DELETE')
                <button type="button" id="deleteNoteBtn" class="px-4 py-2 border border-red-300 rounded-md shadow-sm text-sm font-medium text-red-700 bg-red-50 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Eliminar
                </button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Confirmación para eliminar la nota
        const deleteBtn = document.getElementById('deleteNoteBtn');
        const deleteForm = document.getElementById('deleteNoteForm');
        
        if (deleteBtn && deleteForm) {
            deleteBtn.addEventListener('click', function() {
                if (confirm('¿Estás seguro de que deseas eliminar esta nota? Esta acción no se puede deshacer.')) {
                    deleteForm.submit();
                }
            });
        }
    });
</script>
@endsection 