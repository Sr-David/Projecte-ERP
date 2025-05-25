@extends('layouts.app')

@section('title', 'Detalles del Proyecto')

@section('header', 'Detalles del Proyecto')
@section('breadcrumb', 'Proyectos / Detalles')

@section('styles')
<style>
    .project-header {
        @apply bg-gradient-to-r from-indigo-600 to-blue-500 rounded-lg shadow-md p-8 text-white mb-8;
    }
    
    .project-status {
        @apply px-3 py-1 rounded-full text-xs font-medium;
    }
    
    .status-pending {
        @apply bg-yellow-100 text-yellow-800;
    }
    
    .status-in-progress {
        @apply bg-blue-100 text-blue-800;
    }
    
    .status-completed {
        @apply bg-green-100 text-green-800;
    }
    
    .status-cancelled {
        @apply bg-red-100 text-red-800;
    }
    
    .tab-active {
        @apply border-indigo-500 text-indigo-600;
    }
    
    .tab-inactive {
        @apply border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300;
    }
    
    .tab-content {
        @apply bg-white rounded-lg shadow-sm p-6;
    }
    
    .action-button {
        @apply inline-flex items-center px-4 py-2 rounded-md shadow-sm text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors;
    }
    
    .btn-primary {
        @apply bg-indigo-600 text-white hover:bg-indigo-700 border border-transparent;
    }
    
    .btn-secondary {
        @apply bg-white text-gray-700 hover:bg-gray-50 border border-gray-300;
    }
    
    .btn-danger {
        @apply bg-red-600 text-white hover:bg-red-700 border border-transparent;
    }
    
    .data-table {
        @apply w-full;
    }
    
    .data-table dt {
        @apply text-sm font-medium text-gray-500;
    }
    
    .data-table dd {
        @apply mt-1 text-sm text-gray-900;
    }
    
    .data-row {
        @apply px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6;
    }
    
    .data-row-alt {
        @apply px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 bg-gray-50;
    }
    
    .note-card {
        @apply bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden mb-4;
        transition: all 0.2s ease-in-out;
    }
    
    .note-card:hover {
        @apply shadow-md border-gray-300;
    }
