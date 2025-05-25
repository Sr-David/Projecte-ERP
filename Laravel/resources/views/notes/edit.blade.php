@extends('layouts.app')

@section('title', 'Editar Nota')
@section('header', 'Editar Nota')
@section('breadcrumb', 'Notas / Editar')

@section('content')
    <!-- Banner -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 py-6 mb-8 rounded-xl shadow-lg border border-blue-700 animate__animated animate__fadeIn">
        <div class="container mx-auto px-6">
            <h2 class="text-2xl font-bold text-white mb-2 text-center">Editar Nota</h2>
            <p class="text-blue-100 text-center">Actualiza la información de tu nota</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
        @if($errors->any())
            <div class="bg-red-50 p-4 text-red-800 border-b border-red-200">
                <div class="flex items-start mb-2">
                    <svg class="h-5 w-5 text-red-500 mr-2 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <h3 class="text-sm font-medium">Por favor corrige los siguientes errores:</h3>
                </div>
                <ul class="list-disc list-inside pl-4 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('notes.update', $note->idNote) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            
            <!-- Título de la nota -->
            <div class="mb-6">
                <label for="Title" class="block text-sm font-medium text-gray-700 mb-1">Título <span class="text-red-600">*</span></label>
                <input type="text" name="Title" id="Title" value="{{ old('Title', $note->Title) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            
            <!-- Contenido de la nota -->
            <div class="mb-6">
                <label for="Content" class="block text-sm font-medium text-gray-700 mb-1">Contenido</label>
                <textarea name="Content" id="Content" rows="8" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('Content', $note->Content) }}</textarea>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Tipo de relación -->
                <div>
                    <label for="RelatedTo" class="block text-sm font-medium text-gray-700 mb-1">Relacionado con <span class="text-red-600">*</span></label>
                    <select name="RelatedTo" id="RelatedTo" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="general" {{ old('RelatedTo', $note->RelatedTo) == 'general' ? 'selected' : '' }}>General (Sin relación)</option>
                        <option value="client" {{ old('RelatedTo', $note->RelatedTo) == 'client' ? 'selected' : '' }}>Cliente</option>
                        <option value="lead" {{ old('RelatedTo', $note->RelatedTo) == 'lead' ? 'selected' : '' }}>Lead</option>
                        <option value="project" {{ old('RelatedTo', $note->RelatedTo) == 'project' ? 'selected' : '' }}>Proyecto</option>
                        <option value="sale" {{ old('RelatedTo', $note->RelatedTo) == 'sale' ? 'selected' : '' }}>Venta</option>
                    </select>
                </div>
                
                <!-- ID de relación -->
                <div id="relatedIdContainer" style="{{ $note->RelatedTo == 'general' ? 'display:none;' : '' }}">
                    <label for="RelatedID" class="block text-sm font-medium text-gray-700 mb-1">ID del {{ $note->RelatedTo != 'general' ? ($note->RelatedTo == 'client' ? 'Cliente' : ($note->RelatedTo == 'lead' ? 'Lead' : ($note->RelatedTo == 'project' ? 'Proyecto' : 'Venta'))) : '' }}</label>
                    <div class="relative">
                        <input type="number" name="RelatedID" id="RelatedID" value="{{ old('RelatedID', $note->RelatedID) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <a href="#" id="searchEntityBtn" class="text-blue-600 hover:text-blue-800" title="Buscar">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <p class="mt-1 text-sm text-gray-500">Introduce el ID del elemento relacionado</p>
                </div>
            </div>
            
            <!-- Información de creación (solo lectura) -->
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6">
                <h3 class="text-sm font-medium text-gray-700 mb-2">Información adicional</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-600">Creado por: <span class="font-medium text-gray-800">{{ $note->creator ? $note->creator->Name : 'Usuario' }}</span></p>
                    </div>
                    <div>
                        <p class="text-gray-600">Fecha de creación: <span class="font-medium text-gray-800">{{ $note->created_at->format('d/m/Y H:i') }}</span></p>
                    </div>
                </div>
            </div>
            
            <!-- Botones de acción -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('notes.show', $note->idNote) }}" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Cancelar
                </a>
                <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Actualizar Nota
                </button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const relatedToSelect = document.getElementById('RelatedTo');
        const relatedIdContainer = document.getElementById('relatedIdContainer');
        const relatedIdInput = document.getElementById('RelatedID');
        const searchEntityBtn = document.getElementById('searchEntityBtn');
        
        // Función para actualizar la visibilidad del campo de ID relacionado
        function updateRelatedIdVisibility() {
            if (relatedToSelect.value === 'general') {
                relatedIdContainer.style.display = 'none';
                relatedIdInput.value = '';
                relatedIdInput.required = false;
            } else {
                relatedIdContainer.style.display = '';
                relatedIdInput.required = true;
                
                // Actualizar el texto de la etiqueta según el tipo seleccionado
                const labelText = {
                    'client': 'Cliente',
                    'lead': 'Lead',
                    'project': 'Proyecto',
                    'sale': 'Venta'
                }[relatedToSelect.value] || '';
                
                const label = document.querySelector('label[for="RelatedID"]');
                label.textContent = 'ID del ' + labelText;
            }
        }
        
        // Evento al cambiar el tipo de relación
        relatedToSelect.addEventListener('change', updateRelatedIdVisibility);
        
        // Configurar botón de búsqueda
        searchEntityBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            const entityType = relatedToSelect.value;
            if (entityType === 'general') return;
            
            // URLs para búsqueda de entidades
            const searchUrls = {
                'client': '/clientes',
                'lead': '/leads',
                'project': '/proyectos',
                'sale': '/ventas/propuestas'
            };
            
            const url = searchUrls[entityType];
            if (url) {
                // Abrir en una nueva ventana/pestaña para seleccionar la entidad
                window.open(url, '_blank');
            }
        });
        
        // Inicializar el estado del campo de ID relacionado
        updateRelatedIdVisibility();
    });
</script>
@endsection 