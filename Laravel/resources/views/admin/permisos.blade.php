@extends('layouts.app')

@section('title', 'Gestión de Usuarios')

@section('header', 'Gestión de Usuarios')
@section('breadcrumb', 'Administración / Gestión de Usuarios')

@section('styles')
<style>
    .form-group {
        @apply mb-4;
    }
    .form-group label {
        @apply block text-sm font-medium text-gray-700 mb-1;
    }
    .form-input {
        @apply block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50;
    }
    .btn-primary {
        @apply bg-brand-blue hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50;
    }
    .btn-secondary {
        @apply bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50;
    }
    .card {
        @apply bg-white shadow-md rounded-lg overflow-hidden;
    }
    .card-header {
        @apply px-6 py-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center;
    }
    .card-body {
        @apply p-6;
    }
    .alert {
        @apply p-4 mb-4 rounded-md;
    }
    .alert-success {
        @apply bg-green-100 text-green-800 border border-green-200;
    }
    .alert-danger {
        @apply bg-red-100 text-red-800 border border-red-200;
    }
    .tab {
        @apply px-4 py-2 text-sm font-medium rounded-t-lg focus:outline-none transition-colors;
    }
    .tab.active {
        @apply bg-white text-brand-blue border-b-2 border-brand-blue;
    }
    .tab:not(.active) {
        @apply text-gray-500 hover:text-gray-700 hover:bg-gray-50;
    }
    .checkbox-wrapper {
        @apply inline-flex items-center;
    }
    .checkbox-wrapper input[type="checkbox"] {
        @apply h-4 w-4 text-brand-blue border-gray-300 rounded focus:ring-brand-blue mr-2;
    }
    .permission-grid {
        @apply grid grid-cols-5 gap-4 mt-2;
    }
    .permission-header {
        @apply text-xs font-semibold text-gray-500 uppercase;
    }
    .permission-row {
        @apply py-3 border-b border-gray-200;
    }
    .permission-row:last-child {
        @apply border-b-0;
    }
