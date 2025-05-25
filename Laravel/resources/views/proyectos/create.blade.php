@extends('layouts.app')

@section('title', 'Crear Nuevo Proyecto')

@section('header', 'Crear Nuevo Proyecto')
@section('breadcrumb', 'Proyectos / Crear')

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
<div class="max-w-4xl mx-auto">
    <form action="{{ route('proyectos.store') }}" method="POST" class="form-container">
        @csrf
        
        @if($errors->any())
            <div class="error-alert">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Hay errores en el formulario</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        
        <!-- Información básica -->
        <div class="form-section">
            <h3 class="form-section-title">Información Básica</h3>
            
            <div class="form-row">
                <label for="Name" class="form-label">Nombre del Proyecto <span class="required-mark">*</span></label>
                <input type="text" name="Name" id="Name" class="form-input" value="{{ old('Name') }}" required>
                @error('Name')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="form-row">
                <label for="Description" class="form-label">Descripción</label>
                <textarea name="Description" id="Description" rows="4" class="form-textarea">{{ old('Description') }}</textarea>
                @error('Description')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="form-row">
                <label for="ClientID" class="form-label">Cliente</label>
                <select name="ClientID" id="ClientID" class="form-select">
                    <option value="">Seleccionar cliente</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->idClient }}" {{ old('ClientID') == $client->idClient ? 'selected' : '' }}>
                            {{ $client->Name }}
                        </option>
                    @endforeach
                </select>
                @error('ClientID')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="form-row">
                    <label for="StartDate" class="form-label">Fecha de Inicio</label>
                    <input type="date" name="StartDate" id="StartDate" class="form-input" value="{{ old('StartDate') }}">
                    @error('StartDate')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-row">
                    <label for="EndDate" class="form-label">Fecha de Fin</label>
                    <input type="date" name="EndDate" id="EndDate" class="form-input" value="{{ old('EndDate') }}">
                    @error('EndDate')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="form-row mb-0">
                <label for="Status" class="form-label">Estado <span class="required-mark">*</span></label>
                <select name="Status" id="Status" class="form-select" required>
                    <option value="Pending" {{ old('Status') == 'Pending' ? 'selected' : '' }}>Pendiente</option>
                    <option value="In Progress" {{ old('Status') == 'In Progress' ? 'selected' : '' }}>En Progreso</option>
                    <option value="Completed" {{ old('Status') == 'Completed' ? 'selected' : '' }}>Completado</option>
                    <option value="Cancelled" {{ old('Status') == 'Cancelled' ? 'selected' : '' }}>Cancelado</option>
                </select>
                @error('Status')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <!-- Información financiera -->
        <div class="form-section">
            <h3 class="form-section-title">Información Financiera</h3>
            
            <div class="form-row">
                <label for="Budget" class="form-label">Presupuesto (€)</label>
                <input type="number" name="Budget" id="Budget" class="form-input" step="0.01" min="0" value="{{ old('Budget') }}" placeholder="0.00">
                @error('Budget')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="form-row mb-0">
                <label for="BillingType" class="form-label">Tipo de Facturación <span class="required-mark">*</span></label>
                <select name="BillingType" id="BillingType" class="form-select" required>
                    <option value="Fixed" {{ old('BillingType') == 'Fixed' ? 'selected' : '' }}>Precio Fijo</option>
                    <option value="Hourly" {{ old('BillingType') == 'Hourly' ? 'selected' : '' }}>Por Horas</option>
                    <option value="None" {{ old('BillingType') == 'None' ? 'selected' : '' }}>Sin Facturación</option>
                </select>
                @error('BillingType')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <!-- Notas adicionales -->
        <div class="form-section">
            <h3 class="form-section-title">Notas Adicionales</h3>
            
            <div class="form-row mb-0">
                <label for="Notes" class="form-label">Notas</label>
                <textarea name="Notes" id="Notes" rows="3" class="form-textarea" placeholder="Información adicional sobre el proyecto...">{{ old('Notes') }}</textarea>
                @error('Notes')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <!-- Botones de acción -->
        <div class="flex justify-end space-x-4 mt-10 pt-6 border-t border-gray-200">
            <a href="{{ route('proyectos.index') }}" class="btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Cancelar
            </a>
            <button type="submit" class="btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Crear Proyecto
            </button>
        </div>
    </form>
</div>
@endsection 