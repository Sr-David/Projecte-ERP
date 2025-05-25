@extends('layouts.app')

@section('title', 'Crear Nueva Nota')
@section('header', 'Crear Nueva Nota')
@section('breadcrumb', 'Notas / Crear')

@section('content')
    <!-- Banner -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 py-6 mb-8 rounded-xl shadow-lg border border-blue-700 animate__animated animate__fadeIn">
        <div class="container mx-auto px-6">
            <h2 class="text-2xl font-bold text-white mb-2 text-center">Crear Nueva Nota</h2>
            <p class="text-blue-100 text-center">Registra información importante para tu equipo</p>
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

        <form action="{{ route('notes.store') }}" method="POST" class="p-6">
            @csrf
            
            <!-- Título de la nota -->
            <div class="mb-6">
                <label for="Title" class="block text-sm font-medium text-gray-700 mb-1">Título <span class="text-red-600">*</span></label>
                <input type="text" name="Title" id="Title" value="{{ old('Title') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            
            <!-- Contenido de la nota -->
            <div class="mb-6">
                <label for="Content" class="block text-sm font-medium text-gray-700 mb-1">Contenido</label>
                <textarea name="Content" id="Content" rows="6" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('Content') }}</textarea>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Tipo de relación -->
                <div>
                    <label for="RelatedTo" class="block text-sm font-medium text-gray-700 mb-1">Relacionado con <span class="text-red-600">*</span></label>
                    <select name="RelatedTo" id="RelatedTo" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="general" {{ old('RelatedTo', $related) == 'general' ? 'selected' : '' }}>General (Sin relación)</option>
                        <option value="client" {{ old('RelatedTo', $related) == 'client' ? 'selected' : '' }}>Cliente</option>
                        <option value="lead" {{ old('RelatedTo', $related) == 'lead' ? 'selected' : '' }}>Lead</option>
                        <option value="project" {{ old('RelatedTo', $related) == 'project' ? 'selected' : '' }}>Proyecto</option>
                        <option value="sale" {{ old('RelatedTo', $related) == 'sale' ? 'selected' : '' }}>Venta</option>
                    </select>
                </div>
                
                <!-- Selector de entidad (reemplaza el input de ID) -->
                <div id="relatedEntityContainer" style="{{ $related == 'general' ? 'display:none;' : '' }}">
                    <label for="RelatedID" class="block text-sm font-medium text-gray-700 mb-1">
                        Seleccionar <span id="entityTypeLabel">{{ $related != 'general' ? ($related == 'client' ? 'Cliente' : ($related == 'lead' ? 'Lead' : ($related == 'project' ? 'Proyecto' : 'Venta'))) : '' }}</span>
                    </label>
                    <select name="RelatedID" id="RelatedID" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Cargando opciones...</option>
                    </select>
                    <p class="mt-1 text-sm text-gray-500">Selecciona el elemento relacionado</p>
                </div>
            </div>
            
            <!-- Botones de acción -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('notes.index') }}" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Cancelar
                </a>
                <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Guardar Nota
                </button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const relatedToSelect = document.getElementById('RelatedTo');
        const relatedEntityContainer = document.getElementById('relatedEntityContainer');
        const relatedIdSelect = document.getElementById('RelatedID');
        const entityTypeLabel = document.getElementById('entityTypeLabel');
        const csrf_token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Función para cargar las entidades relacionadas
        async function loadRelatedEntities(entityType) {
            if (entityType === 'general') {
                return;
            }
            
            // Mostrar mensaje de carga
            relatedIdSelect.innerHTML = '<option value="">Cargando...</option>';
            
            try {
                // API endpoints para cada tipo de entidad
                const endpoints = {
                    'client': '/api/clientes',
                    'lead': '/api/leads',
                    'project': '/api/proyectos',
                    'sale': '/api/ventas/propuestas'
                };
                
                // Si no tenemos un endpoint definido para este tipo, usar una estructura base
                if (!endpoints[entityType]) {
                    console.warn(`No endpoint defined for entity type: ${entityType}`);
                    relatedIdSelect.innerHTML = '<option value="">No hay opciones disponibles</option>';
                    return;
                }
                
                // Realizar la petición AJAX para obtener las entidades
                const response = await fetch(endpoints[entityType], {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf_token,
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const data = await response.json();
                
                if (data.success && data.items && data.items.length > 0) {
                    // Cada tipo de entidad puede tener diferentes propiedades para ID y nombre
                    const idField = getIdFieldForEntityType(entityType);
                    const nameField = getNameFieldForEntityType(entityType);
                    
                    // Limpiar y rellenar el select con las opciones
                    relatedIdSelect.innerHTML = '<option value="">Selecciona una opción</option>';
                    
                    data.items.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item[idField];
                        option.textContent = item[nameField];
                        relatedIdSelect.appendChild(option);
                    });
                } else {
                    relatedIdSelect.innerHTML = '<option value="">No hay opciones disponibles</option>';
                }
            } catch (error) {
                console.error('Error fetching related entities:', error);
                relatedIdSelect.innerHTML = '<option value="">Error al cargar opciones</option>';
            }
        }
        
        // Obtener el campo de ID según el tipo de entidad
        function getIdFieldForEntityType(entityType) {
            const idFields = {
                'client': 'idClient',
                'lead': 'idLead',
                'project': 'idProject',
                'sale': 'idSalesProposals'
            };
            return idFields[entityType] || 'id';
        }
        
        // Obtener el campo de nombre según el tipo de entidad
        function getNameFieldForEntityType(entityType) {
            const nameFields = {
                'client': 'Name',
                'lead': 'Name',
                'project': 'Name',
                'sale': 'Title'
            };
            return nameFields[entityType] || 'name';
        }
        
        // Función para actualizar la visibilidad y etiqueta del selector de entidades
        function updateRelatedEntityVisibility() {
            const entityType = relatedToSelect.value;
            
            if (entityType === 'general') {
                relatedEntityContainer.style.display = 'none';
                relatedIdSelect.required = false;
            } else {
                relatedEntityContainer.style.display = '';
                relatedIdSelect.required = true;
                
                // Actualizar el texto de la etiqueta según el tipo seleccionado
                const labelText = {
                    'client': 'Cliente',
                    'lead': 'Lead',
                    'project': 'Proyecto',
                    'sale': 'Venta'
                }[entityType] || '';
                
                entityTypeLabel.textContent = labelText;
                
                // Cargar las entidades relacionadas
                loadRelatedEntities(entityType);
            }
        }
        
        // Evento al cambiar el tipo de relación
        relatedToSelect.addEventListener('change', updateRelatedEntityVisibility);
        
        // Inicializar el estado del campo de entidades relacionadas
        updateRelatedEntityVisibility();
    });
</script>
@endsection 