</style>
@endsection

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Gestión de Usuarios</h1>
        </div>
        <p class="text-gray-600 mt-1">Configura los permisos por módulo para cada usuario.</p>
    </div>

    <!-- Mensajes de alerta -->
    <div id="alertContainer" class="hidden"></div>

    <!-- Selección de usuario -->
    <div class="card mb-6">
        <div class="card-header">
            <h2 class="text-lg font-semibold text-gray-800">Seleccionar Usuario</h2>
        </div>
        <div class="card-body">
            @if(count($users) > 0)
                <div class="flex items-center">
                    <label for="userSelect" class="mr-4 text-sm font-medium text-gray-700">Usuario:</label>
                    <select id="userSelect" class="form-input max-w-md">
                        <option value="">Selecciona un usuario</option>
                        @foreach($users as $user)
                            <option value="{{ $user->idUser }}" data-permisos="{{ json_encode($user->permisos) }}">
                                {{ $user->Name }} ({{ $user->Username }})
                            </option>
                        @endforeach
                    </select>
                </div>
            @else
                <div class="py-4 text-center">
                    <p class="text-gray-500">No hay usuarios registrados</p>
                    <p class="text-gray-400 mt-1">Crea usuarios en la sección de Configuración del Sistema primero</p>
                    <a href="{{ route('sistema') }}" class="mt-4 inline-block btn-primary">
                        Ir a Configuración del Sistema
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Configuración de permisos (visible solo cuando se selecciona un usuario) -->
    <div id="permisosContainer" class="card hidden">
        <div class="card-header">
            <h2 class="text-lg font-semibold text-gray-800">Permisos para <span id="selectedUserName"></span></h2>
            <button id="btnSavePermisos" class="btn-primary flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                Guardar Cambios
            </button>
        </div>
        <div class="card-body">
            <p class="text-sm text-gray-600 mb-4">
                Configura los permisos que tendrá este usuario en cada módulo del sistema.
            </p>
            
            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                <div class="flex items-center">
                    <input type="checkbox" id="selectAllPermisos" class="h-4 w-4 text-brand-blue border-gray-300 rounded focus:ring-brand-blue mr-2">
                    <label for="selectAllPermisos" class="text-sm font-medium text-gray-700">Seleccionar todos los permisos</label>
                </div>
            </div>
            
            <div class="mb-4 border-b border-gray-200">
                <div class="permission-grid font-medium text-gray-700 pb-2">
                    <div>Módulo</div>
                    <div class="text-center permission-header">Ver</div>
                    <div class="text-center permission-header">Crear</div>
                    <div class="text-center permission-header">Editar</div>
                    <div class="text-center permission-header">Eliminar</div>
                </div>
            </div>
            
            <div id="permisosGrid">
                @foreach($modulos as $key => $nombre)
                    <div class="permission-row" data-modulo="{{ $key }}">
                        <div class="permission-grid items-center">
                            <div class="font-medium">{{ $nombre }}</div>
                            <div class="text-center">
                                <div class="checkbox-wrapper">
                                    <input type="checkbox" id="{{ $key }}_ver" data-modulo="{{ $key }}" data-permiso="ver">
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="checkbox-wrapper">
                                    <input type="checkbox" id="{{ $key }}_crear" data-modulo="{{ $key }}" data-permiso="crear">
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="checkbox-wrapper">
                                    <input type="checkbox" id="{{ $key }}_editar" data-modulo="{{ $key }}" data-permiso="editar">
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="checkbox-wrapper">
                                    <input type="checkbox" id="{{ $key }}_borrar" data-modulo="{{ $key }}" data-permiso="borrar">
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-6 text-right">
                <button id="btnSavePermisosBottom" class="btn-primary">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const csrf_token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const userSelect = document.getElementById('userSelect');
        const permisosContainer = document.getElementById('permisosContainer');
        const selectedUserName = document.getElementById('selectedUserName');
        const btnSavePermisos = document.getElementById('btnSavePermisos');
        const btnSavePermisosBottom = document.getElementById('btnSavePermisosBottom');
        const selectAllPermisos = document.getElementById('selectAllPermisos');
        const alertContainer = document.getElementById('alertContainer');
        
        // Funciones de ayuda
        function showAlert(message, type = 'success') {
            alertContainer.innerHTML = `
                <div class="alert ${type === 'success' ? 'alert-success' : 'alert-danger'}">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            ${type === 'success' 
                                ? '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />'
                                : '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />'
                            }
                        </svg>
                        <p>${message}</p>
                    </div>
                </div>
            `;
            alertContainer.classList.remove('hidden');
            
            // Ocultar después de 5 segundos
            setTimeout(() => {
                alertContainer.classList.add('hidden');
            }, 5000);
        }
        
        function cargarPermisos(permisos) {
            // Resetear todos los checkboxes
            const checkboxes = document.querySelectorAll('#permisosGrid input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            
            // Si no hay permisos, salir
            if (!permisos) return;
            
            // Marcar los checkboxes según los permisos
            for (const [modulo, acciones] of Object.entries(permisos)) {
                for (const [accion, permitido] of Object.entries(acciones)) {
                    const checkbox = document.getElementById(`${modulo}_${accion}`);
                    if (checkbox) {
                        checkbox.checked = permitido;
                    }
                }
            }
            
            // Actualizar el checkbox "Seleccionar todos"
            actualizarSelectAll();
        }
        
        function actualizarSelectAll() {
            const checkboxes = document.querySelectorAll('#permisosGrid input[type="checkbox"]');
            const totalCheckboxes = checkboxes.length;
            const checkedCheckboxes = document.querySelectorAll('#permisosGrid input[type="checkbox"]:checked').length;
            
            selectAllPermisos.checked = totalCheckboxes > 0 && totalCheckboxes === checkedCheckboxes;
            selectAllPermisos.indeterminate = checkedCheckboxes > 0 && checkedCheckboxes < totalCheckboxes;
        }
        
        function obtenerPermisosActuales() {
            const permisos = {};
            
            // Recorrer cada módulo
            document.querySelectorAll('.permission-row').forEach(row => {
                const modulo = row.getAttribute('data-modulo');
                permisos[modulo] = {};
                
                // Recorrer checkboxes del módulo
                row.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                    const permiso = checkbox.getAttribute('data-permiso');
                    permisos[modulo][permiso] = checkbox.checked;
                });
            });
            
            return permisos;
        }
        
        // Event Listeners
        userSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const userId = this.value;
            
            if (userId) {
                // Mostrar el contenedor de permisos
                permisosContainer.classList.remove('hidden');
                selectedUserName.textContent = selectedOption.textContent.trim();
                
                // Cargar permisos del usuario seleccionado
                const permisos = JSON.parse(selectedOption.getAttribute('data-permisos') || '{}');
                cargarPermisos(permisos);
            } else {
                // Ocultar el contenedor de permisos
                permisosContainer.classList.add('hidden');
            }
        });
        
        // Gestionar checkbox "Seleccionar todos"
        selectAllPermisos.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('#permisosGrid input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
        
        // Actualizar estado del checkbox "Seleccionar todos" cuando se cambia un permiso individual
        document.querySelectorAll('#permisosGrid input[type="checkbox"]').forEach(checkbox => {
            checkbox.addEventListener('change', actualizarSelectAll);
        });
        
        // Guardar permisos
        function guardarPermisos() {
            const userId = userSelect.value;
            
            if (!userId) {
                showAlert('Por favor, selecciona un usuario', 'error');
                return;
            }
            
            const permisos = obtenerPermisosActuales();
            
            fetch('/ajustes/permisos', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf_token
                },
                body: JSON.stringify({
                    user_id: userId,
                    permisos: permisos
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert(data.message);
                    
                    // Actualizar los permisos en el select
                    const selectedOption = userSelect.options[userSelect.selectedIndex];
                    selectedOption.setAttribute('data-permisos', JSON.stringify(permisos));
                } else {
                    showAlert(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Ha ocurrido un error al guardar los permisos', 'error');
            });
        }
        
        btnSavePermisos.addEventListener('click', guardarPermisos);
        btnSavePermisosBottom.addEventListener('click', guardarPermisos);
    });
</script>
@endsection 