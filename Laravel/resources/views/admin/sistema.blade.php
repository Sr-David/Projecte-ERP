@extends('layouts.app')

@section('title', 'Configuración del Sistema')

@section('header', 'Configuración del Sistema')
@section('breadcrumb', 'Administración / Configuración')

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
    .btn-danger {
        @apply bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50;
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
</style>
@endsection

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Gestión de Usuarios</h1>
            <button id="btnNewUser" class="btn-primary flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Nuevo Usuario
            </button>
        </div>
        <p class="text-gray-600 mt-1">Gestiona los usuarios que tienen acceso al sistema para tu empresa.</p>
    </div>

    <!-- Mensajes de alerta -->
    <div id="alertContainer" class="hidden"></div>

    <!-- Tabla de usuarios -->
    <div class="card">
        <div class="card-header">
            <h2 class="text-lg font-semibold text-gray-800">Usuarios Registrados</h2>
            <span class="text-sm text-gray-500">Total: {{ count($users) }}</span>
        </div>
        <div class="card-body">
            @if(count($users) > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuario</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contraseña</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($users as $user)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->idUser }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user->Name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->Username }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <span class="password-mask" data-password="{{ $user->Password }}">••••••••</span>
                                        <button class="text-blue-600 hover:text-blue-800 ml-2 toggle-password">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button class="text-blue-600 hover:text-blue-900 mr-3 btn-edit" data-id="{{ $user->idUser }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                        </button>
                                        <button class="text-red-600 hover:text-red-900 btn-delete" data-id="{{ $user->idUser }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="py-8 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <p class="text-gray-500 text-lg">No hay usuarios registrados</p>
                    <p class="text-gray-400 mt-1">Crea un nuevo usuario para que pueda acceder al sistema</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal para crear/editar usuario -->
<div id="userModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800" id="modalTitle">Nuevo Usuario</h3>
            <button id="closeModal" class="text-gray-400 hover:text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <form id="userForm">
            <div class="px-6 py-4">
                <input type="hidden" id="userId" name="id">
                
                <div class="form-group">
                    <label for="name">Nombre completo</label>
                    <input type="text" id="name" name="name" class="form-input" required>
                </div>
                
                <div class="form-group">
                    <label for="username">Nombre de usuario</label>
                    <input type="text" id="username" name="username" class="form-input" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" class="form-input" required>
                </div>
                
                <div class="flex items-center mt-2">
                    <input type="checkbox" id="showPassword" class="mr-2">
                    <label for="showPassword" class="text-sm text-gray-600">Mostrar contraseña</label>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                <button type="button" id="cancelModal" class="btn-secondary">Cancelar</button>
                <button type="submit" class="btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const csrf_token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const userModal = document.getElementById('userModal');
        const userForm = document.getElementById('userForm');
        const modalTitle = document.getElementById('modalTitle');
        const userId = document.getElementById('userId');
        const nameInput = document.getElementById('name');
        const usernameInput = document.getElementById('username');
        const passwordInput = document.getElementById('password');
        const showPasswordCheckbox = document.getElementById('showPassword');
        const alertContainer = document.getElementById('alertContainer');
        
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
        
        function resetForm() {
            userForm.reset();
            userId.value = '';
        }
        
        function openModal(title = 'Nuevo Usuario') {
            modalTitle.textContent = title;
            userModal.classList.remove('hidden');
        }
        
        function closeModal() {
            userModal.classList.add('hidden');
            resetForm();
        }
        
        // Event Listeners
        document.getElementById('btnNewUser').addEventListener('click', function() {
            resetForm();
            openModal('Nuevo Usuario');
        });
        
        document.getElementById('closeModal').addEventListener('click', closeModal);
        document.getElementById('cancelModal').addEventListener('click', closeModal);
        
        // Mostrar/ocultar contraseña
        showPasswordCheckbox.addEventListener('change', function() {
            passwordInput.type = this.checked ? 'text' : 'password';
        });
        
        // Mostrar/ocultar contraseñas en la tabla
        const togglePasswordButtons = document.querySelectorAll('.toggle-password');
        togglePasswordButtons.forEach(button => {
            button.addEventListener('click', function() {
                const passwordElement = this.previousElementSibling;
                const password = passwordElement.getAttribute('data-password');
                
                if (passwordElement.textContent === '••••••••') {
                    passwordElement.textContent = password;
                    this.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd" />
                            <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />
                        </svg>
                    `;
                } else {
                    passwordElement.textContent = '••••••••';
                    this.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                        </svg>
                    `;
                }
            });
        });
        
        // Manejar edición de usuario
        const editButtons = document.querySelectorAll('.btn-edit');
        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const row = this.closest('tr');
                const id = this.getAttribute('data-id');
                const name = row.cells[1].textContent.trim();
                const username = row.cells[2].textContent.trim();
                const password = row.querySelector('.password-mask').getAttribute('data-password');
                
                userId.value = id;
                nameInput.value = name;
                usernameInput.value = username;
                passwordInput.value = password;
                
                openModal('Editar Usuario');
            });
        });
        
        // Manejar eliminación de usuario
        const deleteButtons = document.querySelectorAll('.btn-delete');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                
                if (confirm('¿Estás seguro de que deseas eliminar este usuario? Esta acción no se puede deshacer.')) {
                    fetch(`/sistema/usuario/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrf_token
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showAlert(data.message);
                            // Recargar la página después de eliminar
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        } else {
                            showAlert(data.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showAlert('Ha ocurrido un error al procesar la solicitud', 'error');
                    });
                }
            });
        });
        
        // Manejar envío del formulario
        userForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(userForm);
            const data = Object.fromEntries(formData.entries());
            
            fetch('/sistema/usuario', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf_token
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeModal();
                    showAlert(data.message);
                    // Recargar la página después de guardar
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    let errorMessage = data.message || 'Ha ocurrido un error';
                    if (data.errors) {
                        errorMessage = Object.values(data.errors).flat().join('<br>');
                    }
                    showAlert(errorMessage, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Ha ocurrido un error al procesar la solicitud', 'error');
            });
        });
    });
</script>
@endsection 