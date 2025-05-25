@extends('layouts.app')

@section('title', 'Editar Proyecto')

@section('header', 'Editar Proyecto')
@section('breadcrumb', 'Proyectos / Editar')

@section('styles')
<style>
    .form-container {
        @apply bg-white shadow-sm rounded-lg p-8;
    }
    
    .form-section {
        @apply mb-10;
    }
    
    .form-section:last-of-type {
        @apply mb-6;
    }
    
    .form-section-title {
        @apply text-lg font-medium text-gray-800 mb-6 pb-2 border-b border-gray-200;
    }
    
    .form-row {
        @apply mb-6;
    }
    
    .form-label {
        @apply block text-sm font-medium text-gray-700 mb-2;
    }
    
    .form-input {
        @apply block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 transition-colors;
        min-height: 42px;
    }
    
    .form-textarea {
        @apply block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 transition-colors;
    }
    
    .form-select {
        @apply block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 transition-colors;
        min-height: 42px;
    }
    
    .btn-primary {
        @apply inline-flex items-center justify-center px-5 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors;
        min-height: 42px;
    }
    
    .btn-secondary {
        @apply inline-flex items-center justify-center px-5 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors;
        min-height: 42px;
    }
    
    .error-message {
        @apply mt-2 text-sm text-red-600;
    }
    
    .required-mark {
        @apply text-red-600 ml-1;
    }
    
    .error-alert {
        @apply mb-8 bg-red-50 border-l-4 border-red-500 p-4 rounded;
    }
</style>
@endsection

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Encabezado -->
    <div class="flex items-center mb-10">
        <div class="bg-indigo-100 text-indigo-600 rounded-full p-3 mr-4">
            <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
        </div>
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Editar Proyecto</h1>
            <p class="text-gray-500 mt-1">Modifica la información del proyecto.</p>
        </div>
    </div>

    <form action="{{ route('proyectos.update', $project->idProject) }}" method="POST" class="form-container space-y-10">
        @csrf
        @method('PUT')

        @if($errors->any())
            <div class="error-alert">
                <div class="flex items-start">
                    <svg class="h-5 w-5 text-red-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <div class="ml-3">
                        <h3 class="text-sm font-semibold text-red-800">Hay errores en el formulario</h3>
                        <ul class="mt-2 text-sm text-red-700 list-disc pl-5 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Información Básica -->
        <div class="space-y-6">
            <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                <svg class="h-5 w-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m2 0a8 8 0 11-16 0 8 8 0 0116 0z"/>
                </svg>
                Información Básica
            </h2>

            <div class="space-y-5">
                <div>
                    <label for="Name" class="block text-sm font-medium text-gray-700">Nombre del Proyecto <span class="text-red-500">*</span></label>
                    <input type="text" name="Name" id="Name" value="{{ old('Name', $project->Name) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    @error('Name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="Description" class="block text-sm font-medium text-gray-700">Descripción</label>
                    <textarea name="Description" id="Description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('Description', $project->Description) }}</textarea>
                    @error('Description') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="ClientID" class="block text-sm font-medium text-gray-700">Cliente</label>
                    <select name="ClientID" id="ClientID" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Seleccionar cliente</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->idClient }}" {{ old('ClientID', $project->ClientID) == $client->idClient ? 'selected' : '' }}>
                                {{ $client->Name }}
                            </option>
                        @endforeach
                    </select>
                    @error('ClientID') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="StartDate" class="block text-sm font-medium text-gray-700">Fecha de Inicio</label>
                        <input type="date" name="StartDate" id="StartDate" value="{{ old('StartDate', $project->StartDate ? $project->StartDate->format('Y-m-d') : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('StartDate') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="EndDate" class="block text-sm font-medium text-gray-700">Fecha de Fin</label>
                        <input type="date" name="EndDate" id="EndDate" value="{{ old('EndDate', $project->EndDate ? $project->EndDate->format('Y-m-d') : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('EndDate') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="Status" class="block text-sm font-medium text-gray-700">Estado <span class="text-red-500">*</span></label>
                    <select name="Status" id="Status" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="Pending" {{ old('Status', $project->Status) == 'Pending' ? 'selected' : '' }}>Pendiente</option>
                        <option value="In Progress" {{ old('Status', $project->Status) == 'In Progress' ? 'selected' : '' }}>En Progreso</option>
                        <option value="Completed" {{ old('Status', $project->Status) == 'Completed' ? 'selected' : '' }}>Completado</option>
                        <option value="Cancelled" {{ old('Status', $project->Status) == 'Cancelled' ? 'selected' : '' }}>Cancelado</option>
                    </select>
                    @error('Status') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- Información Financiera -->
        <div class="space-y-6">
            <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Información Financiera
            </h2>

            <div class="space-y-5">
                <div>
                    <label for="Budget" class="block text-sm font-medium text-gray-700">Presupuesto (€)</label>
                    <input type="number" step="0.01" min="0" name="Budget" id="Budget" value="{{ old('Budget', $project->Budget) }}" placeholder="0.00" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    @error('Budget') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="BillingType" class="block text-sm font-medium text-gray-700">Tipo de Facturación <span class="text-red-500">*</span></label>
                    <select name="BillingType" id="BillingType" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="Fixed" {{ old('BillingType', $project->BillingType) == 'Fixed' ? 'selected' : '' }}>Precio Fijo</option>
                        <option value="Hourly" {{ old('BillingType', $project->BillingType) == 'Hourly' ? 'selected' : '' }}>Por Horas</option>
                        <option value="None" {{ old('BillingType', $project->BillingType) == 'None' ? 'selected' : '' }}>Sin Facturación</option>
                    </select>
                    @error('BillingType') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- Notas -->
        <div class="space-y-6">
            <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                <svg class="h-5 w-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v1.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                Notas Adicionales
            </h2>

            <div>
                <label for="Notes" class="block text-sm font-medium text-gray-700">Notas</label>
                <textarea name="Notes" id="Notes" rows="3" placeholder="Información adicional sobre el proyecto..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('Notes', $project->Notes) }}</textarea>
                @error('Notes') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Botones -->
        <div class="flex justify-end gap-4 pt-8 border-t border-gray-200">
            <a href="{{ route('proyectos.show', $project->idProject) }}" class="inline-flex items-center px-4 py-2 border rounded-md text-gray-700 bg-white hover:bg-gray-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Cancelar
            </a>
            <button type="submit" class="inline-flex items-center px-5 py-2 border border-transparent text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                Guardar Cambios
            </button>
        </div>
    </form>
</div>
@endsection