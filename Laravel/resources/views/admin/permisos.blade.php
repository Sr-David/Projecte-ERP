@extends('layouts.app')

@section('title', 'Gestión de Usuarios')

@section('header', 'Gestión de Usuarios')
@section('breadcrumb', 'Administración / Gestión de Usuarios')

@section('styles')
<style>
    /* Estilos modernos para gestión de usuarios */
    .panel-container {
        @apply max-w-7xl mx-auto bg-white rounded-xl shadow-sm overflow-hidden;
        transition: all 0.3s ease;
    }
    
    .panel-container:hover {
        @apply shadow-md;
    }

    .panel-header {
        @apply px-8 py-6 bg-gradient-to-r from-blue-500 to-indigo-600 flex justify-between items-center;
    }

    .panel-header h2 {
        @apply text-xl font-bold text-white;
    }

    .panel-body {
        @apply p-6;
    }

    .panel-footer {
        @apply px-8 py-4 bg-gray-50 border-t border-gray-200;
    }

    .user-select {
        @apply w-full bg-white border border-gray-300 rounded-lg px-4 py-3 pr-8 shadow-sm text-base;
        transition: all 0.2s ease;
    }
    
    .user-select:hover {
        @apply border-blue-500;
    }
    
    .user-select:focus {
        @apply ring-4 ring-blue-200 border-blue-500 outline-none;
    }

    .permission-container {
        @apply mt-8 grid grid-cols-1 lg:grid-cols-3 gap-6;
    }

    .permission-card {
        @apply bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden h-full;
        transition: all 0.2s ease;
    }
    
    .permission-card:hover {
        @apply shadow-md border-gray-200;
        transform: translateY(-2px);
    }

    .permission-card-header {
        @apply px-4 py-3 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200 flex items-center;
    }

    .permission-card-header h3 {
        @apply text-base font-medium text-gray-800;
    }

    .permission-card-icon {
        @apply flex-shrink-0 h-6 w-6 rounded-full bg-blue-100 flex items-center justify-center mr-3;
    }
    
    .permission-card-icon svg {
        @apply h-4 w-4 text-blue-600;
    }

    .permission-card-body {
        @apply p-4 space-y-3;
    }

    .permission-item {
        @apply flex items-center p-2 rounded-md hover:bg-gray-50 transition-colors duration-150;
    }

    .permission-label {
        @apply ml-2 text-sm font-medium text-gray-700;
    }

    .permission-checkbox {
        @apply h-5 w-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500;
        transition: all 0.15s ease;
    }
    
    .btn-save {
        @apply inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500;
        transition: all 0.2s ease;
    }
    
    .btn-save:hover {
        transform: translateY(-1px);
        @apply shadow;
    }
    
    .btn-save:active {
        transform: translateY(1px);
    }
    
    .select-all-container {
        @apply bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg flex items-start;
    }
    
    .select-all-icon {
        @apply flex-shrink-0 h-4 w-4 text-blue-400;
    }
    
    .alert {
        @apply p-4 rounded-lg border-l-4 mb-6 flex items-start animate__animated animate__fadeIn;
    }
    
    .alert-success {
        @apply bg-green-50 border-green-500;
    }
    
    .alert-danger {
        @apply bg-red-50 border-red-500;
    }
    
    .alert-icon {
        @apply flex-shrink-0 h-5 w-5 mr-3;
    }
    
    .alert-success .alert-icon {
        @apply text-green-500;
    }
    
    .alert-danger .alert-icon {
        @apply text-red-500;
    }
    
    .module-section {
        @apply mb-8 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden;
    }
    
    .module-section-header {
        @apply px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100;
    }
    
    .module-section-body {
        @apply p-5;
    }
    
    /* Animaciones */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .animate-fade-in {
        animation: fadeIn 0.3s ease forwards;
    }
    
    .permissions-grid {
        @apply grid grid-cols-5 gap-4;
    }
    
    .permissions-header {
        @apply py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center;
    }
    
    .permissions-row {
        @apply border-t border-gray-100 py-2;
    }
    
    .permissions-row-item {
        @apply flex items-center justify-center py-1;
    }
    
    .permissions-module {
        @apply text-sm font-medium text-gray-700 px-2;
    }

    /* Asegurar visibilidad de toggles */
    .permission-toggle {
        position: relative;
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 6px 0;
    }

    .permission-label {
        font-size: 14px;
        font-weight: 500;
        color: #374151;
    }

    /* Estilos de toggle muy visibles */
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 30px;
        background-color: #d1d5db;
        border-radius: 34px;
        cursor: pointer;
        transition: background-color 0.4s;
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
        border: 1px solid #c4c8cc;
    }
    
    .switch.checked {
        background-color: #4f46e5;
        border-color: #4338ca;
    }
    
    .switch-dot {
        position: absolute;
        left: 4px;
        top: 4px;
        width: 22px;
        height: 22px;
        background-color: white;
        border-radius: 50%;
        transition: 0.4s;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    
    .switch.checked .switch-dot {
        transform: translateX(30px);
    }
    
    .module-row {
        @apply py-5 border-b border-gray-100;
    }
    
    .module-title {
        @apply text-lg font-medium text-gray-800 mb-1 flex items-center;
    }
    
    .module-subtitle {
        @apply text-xs text-gray-500 italic mb-4;
    }
    
    .permissions-wrapper {
        @apply flex flex-wrap gap-6 mt-2;
    }
    
    .permission-toggle {
        @apply flex items-center gap-3 py-1;
    }
    
    .permission-label {
        @apply text-sm font-medium text-gray-700;
    }
    
    /* Animaciones para switches */
    @keyframes switchPulse {
        0% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.5); }
        70% { box-shadow: 0 0 0 5px rgba(59, 130, 246, 0); }
        100% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0); }
    }
    
    .switch-pulse {
        animation: switchPulse 1s;
    }

    .switch.partially-checked {
        @apply bg-blue-400;
    }

    .permissions-row-item .switch {
        @apply z-0;
    }

    .permission-item .switch {
        @apply z-0;
    }

    /* Ensure toggles are properly visible */
    .switch::before {
        content: none;
    }