</style>
@endsection

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Cabecera del proyecto -->
    <div class="project-header flex flex-col md:flex-row justify-between">
        <div>
            <div class="flex items-center mb-3">
                <h1 class="text-2xl font-bold">{{ $project->Name }}</h1>
                <div class="ml-4">
                    @switch($project->Status)
                        @case('Pending')
                            <span class="project-status status-pending">Pendiente</span>
                            @break
                        @case('In Progress')
                            <span class="project-status status-in-progress">En Progreso</span>
                            @break
                        @case('Completed')
                            <span class="project-status status-completed">Completado</span>
                            @break
                        @case('Cancelled')
                            <span class="project-status status-cancelled">Cancelado</span>
                            @break
                        @default
                            <span class="project-status status-pending">Pendiente</span>
                    @endswitch
                </div>
            </div>
            
            @if($client)
                <p class="text-blue-100 mb-2">Cliente: {{ $client->Name }}</p>
            @endif
            
            <p class="text-blue-100">
                Fechas: 
                {{ $project->StartDate ? $project->StartDate->format('d/m/Y') : 'No definido' }}
                @if($project->EndDate)
                    - {{ $project->EndDate->format('d/m/Y') }}
                @endif
            </p>
        </div>
        
        <div class="mt-6 md:mt-0 flex flex-wrap gap-3">
            <a href="{{ route('proyectos.edit', $project->idProject) }}" class="action-button btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                </svg>
                Editar
            </a>
            
            <form action="{{ route('proyectos.destroy', $project->idProject) }}" method="POST" class="inline" id="delete-form">
                @csrf
                @method('DELETE')
                <button type="button" class="action-button btn-danger" id="delete-button">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    Eliminar
                </button>
            </form>
            
            <a href="{{ route('proyectos.index') }}" class="action-button btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Volver
            </a>
        </div>
    </div>
    
    <!-- Pestañas de navegación -->
    <div class="mb-6">
        <div class="border-b border-gray-200">
            <nav class="flex space-x-8" aria-label="Tabs">
                <button type="button" class="tab-button py-4 px-1 border-b-2 font-medium text-sm tab-active" data-tab="details">
                    Detalles
                </button>
                <button type="button" class="tab-button py-4 px-1 border-b-2 font-medium text-sm tab-inactive" data-tab="notes">
                    Notas
                    @if(count($notes) > 0)
                        <span class="ml-2 bg-gray-100 text-gray-600 py-0.5 px-2 rounded-full text-xs">{{ count($notes) }}</span>
                    @endif
                </button>
            </nav>
        </div>
    </div>
    
    <!-- Contenido de las pestañas -->
    <div id="tab-details" class="tab-content block">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="md:col-span-2">
                <div class="mb-8">
                    <h2 class="text-lg font-medium text-gray-800 mb-4">Información del Proyecto</h2>
                    
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                        <dl class="data-table">
                            <div class="data-row-alt">
                                <dt>Nombre</dt>
                                <dd class="sm:mt-0 sm:col-span-2">{{ $project->Name }}</dd>
                            </div>
                            <div class="data-row">
                                <dt>Descripción</dt>
                                <dd class="sm:mt-0 sm:col-span-2">
                                    {!! $project->Description ? nl2br(e($project->Description)) : '<span class="text-gray-400">Sin descripción</span>' !!}
                                </dd>
                            </div>
                            <div class="data-row-alt">
                                <dt>Cliente</dt>
                                <dd class="sm:mt-0 sm:col-span-2">
                                    @if($client)
                                        <a href="{{ route('clients.show', $client->idClient) }}" class="text-indigo-600 hover:text-indigo-900">
                                            {{ $client->Name }}
                                        </a>
                                    @else
                                        <span class="text-gray-400">Sin cliente asignado</span>
                                    @endif
                                </dd>
                            </div>
                            <div class="data-row">
                                <dt>Estado</dt>
                                <dd class="sm:mt-0 sm:col-span-2">
                                    @switch($project->Status)
                                        @case('Pending')
                                            <span class="project-status status-pending">Pendiente</span>
                                            @break
                                        @case('In Progress')
                                            <span class="project-status status-in-progress">En Progreso</span>
                                            @break
                                        @case('Completed')
                                            <span class="project-status status-completed">Completado</span>
                                            @break
                                        @case('Cancelled')
                                            <span class="project-status status-cancelled">Cancelado</span>
                                            @break
                                        @default
                                            <span class="project-status status-pending">Pendiente</span>
                                    @endswitch
                                </dd>
                            </div>
                            <div class="data-row-alt">
                                <dt>Fecha de Inicio</dt>
                                <dd class="sm:mt-0 sm:col-span-2">
                                    {{ $project->StartDate ? $project->StartDate->format('d/m/Y') : 'No definido' }}
                                </dd>
                            </div>
                            <div class="data-row">
                                <dt>Fecha de Fin</dt>
                                <dd class="sm:mt-0 sm:col-span-2">
                                    {{ $project->EndDate ? $project->EndDate->format('d/m/Y') : 'No definido' }}
                                </dd>
                            </div>
                            @if($project->Notes)
                                <div class="data-row-alt">
                                    <dt>Notas Adicionales</dt>
                                    <dd class="sm:mt-0 sm:col-span-2">
                                        {{ $project->Notes }}
                                    </dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                </div>
            </div>
            
            <div>
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-4 py-5 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-lg font-medium text-gray-800">Información Financiera</h3>
                    </div>
                    <div class="p-5">
                        <div class="mb-6">
                            <h4 class="text-sm font-medium text-gray-500 mb-2">Presupuesto</h4>
                            <p class="text-2xl font-bold text-gray-800">
                                @if($project->Budget)
                                    {{ number_format($project->Budget, 2, ',', '.') }} €
                                @else
                                    <span class="text-gray-400 text-base">No definido</span>
                                @endif
                            </p>
                        </div>
                        
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 mb-2">Tipo de Facturación</h4>
                            <p class="text-gray-800 font-medium">
                                @switch($project->BillingType)
                                    @case('Fixed')
                                        Precio Fijo
                                        @break
                                    @case('Hourly')
                                        Por Horas
                                        @break
                                    @case('None')
                                        Sin Facturación
                                        @break
                                    @default
                                        No definido
                                @endswitch
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden mt-6">
                    <div class="px-4 py-5 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-lg font-medium text-gray-800">Fechas Importantes</h3>
                    </div>
                    <div class="p-5">
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <dt class="text-sm font-medium text-gray-500">Creado</dt>
                            <dd class="text-sm text-gray-900">{{ $project->CreatedAt->format('d/m/Y H:i') }}</dd>
                        </div>
                        <div class="flex justify-between py-2">
                            <dt class="text-sm font-medium text-gray-500">Última Actualización</dt>
                            <dd class="text-sm text-gray-900">{{ $project->UpdatedAt->format('d/m/Y H:i') }}</dd>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div id="tab-notes" class="tab-content hidden">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-medium text-gray-800">Notas del Proyecto</h2>
            <a href="{{ route('notes.create', ['related_to' => 'project', 'related_id' => $project->idProject]) }}" class="action-button btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Nueva Nota
            </a>
        </div>
        
        @if(count($notes) > 0)
            <div class="space-y-6">
                @foreach($notes as $note)
                    <div class="note-card">
                        <div class="px-5 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                            <h3 class="font-medium text-gray-800">{{ $note->Title }}</h3>
                            <div class="text-sm text-gray-500">
                                {{ $note->created_at->format('d/m/Y H:i') }}
                            </div>
                        </div>
                        <div class="p-5">
                            <p class="text-gray-700 whitespace-pre-line">{{ $note->Content }}</p>
                        </div>
                        <div class="px-5 py-3 bg-gray-50 border-t border-gray-200 flex justify-end space-x-3">
                            <a href="{{ route('notes.edit', $note->idNote) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg>
                                Editar
                            </a>
                            <form action="{{ route('notes.destroy', $note->idNote) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                <h3 class="text-xl font-medium text-gray-800 mb-2">No hay notas para este proyecto</h3>
                <p class="text-gray-500 mb-6">Crea la primera nota para llevar un seguimiento del proyecto.</p>
                <a href="{{ route('notes.create', ['related_to' => 'project', 'related_id' => $project->idProject]) }}" class="action-button btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Crear Nueva Nota
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tab navigation
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');
        
        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                const tabName = this.getAttribute('data-tab');
                
                // Update active tab button
                tabButtons.forEach(btn => {
                    btn.classList.remove('tab-active');
                    btn.classList.add('tab-inactive');
                });
                this.classList.remove('tab-inactive');
                this.classList.add('tab-active');
                
                // Show selected tab content
                tabContents.forEach(content => {
                    content.classList.add('hidden');
                });
                document.getElementById('tab-' + tabName).classList.remove('hidden');
            });
        });
        
        // Confirm delete
        const deleteForm = document.getElementById('delete-form');
        const deleteButton = document.getElementById('delete-button');
        
        if (deleteButton) {
            deleteButton.addEventListener('click', function(e) {
                e.preventDefault();
                if (confirm('¿Estás seguro de que quieres eliminar este proyecto? Esta acción no se puede deshacer.')) {
                    deleteForm.submit();
                }
            });
        }
    });
</script>
@endsection 