@extends('layouts.app')

@section('title', 'Editar Producto')

@section('header', 'Editar Producto')
@section('breadcrumb', 'Productos / Editar')

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
    
    .btn-danger {
        @apply bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 transition duration-150 ease-in-out;
    }
</style>
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Encabezado del formulario -->
    <div class="mb-10 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="bg-blue-100 text-blue-600 rounded-full p-3">
                <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
            </div>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Editar producto</h1>
                <p class="text-gray-500 mt-1">ID: {{ $product->idProductService }}</p>
            </div>
        </div>
        <a href="{{ route('productos.index') }}" class="inline-flex items-center px-4 py-2 border rounded-md text-gray-700 bg-white hover:bg-gray-50 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Volver
        </a>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-8 rounded-lg shadow-sm">
            <div class="font-semibold mb-1 flex items-center gap-2">
                <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                Se encontraron los siguientes errores:
            </div>
            <ul class="mt-2 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('productos.update', $product->idProductService) }}" method="POST" class="space-y-10">
        @csrf
        @method('PUT')
        
        <!-- Información básica -->
        <div class="form-section">
            <h2 class="form-section-title flex items-center gap-2">
                <svg class="h-5 w-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m2 0a8 8 0 11-16 0 8 8 0 0116 0z"/>
                </svg>
                Información básica
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="form-group">
                    <label for="Name">Nombre del producto <span class="text-red-600">*</span></label>
                    <input type="text" name="Name" id="Name" value="{{ old('Name', $product->Name) }}" required
                        class="form-input @error('Name') border-red-500 @enderror" placeholder="Ej. Laptop HP Pavilion">
                    @error('Name')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Máximo 45 caracteres</p>
                </div>
                
                <div class="form-group">
                    <label for="Price">Precio <span class="text-red-600">*</span></label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">€</span>
                        </div>
                        <input type="number" name="Price" id="Price" value="{{ old('Price', $product->Price) }}" min="0" step="0.01" required
                            class="form-input pl-7 @error('Price') border-red-500 @enderror" placeholder="0.00">
                    </div>
                    @error('Price')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="Stock">Stock disponible <span class="text-red-600">*</span></label>
                    <input type="number" name="Stock" id="Stock" value="{{ old('Stock', $product->Stock) }}" min="0" required
                        class="form-input @error('Stock') border-red-500 @enderror" placeholder="Cantidad">
                    @error('Stock')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label>Fecha de entrada</label>
                    <div class="mt-1 py-2 px-3 bg-gray-100 rounded-md text-gray-700 text-sm border border-gray-200">
                        {{ $product->EntryDate ? $product->EntryDate->format('d/m/Y H:i') : 'No disponible' }}
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Esta fecha no se puede modificar</p>
                </div>
            </div>
        </div>
        
        <!-- Descripción -->
        <div class="form-section">
            <h2 class="form-section-title flex items-center gap-2">
                <svg class="h-5 w-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v1.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                Descripción del producto
            </h2>
            <div class="form-group">
                <label for="Description">Descripción detallada</label>
                <textarea name="Description" id="Description" rows="4"
                    class="form-input @error('Description') border-red-500 @enderror"
                    placeholder="Describe las características del producto...">{{ old('Description', $product->Description) }}</textarea>
                @error('Description')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <!-- Acciones -->
        <div class="flex flex-col md:flex-row md:justify-between gap-4 pt-8 border-t border-gray-200">
            <button type="button" onclick="confirmDelete()" class="btn-danger flex items-center w-full md:w-auto justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Eliminar
            </button>
            <div class="flex gap-3 w-full md:w-auto justify-end">
                <a href="{{ route('productos.index') }}" class="btn-secondary flex items-center justify-center w-full md:w-auto">
                    Cancelar
                </a>
                <button type="submit" class="btn-primary flex items-center justify-center w-full md:w-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Actualizar Producto
                </button>
            </div>
        </div>
    </form>

    <!-- Formulario de eliminación separado -->
    <form action="{{ route('productos.destroy', $product->idProductService) }}" method="POST" id="delete-form" class="hidden">
        @csrf
        @method('DELETE')
    </form>
</div>
@endsection

@section('scripts')
<script>
    function confirmDelete() {
        if (confirm('¿Estás seguro que deseas eliminar este producto? Esta acción no se puede deshacer.')) {
            document.getElementById('delete-form').submit();
        }
    }
</script>
@endsection