</style>
@endsection

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Banner informativo -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 py-6 mb-8 rounded-xl shadow-lg border border-blue-700 animate__animated animate__fadeIn">
        <div class="container mx-auto px-6">
            <h2 class="text-2xl font-bold text-white mb-2 text-center">Gestión de Permisos de Usuario</h2>
            <p class="text-blue-100 text-center">Configura los permisos por módulo para cada usuario del sistema</p>
        </div>
    </div>

    <!-- Mensajes de alerta -->
    <div id="alertContainer" class="hidden"></div>

    <!-- Panel principal -->
    <div class="panel-container animate-fade-in">
        <!-- Selección de usuario -->
        <div class="panel-header">
            <h2>Seleccionar Usuario</h2>
        </div>
        
        <div class="panel-body">
            @if(count($users) > 0)
                <div class="flex flex-col md:flex-row items-center">
                    <label for="userSelect" class="mb-2 md:mb-0 md:mr-4 block text-base font-medium text-gray-700">Usuario:</label>
                    <div class="w-full md:w-1/2 relative">
                        <select id="userSelect" class="user-select">
                            <option value="">Selecciona un usuario para gestionar sus permisos</option>
                            @foreach($users as $user)
                                <option value="{{ $user->idUser }}" data-permisos="{{ json_encode($user->permisos) }}">
                                    {{ $user->Name }} ({{ $user->Username }})
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            @else
                <div class="py-12 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">No hay usuarios registrados</h3>
                    <p class="mt-1 text-base text-gray-500">Crea usuarios en la sección de Configuración del Sistema primero</p>
                    <div class="mt-6">
                        <a href="{{ route('sistema') }}" class="btn-save">
                            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Ir a Configuración del Sistema
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Configuración de permisos (visible solo cuando se selecciona un usuario) -->
    <div id="permisosContainer" class="hidden mt-8 animate-fade-in">
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-indigo-500 to-indigo-600 flex flex-col md:flex-row md:justify-between md:items-center">
                <div class="flex items-center mb-4 md:mb-0">
                    <div class="h-10 w-10 rounded-full bg-indigo-200 flex items-center justify-center mr-3 text-indigo-700 font-bold text-lg">
                        <span id="userInitials"></span>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-white">Permisos de <span id="selectedUserName" class="font-extrabold"></span></h2>
                        <p class="mt-1 text-indigo-100 text-xs">Configura los permisos para este usuario</p>
                    </div>
                </div>
                <button id="btnSavePermisos" class="flex items-center px-4 py-2 border border-indigo-300 bg-indigo-700 rounded-md text-white text-sm font-medium hover:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    Guardar Cambios
                </button>
            </div>
            
            <div class="p-6">
                <!-- Seleccionar Todos -->
                <div class="bg-blue-50 rounded-lg p-3 mb-6 border border-blue-200">
                        <div class="flex items-center">
                        <label class="switch" id="selectAllSwitch" role="switch" aria-checked="false" tabindex="0">
                                <span class="switch-dot"></span>
                        </label>
                        <div class="ml-3">
                            <span class="text-sm font-medium text-blue-800">Seleccionar todos los permisos</span>
                            <p class="text-xs text-blue-600 mt-0.5">Esta opción seleccionará o deseleccionará todos los permisos para todos los módulos.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Módulos y Permisos - Nuevo diseño -->
                <div class="mt-8 bg-white rounded-lg border border-gray-200 divide-y divide-gray-100">
                    @foreach($modulos as $key => $nombre)
                    <div class="module-row px-5" data-modulo="{{ $key }}">
                        <div class="module-title">
                            {{ $nombre }}
                        </div>
                        <div class="permissions-wrapper">
                            <!-- Ver -->
                            <div class="permission-toggle">
                                <label class="switch" data-modulo="{{ $key }}" data-permiso="ver" data-input-id="{{ $key }}_ver" role="switch" aria-checked="false" tabindex="0">
                                                    <input type="checkbox" id="{{ $key }}_ver" class="hidden">
                                                    <span class="switch-dot"></span>
                                </label>
                                <span class="permission-label">Ver</span>
                                                </div>
                            
                            <!-- Crear -->
                            <div class="permission-toggle">
                                <label class="switch" data-modulo="{{ $key }}" data-permiso="crear" data-input-id="{{ $key }}_crear" role="switch" aria-checked="false" tabindex="0">
                                                    <input type="checkbox" id="{{ $key }}_crear" class="hidden">
                                                    <span class="switch-dot"></span>
                                </label>
                                <span class="permission-label">Crear</span>
                                                </div>
                            
                            <!-- Editar -->
                            <div class="permission-toggle">
                                <label class="switch" data-modulo="{{ $key }}" data-permiso="editar" data-input-id="{{ $key }}_editar" role="switch" aria-checked="false" tabindex="0">
                                                    <input type="checkbox" id="{{ $key }}_editar" class="hidden">
                                                    <span class="switch-dot"></span>
                                </label>
                                <span class="permission-label">Editar</span>
                                                </div>
                            
                            <!-- Eliminar -->
                            <div class="permission-toggle">
                                <label class="switch" data-modulo="{{ $key }}" data-permiso="borrar" data-input-id="{{ $key }}_borrar" role="switch" aria-checked="false" tabindex="0">
                                                    <input type="checkbox" id="{{ $key }}_borrar" class="hidden">
                                                    <span class="switch-dot"></span>
                                </label>
                                <span class="permission-label">Eliminar</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                    <!-- Módulos especiales -->
                    <div class="module-row px-5" data-modulo="reportes">
                        <div class="module-title">
                            Reportes
                            <span class="module-subtitle ml-2">(informes)</span>
                                </div>
                        <div class="permissions-wrapper">
                            <div class="permission-toggle">
                                <label class="switch" data-input-id="reportes_ver" role="switch" aria-checked="false" tabindex="0">
                                        <input id="reportes_ver" name="reportes[ver]" type="checkbox" class="hidden">
                                        <span class="switch-dot"></span>
                                </label>
                                <span class="permission-label">Ver</span>
                                </div>
                            </div>
                        </div>

                    <div class="module-row px-5" data-modulo="notas">
                        <div class="module-title">
                            Notas
                                </div>
                        <div class="permissions-wrapper">
                            <div class="permission-toggle">
                                <label class="switch" data-input-id="notas_ver" role="switch" aria-checked="false" tabindex="0">
                                    <input id="notas_ver" name="notas[ver]" type="checkbox" class="hidden">
                                    <span class="switch-dot"></span>
                                </label>
                                <span class="permission-label">Ver</span>
                            </div>
                            <div class="permission-toggle">
                                <label class="switch" data-input-id="notas_crear" role="switch" aria-checked="false" tabindex="0">
                                        <input id="notas_crear" name="notas[crear]" type="checkbox" class="hidden">
                                        <span class="switch-dot"></span>
                                </label>
                                <span class="permission-label">Crear</span>
                                    </div>
                            <div class="permission-toggle">
                                <label class="switch" data-input-id="notas_editar" role="switch" aria-checked="false" tabindex="0">
                                        <input id="notas_editar" name="notas[editar]" type="checkbox" class="hidden">
                                        <span class="switch-dot"></span>
                                </label>
                                <span class="permission-label">Editar</span>
                                    </div>
                            <div class="permission-toggle">
                                <label class="switch" data-input-id="notas_borrar" role="switch" aria-checked="false" tabindex="0">
                                        <input id="notas_borrar" name="notas[borrar]" type="checkbox" class="hidden">
                                        <span class="switch-dot"></span>
                                </label>
                                <span class="permission-label">Eliminar</span>
                                </div>
                            </div>
                        </div>

                    <div class="module-row px-5" data-modulo="sistema">
                        <div class="module-title">
                            Configuración
                            <span class="module-subtitle ml-2">(sistema)</span>
                                </div>
                        <div class="permissions-wrapper">
                            <div class="permission-toggle">
                                <label class="switch" data-input-id="sistema_ver" role="switch" aria-checked="false" tabindex="0">
                                        <input id="sistema_ver" name="sistema[ver]" type="checkbox" class="hidden">
                                        <span class="switch-dot"></span>
                                </label>
                                <span class="permission-label">Ver</span>
                            </div>
                        </div>
                    </div>
                </div>
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
        const selectAllSwitch = document.getElementById('selectAllSwitch');
        const alertContainer = document.getElementById('alertContainer');
        
        // Inicializar todos los switches
        document.querySelectorAll('.switch').forEach(switchEl => {
            switchEl.addEventListener('click', function() {
                const inputId = this.getAttribute('data-input-id');
                const inputEl = document.getElementById(inputId);
                
                if (inputEl) {
                    inputEl.checked = !inputEl.checked;
                    this.setAttribute('aria-checked', inputEl.checked);
                    
                    if (inputEl.checked) {
                        this.classList.add('checked', 'switch-pulse');
                    } else {
                        this.classList.remove('checked');
                    }
                    
                    setTimeout(() => {
                        this.classList.remove('switch-pulse');
                    }, 1000);
                    
                    if (inputId !== 'selectAllSwitch') {
                        actualizarSelectAll();
                    }
                } else {
                    // Para el switch "Seleccionar todos"
                    const isChecked = this.classList.contains('checked');
                    toggleAllSwitches(!isChecked);
                }
            });
            
            // Accesibilidad con teclado
            switchEl.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    this.click();
                }
            });
        });
        
        // Funciones de ayuda
        function showAlert(message, type = 'success') {
            const alertClass = type === 'success' ? 'app-alert-success' : 
                               type === 'warning' ? 'app-alert-warning' : 
                               type === 'info' ? 'app-alert-info' : 'app-alert-error';
            
            const iconPath = type === 'success' ? 
                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />' : 
                type === 'info' ?
                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />' :
                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />';
                
            alertContainer.innerHTML = `
                <div class="app-alert ${alertClass}" role="alert">
                    <svg class="app-alert-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        ${iconPath}
                    </svg>
                    <span>${message}</span>
                </div>
            `;
            alertContainer.classList.remove('hidden');
            
            // Ocultar después de 5 segundos
            setTimeout(() => {
                alertContainer.classList.add('hidden');
            }, 5000);
        }
        
        function cargarPermisos(permisos) {
            // Resetear todos los switches
            document.querySelectorAll('.switch[data-input-id]:not(#selectAllSwitch)').forEach(switchEl => {
                const inputId = switchEl.getAttribute('data-input-id');
                const inputEl = document.getElementById(inputId);
                if (inputEl) {
                    inputEl.checked = false;
                }
                switchEl.classList.remove('checked');
                switchEl.setAttribute('aria-checked', 'false');
            });
            
            // Si no hay permisos, salir
            if (!permisos) return;
            
            // Marcar los switches según los permisos
            for (const [modulo, acciones] of Object.entries(permisos)) {
                for (const [accion, permitido] of Object.entries(acciones)) {
                    const inputEl = document.getElementById(`${modulo}_${accion}`);
                    const switchEl = document.querySelector(`.switch[data-input-id="${modulo}_${accion}"]`);
                    
                    if (inputEl && switchEl) {
                        inputEl.checked = permitido;
                        if (permitido) {
                            switchEl.classList.add('checked');
                            switchEl.setAttribute('aria-checked', 'true');
                        } else {
                            switchEl.classList.remove('checked');
                            switchEl.setAttribute('aria-checked', 'false');
                        }
                    }
                }
            }
            
            // Actualizar el switch "Seleccionar todos"
            actualizarSelectAll();
        }
        
        function actualizarSelectAll() {
            const inputElements = document.querySelectorAll('input[type="checkbox"]:not(#selectAllSwitch)');
            const totalInputs = inputElements.length;
            const checkedInputs = document.querySelectorAll('input[type="checkbox"]:checked:not(#selectAllSwitch)').length;
            
            if (totalInputs > 0 && totalInputs === checkedInputs) {
                selectAllSwitch.classList.add('checked');
                selectAllSwitch.setAttribute('aria-checked', 'true');
            } else {
                selectAllSwitch.classList.remove('checked');
                selectAllSwitch.setAttribute('aria-checked', 'false');
            }
            
            // Añadir clase para indicar estado parcial (algunos seleccionados)
            if (checkedInputs > 0 && checkedInputs < totalInputs) {
                selectAllSwitch.classList.add('partially-checked');
            } else {
                selectAllSwitch.classList.remove('partially-checked');
            }
        }
        
        function toggleAllSwitches(checked) {
            document.querySelectorAll('.switch[data-input-id]:not(#selectAllSwitch)').forEach((switchEl, index) => {
                setTimeout(() => {
                    const inputId = switchEl.getAttribute('data-input-id');
                    const inputEl = document.getElementById(inputId);
                    
                    if (inputEl) {
                        inputEl.checked = checked;
                        
                        if (checked) {
                            switchEl.classList.add('checked');
                        } else {
                            switchEl.classList.remove('checked');
                        }
                        
                        switchEl.setAttribute('aria-checked', checked);
                        
                        // Efecto visual
                        switchEl.classList.add('switch-pulse');
                        setTimeout(() => {
                            switchEl.classList.remove('switch-pulse');
                        }, 1000);
                    }
                }, index * 30); // Efecto cascada
            });
            
            // Actualizar el estado del switch principal
            if (checked) {
                selectAllSwitch.classList.add('checked');
                selectAllSwitch.setAttribute('aria-checked', 'true');
            } else {
                selectAllSwitch.classList.remove('checked');
                selectAllSwitch.setAttribute('aria-checked', 'false');
            }
        }
        
        function obtenerPermisosActuales() {
            const permisos = {};
            
            // Obtener permisos de los inputs hidden (que están asociados a los switches)
            document.querySelectorAll('input[type="checkbox"][id]').forEach(input => {
                const id = input.id;
                
                // Ignorar el selectAllSwitch
                if (id === 'selectAllSwitch') return;
                
                // Formato esperado: modulo_accion
                const [modulo, accion] = id.split('_');
                
                if (modulo && accion) {
                    if (!permisos[modulo]) {
                        permisos[modulo] = {};
                    }
                    
                    permisos[modulo][accion] = input.checked;
                }
            });
            
            return permisos;
        }
        
        // Event Listeners con efectos visuales mejorados
        userSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const userId = this.value;
            
            if (userId) {
                // Mostrar el contenedor de permisos
                permisosContainer.classList.remove('hidden');
                const userName = selectedOption.textContent.trim();
                selectedUserName.textContent = userName;
                
                // Generar iniciales para el avatar
                const userInitials = document.getElementById('userInitials');
                const nameParts = userName.split(' ');
                if (nameParts.length > 0) {
                    // Tomar la primera letra del nombre y la primera del apellido si existe
                    const firstInitial = nameParts[0].charAt(0);
                    const secondInitial = nameParts.length > 1 ? nameParts[1].charAt(0) : '';
                    userInitials.textContent = (firstInitial + secondInitial).toUpperCase();
                }
                
                // Animación de aparición
                setTimeout(() => {
                    permisosContainer.style.opacity = '1';
                    permisosContainer.style.transform = 'translateY(0)';
                }, 10);
                
                // Cargar permisos del usuario seleccionado
                const permisos = JSON.parse(selectedOption.getAttribute('data-permisos') || '{}');
                cargarPermisos(permisos);
                
                // Hacer scroll suave hacia los permisos
                setTimeout(() => {
                    permisosContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }, 100);
            } else {
                // Ocultar el contenedor de permisos con animación
                permisosContainer.style.opacity = '0';
                permisosContainer.style.transform = 'translateY(10px)';
                
                setTimeout(() => {
                    permisosContainer.classList.add('hidden');
                }, 300);
            }
        });
        
        // Guardar permisos con feedback visual mejorado
        function guardarPermisos() {
            const userId = userSelect.value;
            
            if (!userId) {
                showAlert('Por favor, selecciona un usuario', 'error');
                userSelect.focus();
                userSelect.classList.add('border-red-500', 'ring-4', 'ring-red-200');
                setTimeout(() => {
                    userSelect.classList.remove('border-red-500', 'ring-4', 'ring-red-200');
                }, 2000);
                return;
            }
            
            const permisos = obtenerPermisosActuales();
            const button = this;
            const originalText = button.innerHTML;
            
            // Mostrar estado de carga
            button.disabled = true;
            button.innerHTML = 'Guardando...';
            
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
                    // Actualizar los permisos en el select
                    const selectedOption = userSelect.options[userSelect.selectedIndex];
                    selectedOption.setAttribute('data-permisos', JSON.stringify(permisos));
                    
                    // Mostrar mensaje de éxito con animación
                    showAlert('¡Permisos guardados correctamente! Los cambios han sido aplicados.', 'success');
                    
                    // Efecto visual de éxito
                    permisosContainer.classList.add('border-green-500');
                    setTimeout(() => {
                        permisosContainer.classList.remove('border-green-500');
                    }, 1000);
                } else {
                    showAlert(data.message || 'Error al guardar permisos', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Ha ocurrido un error al guardar los permisos', 'error');
            })
            .finally(() => {
                // Restaurar botón
                button.disabled = false;
                button.innerHTML = originalText;
            });
        }
        
        btnSavePermisos.addEventListener('click', guardarPermisos);
    });
</script>
@endsection 