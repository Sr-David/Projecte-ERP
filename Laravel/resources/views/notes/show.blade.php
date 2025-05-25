@extends('layouts.app')

@section('title', 'Detalle de Nota')
@section('header', 'Detalle de Nota')
@section('breadcrumb', 'Notas / Ver')

@section('styles')
<style>
    /* Estilos para notas tipo sticky */
    .sticky-note-container {
        max-width: 800px;
        margin: 0 auto 30px;
        padding: 30px;
        position: relative;
    }
    
    .sticky-note-detail {
        position: relative;
        padding: 30px;
        border-radius: 2px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.16), 0 5px 10px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        transform-origin: center;
        min-height: 300px;
    }
    
    .sticky-note-detail::before {
        content: '';
        position: absolute;
        top: 0;
        right: 40px;
        width: 30px;
        height: 30px;
        background-color: rgba(0, 0, 0, 0.1);
        box-shadow: 0 3px 5px rgba(0, 0, 0, 0.2);
        transform: translate(2px, -16px) rotate(45deg);
        z-index: -1;
    }
    
    /* Colores por tipo */
    .sticky-note-general {
        background: linear-gradient(135deg, #f9f9f9 0%, #ececec 100%);
        transform: rotate(-0.5deg);
    }
    
    .sticky-note-client {
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
        transform: rotate(0.5deg);
    }
    
    .sticky-note-lead {
        background: linear-gradient(135deg, #f3e5f5 0%, #e1bee7 100%);
        transform: rotate(-0.3deg);
    }
    
    .sticky-note-project {
        background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
        transform: rotate(0.4deg);
    }
    
    .sticky-note-sale {
        background: linear-gradient(135deg, #fff8e1 0%, #ffecb3 100%);
        transform: rotate(-0.4deg);
    }
    
    /* Contenido */
    .sticky-note-title {
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        word-break: break-word;
    }
    
    .sticky-note-content {
        font-size: 16px;
        color: #444;
        margin-bottom: 30px;
        line-height: 1.6;
        white-space: pre-wrap;
    }
    
    .sticky-note-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        font-size: 12px;
        font-weight: 500;
        padding: 5px 12px;
        border-radius: 16px;
    }
    
    .sticky-note-metadata {
        margin-top: auto;
        border-top: 1px dashed rgba(0, 0, 0, 0.1);
        padding-top: 15px;
        font-size: 14px;
        color: #666;
    }
</style>
@endsection

@section('content')
    <!-- Banner -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 py-6 mb-8 rounded-xl shadow-lg border border-blue-700 animate__animated animate__fadeIn">
        <div class="container mx-auto px-6">
            <h2 class="text-2xl font-bold text-white mb-2 text-center">Detalle de Nota</h2>
            <p class="text-blue-100 text-center">Información completa sobre la nota</p>
        </div>
    </div>
    
    <!-- Los mensajes de estado ahora son manejados desde app.blade.php en un formato unificado -->

    <!-- Contenido de la nota -->
    <div class="sticky-note-container animate__animated animate__fadeIn">
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
        
        <div class="sticky-note-detail sticky-note-{{ $note->RelatedTo }}">
            <span class="sticky-note-badge {{ $badgeColor }}">
                {{ $badgeLabel }}
                @if($note->RelatedID)
                <span class="ml-2 text-xs bg-white bg-opacity-50 px-2 py-1 rounded-full">#{{ $note->RelatedID }}</span>
                @endif
            </span>
            
            <h1 class="sticky-note-title">{{ $note->Title }}</h1>
            
            <div class="sticky-note-content">
                {!! nl2br(e($note->Content)) !!}
            </div>
            
            <!-- Metadatos -->
            <div class="sticky-note-metadata">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p>Creado por: <span class="font-medium text-gray-900">{{ $note->creator ? $note->creator->Name : 'Usuario' }}</span></p>
                        <p>Fecha de creación: <span class="font-medium text-gray-900">{{ $note->created_at->format('d/m/Y H:i:s') }}</span></p>
                    </div>
                    
                    <div>
                        <p>Última actualización: <span class="font-medium text-gray-900">{{ $note->updated_at->format('d/m/Y H:i:s') }}</span></p>
                        @if($note->RelatedTo !== 'general' && $note->RelatedID)
                            <p>Relacionado con: 
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
        <div class="bg-white px-6 py-4 flex justify-end space-x-3 rounded-lg shadow-sm border border-gray-200 mt-6">
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