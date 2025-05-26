@extends('layouts.app')

@section('title', 'Crear Producto')

@section('header', 'Crear Producto')
@section('breadcrumb', 'Productos / Crear')

@section('styles')
<style>
    .form-group label {
        @apply block text-sm font-medium text-gray-700 mb-1;
    }
    
    .form-input {
        @apply mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50;
    }
    
    .form-error {
        @apply mt-1 text-sm text-red-600;
    }
    
    .form-section {
        @apply bg-white overflow-hidden shadow-md rounded-lg p-6 mb-6;
    }
    
    .form-section-title {
        @apply text-lg font-medium leading-6 text-gray-900 mb-4 pb-2 border-b border-gray-200;
    }
    
    .btn-primary {
        @apply bg-brand-blue hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition duration-150 ease-in-out;
    }
    
    .btn-secondary {
        @apply bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50 transition duration-150 ease-in-out;
    }
</style>
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Form Header -->
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">Añadir nuevo producto</h1>
        <a href="{{ route('productos.index') }}" class="flex items-center text-gray-600 hover:text-gray-900">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Volver
        </a>
    </div>

    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6">
            <div class="font-medium">Se encontraron los siguientes errores:</div>
            <ul class="mt-2 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('productos.store') }}" method="POST" class="space-y-6">
        @csrf
        
        <!-- Basic Information -->
        <div class="form-section">
            <h2 class="form-section-title">Información básica</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="form-group">
                    <label for="Name">Nombre del producto <span class="text-red-600">*</span></label>
                    <input type="text" name="Name" id="Name" value="{{ old('Name') }}" required
                        class="form-input @error('Name') border-red-500 @enderror" placeholder="Ej. Laptop HP Pavilion">
                    @error('Name')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Máximo 45 caracteres</p>
                </div>
                
                <div class="form-group">
                    <label for="Price">Precio <span class="text-red-600">*</span></label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">€</span>
                        </div>
                        <input type="number" name="Price" id="Price" value="{{ old('Price') }}" min="0" step="0.01" required
                            class="form-input pl-7 @error('Price') border-red-500 @enderror" placeholder="0.00">
                    </div>
                    @error('Price')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="Stock">Stock inicial <span class="text-red-600">*</span></label>
                    <input type="number" name="Stock" id="Stock" value="{{ old('Stock', 1) }}" min="0" required
                        class="form-input @error('Stock') border-red-500 @enderror" placeholder="Cantidad">
                    @error('Stock')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        
        <!-- Description -->
        <div class="form-section">
            <h2 class="form-section-title">Descripción del producto</h2>
            <div class="form-group">
                <label for="Description">Descripción</label>
                <textarea name="Description" id="Description" rows="4"
                    class="form-input @error('Description') border-red-500 @enderror"
                    placeholder="Describe las características del producto...">{{ old('Description') }}</textarea>
                @error('Description')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <!-- Form Actions -->
        <div class="flex justify-end space-x-3">
            <a href="{{ route('productos.index') }}" class="btn-secondary hover:bg-gray-300 transition-colors duration-300 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                Cancelar
            </a>
            <button type="submit" class="btn-primary">
                <span class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Guardar Producto
                </span>
            </button>
        </div>
    </form>
</div>
@endsection 