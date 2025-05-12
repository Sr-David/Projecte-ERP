<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Acceso Administrador | Sistema ERP-CRM</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- CDN para Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Configuración de Tailwind -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            blue: '#3F95FF',
                            dark: '#1A1A1A',
                        },
                    },
                    fontFamily: {
                        'sans': ['Poppins', 'sans-serif'],
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'shimmer': 'shimmer 2s linear infinite',
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'slide-up': 'slideUp 0.6s ease-out',
                        'slide-right': 'slideRight 0.6s ease-out',
                        'fade-in': 'fadeIn 0.8s ease-out',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' },
                        },
                        shimmer: {
                            '0%': { backgroundPosition: '-40rem 0' },
                            '100%': { backgroundPosition: '40rem 0' },
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(20px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                        slideRight: {
                            '0%': { transform: 'translateX(-20px)', opacity: '0' },
                            '100%': { transform: 'translateX(0)', opacity: '1' },
                        },
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                    },
                },
            },
        };
    </script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        * {
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #ffffff;
        }
        
        .shimmer {
            background: linear-gradient(90deg, 
                rgba(255, 255, 255, 0) 0%, 
                rgba(255, 255, 255, 0.8) 50%, 
                rgba(255, 255, 255, 0) 100%);
            background-size: 40rem 100%;
            background-repeat: no-repeat;
            background-position: -40rem 0;
        }
        
        .input-effect {
            position: relative;
        }
        
        .input-effect input {
            border: none;
            border-bottom: 2px solid #e5e7eb;
            transition: all 0.3s ease;
            box-shadow: none !important;
        }
        
        .input-effect input:focus {
            border-bottom: 2px solid #3F95FF;
            box-shadow: none !important;
        }
        
        .input-effect label {
            position: absolute;
            top: 50%;
            left: 0;
            transform: translateY(-50%);
            pointer-events: none;
            transition: all 0.3s ease;
        }
        
        .input-effect input:focus + label,
        .input-effect input:not(:placeholder-shown) + label {
            top: -5px;
            font-size: 0.75rem;
            color: #3F95FF;
        }
        
        .input-effect input::placeholder {
            opacity: 0;
            transition: opacity 0.3s;
        }
        
        .input-effect input:focus::placeholder {
            opacity: 0.5;
        }
        
        .geometric-bg {
            background-image: 
                radial-gradient(#3F95FF20 1px, transparent 1px),
                radial-gradient(#3F95FF10 1px, transparent 1px);
            background-size: 40px 40px;
            background-position: 0 0, 20px 20px;
        }
        
        .button-effect {
            position: relative;
            overflow: hidden;
        }
        
        .button-effect:after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.5s, height 0.5s;
        }
        
        .button-effect:hover:after {
            width: 400px;
            height: 400px;
        }
        
        .blob-animation {
            position: absolute;
            width: 400px;
            height: 400px;
            background: #3F95FF;
            border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%;
            overflow: hidden;
            filter: blur(40px);
            opacity: 0.15;
            animation: blobAnimation 15s ease-in-out infinite;
        }
        
        @keyframes blobAnimation {
            0% { border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%; }
            25% { border-radius: 70% 30% 50% 50% / 30% 60% 70% 40%; }
            50% { border-radius: 50% 50% 30% 70% / 50% 60% 30% 40%; }
            75% { border-radius: 60% 40% 50% 50% / 40% 50% 60% 50%; }
            100% { border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%; }
        }
    </style>
</head>
<body class="antialiased">
    <div class="fixed top-[-200px] right-[-100px] z-0 blob-animation"></div>
    <div class="fixed bottom-[-200px] left-[-100px] z-0 blob-animation" style="animation-delay: -5s;"></div>
    
    <div class="min-h-screen flex flex-col items-center justify-center p-4 sm:p-6 lg:p-8 relative z-10 geometric-bg">
        <!-- Logo Area - Animado -->
        <div class="w-full max-w-md mb-8 animate-float">
            <div class="flex justify-center">
                <img src="/images/logoElevate.png" alt="Logo" class="w-20 h-20 object-contain" />
            </div>
            <h1 class="text-center text-2xl font-bold mt-4 text-brand-dark animate-slide-up">ERP-CRM Sistema</h1>
        </div>
        
        <!-- Login Card - Minimalista -->
        <div class="w-full max-w-md animate-fade-in">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden relative">
                <!-- Efecto shimmer decorativo -->
                <div class="absolute inset-0 shimmer animate-shimmer pointer-events-none"></div>
                
                <div class="p-8">
                    <div class="text-center mb-8 animate-slide-up" style="animation-delay: 100ms;">
                        <h2 class="text-2xl font-semibold text-brand-dark">Bienvenido</h2>
                        <p class="mt-2 text-sm text-gray-500">Accede a tu cuenta para continuar</p>
                    </div>
                    
                    <form id="login-form" action="/api/login" method="post" class="space-y-8">
                        @csrf
                        <div class="input-effect animate-slide-up" style="animation-delay: 200ms;">
                            <input
                                id="username"
                                name="username"
                                type="text"
                                required
                                class="w-full py-3 bg-transparent text-gray-800 focus:outline-none"
                                placeholder="Tu nombre de usuario"
                            />
                            <label for="username" class="text-gray-500">Usuario</label>
                        </div>
                        
                        <div class="input-effect animate-slide-up" style="animation-delay: 300ms;">
                            <input
                                id="password"
                                name="password"
                                type="password"
                                required
                                class="w-full py-3 bg-transparent text-gray-800 focus:outline-none"
                                placeholder="••••••••"
                            />
                            <label for="password" class="text-gray-500">Contraseña</label>
                        </div>
                        
                        <div class="animate-slide-up" style="animation-delay: 400ms;">
                            <button
                                type="submit"
                                id="login-button"
                                class="w-full py-3 px-4 rounded-full bg-brand-blue text-white font-medium hover:shadow-lg transition duration-300 button-effect relative overflow-hidden"
                            >
                                <span id="button-text" class="relative z-10">Iniciar sesión</span>
                                <div id="loading-spinner" class="hidden absolute inset-0 flex items-center justify-center bg-brand-blue z-20">
                                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </div>
                            </button>
                        </div>
                    </form>
                </div>
                
                <div class="pt-2 pb-4 text-center border-t border-gray-100">
                    <p class="text-xs text-gray-400 animate-pulse-slow">
                        Sistema de gestión empresarial © {{ date('Y') }}
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Elementos decorativos - Detalles minimalistas -->
        <div class="fixed top-10 left-10 w-2 h-2 bg-brand-blue rounded-full animate-pulse"></div>
        <div class="fixed top-10 right-10 w-2 h-2 bg-brand-blue rounded-full animate-pulse" style="animation-delay: 1s;"></div>
        <div class="fixed bottom-10 left-10 w-2 h-2 bg-brand-blue rounded-full animate-pulse" style="animation-delay: 2s;"></div>
        <div class="fixed bottom-10 right-10 w-2 h-2 bg-brand-blue rounded-full animate-pulse" style="animation-delay: 3s;"></div>
    </div>
    
    <!-- Script para manejar el login -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('login-form');
            const buttonText = document.getElementById('button-text');
            const loadingSpinner = document.getElementById('loading-spinner');
            
            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    // Mostrar estado de carga
                    loadingSpinner.classList.remove('hidden');
                    
                    const formData = new FormData(form);
                    const data = {
                        username: formData.get('username'),
                        password: formData.get('password'),
                        _token: formData.get('_token')
                    };
                    
                    // Enviar solicitud de login
                    fetch('/api/login', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': data._token,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(data)
                    })
                    .then(response => response.json())
                    .then(result => {
                        if (result.success) {
                            // Animación de éxito
                            loadingSpinner.innerHTML = `
                                <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            `;
                            
                            setTimeout(() => {
                                window.location.href = '/dashboard';
                            }, 800);
                        } else {
                            // Mostrar error con animación
                            loadingSpinner.classList.add('hidden');
                            
                            const errorMsg = document.createElement('div');
                            errorMsg.className = 'bg-red-50 text-red-500 p-3 rounded-lg text-sm mt-4 animate-fade-in';
                            errorMsg.textContent = result.message || 'Credenciales inválidas';
                            form.appendChild(errorMsg);
                            
                            setTimeout(() => {
                                errorMsg.classList.add('animate-fade-out');
                                setTimeout(() => {
                                    errorMsg.remove();
                                }, 500);
                            }, 4000);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        loadingSpinner.classList.add('hidden');
                        
                        const errorMsg = document.createElement('div');
                        errorMsg.className = 'bg-red-50 text-red-500 p-3 rounded-lg text-sm mt-4 animate-fade-in';
                        errorMsg.textContent = 'Error en la conexión. Inténtalo de nuevo.';
                        form.appendChild(errorMsg);
                        
                        setTimeout(() => {
                            errorMsg.classList.add('animate-fade-out');
                            setTimeout(() => {
                                errorMsg.remove();
                            }, 500);
                        }, 4000);
                    });
                });
            }
            
            // Efecto de input para los labels
            const inputs = document.querySelectorAll('.input-effect input');
            inputs.forEach(input => {
                // Comprobar si tiene valor inicial
                if (input.value) {
                    input.parentNode.querySelector('label').classList.add('active');
                }
                
                // Eventos de focus/blur
                input.addEventListener('focus', () => {
                    input.parentNode.querySelector('label').classList.add('active');
                });
                
                input.addEventListener('blur', () => {
                    if (!input.value) {
                        input.parentNode.querySelector('label').classList.remove('active');
                    }
                });
            });
        });
    </script>
</body>
</html> 