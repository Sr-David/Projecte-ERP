@extends('layouts.app')

@section('title', 'Gestión de Proyectos')

@section('header', 'Gestión de Proyectos')
@section('breadcrumb', 'Proyectos')

@section('styles')
<style>
    .project-card {
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .project-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    
    .status-badge {
        @apply px-2 py-1 rounded-full text-xs font-medium;
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
    
    .stats-card {
        @apply bg-white rounded-lg shadow-sm border border-gray-200 p-4;
        transition: all 0.3s ease;
    }
    
    .stats-card:hover {
        @apply shadow-md border-gray-300;
    }
    
    .btn-primary {
        @apply inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition;
    }
    
    .form-input {
        @apply mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50;
    }
    
    .card-body {
        flex: 1 1 auto;
    }
    
    .card-footer {
        margin-top: auto;
    }
</style>
@endsection

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Estadísticas rápidas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="stats-card">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-indigo-100 text-indigo-600 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Total de Proyectos</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</p>
                </div>
            </div>
        </div>

        <div class="stats-card">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Pendientes</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['pending'] }}</p>
                </div>
            </div>
        </div>

        <div class="stats-card">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">En Progreso</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['in_progress'] }}</p>
                </div>
            </div>
        </div>

        <div class="stats-card">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Completados</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['completed'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros y búsqueda -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 md:mb-0">Filtros</h2>
            <div class="flex flex-col md:flex-row md:space-x-4 space-y-2 md:space-y-0">
                <a href="{{ route('proyectos.create') }}" class="btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Nuevo Proyecto
                </a>
            </div>
        </div>
        
        <div class="mt-6 border-t border-gray-200 pt-4">
            <form action="{{ route('proyectos.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                    <input type="text" name="search" id="search" class="form-input" placeholder="Nombre del proyecto..." value="{{ request('search') }}">
                </div>
                
                <div>
                    <label for="client" class="block text-sm font-medium text-gray-700 mb-1">Cliente</label>
                    <select name="client" id="client" class="form-input">
                        <option value="">Todos los clientes</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->idClient }}" {{ request('client') == $client->idClient ? 'selected' : '' }}>
                                {{ $client->Name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                    <select name="status" id="status" class="form-input">
                        <option value="">Todos los estados</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pendiente</option>
                        <option value="In Progress" {{ request('status') == 'In Progress' ? 'selected' : '' }}>En Progreso</option>
                        <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completado</option>
                        <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelado</option>
                    </select>
                </div>
                
                <div class="flex items-end">
                    <button type="submit" class="btn-primary w-full justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Filtrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Listado de proyectos -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-medium text-gray-800">Lista de Proyectos</h3>
        </div>
        
        @if(count($projects) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
                @foreach($projects as $project)
                    <a href="{{ route('proyectos.show', $project->idProject) }}" class="project-card block bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:no-underline">
                        <div class="px-4 py-3 border-b border-gray-200 flex justify-between items-center bg-gray-50">
                            <h3 class="font-medium text-gray-800 truncate">{{ $project->Name }}</h3>
                            <div>
                                @switch($project->Status)
                                    @case('Pending')
                                        <span class="status-badge status-pending">Pendiente</span>
                                        @break
                                    @case('In Progress')
                                        <span class="status-badge status-in-progress">En Progreso</span>
                                        @break
                                    @case('Completed')
                                        <span class="status-badge status-completed">Completado</span>
                                        @break
                                    @case('Cancelled')
                                        <span class="status-badge status-cancelled">Cancelado</span>
                                        @break
                                    @default
                                        <span class="status-badge status-pending">Pendiente</span>
                                @endswitch
                            </div>
                        </div>
                        <div class="p-4 card-body">
                            @if($project->client)
                                <div class="flex items-center text-sm text-gray-600 mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span class="truncate">{{ $project->client->Name }}</span>
                                </div>
                            @endif
                            
                            <div class="flex items-center text-sm text-gray-600 mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Inicio: {{ $project->StartDate ? $project->StartDate->format('d/m/Y') : 'No definido' }}
                            </div>
                            
                            @if($project->EndDate)
                                <div class="flex items-center text-sm text-gray-600 mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Fin: {{ $project->EndDate->format('d/m/Y') }}
                                </div>
                            @endif
                            
                            @if($project->Budget)
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Presupuesto: {{ number_format($project->Budget, 2, ',', '.') }} €
                                </div>
                            @endif
                        </div>
                        <div class="px-4 py-2 bg-gray-50 border-t border-gray-200 text-right card-footer">
                            <span class="text-xs text-gray-500">Creado: {{ $project->CreatedAt->format('d/m/Y') }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
            
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $projects->links() }}
            </div>
        @else
            <div class="p-8 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mx-auto mb-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <h3 class="text-xl font-medium text-gray-800 mb-2">No hay proyectos disponibles</h3>
                <p class="text-gray-500 mb-6">No se encontraron proyectos con los filtros aplicados.</p>
                <div>
                    <a href="{{ route('proyectos.create') }}" class="btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Crear Nuevo Proyecto
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection 