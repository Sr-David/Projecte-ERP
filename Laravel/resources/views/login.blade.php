<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Acceso | Elevate CRM</title>
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
                        'slide-left': 'slideLeft 0.6s ease-out',
                        'fade-in': 'fadeIn 0.8s ease-out',
                        'bounce-slow': 'bounce 3s infinite',
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
                        slideLeft: {
                            '0%': { transform: 'translateX(20px)', opacity: '0' },
                            '100%': { transform: 'translateX(0)', opacity: '1' },
                        },
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                    },
                    boxShadow: {
                        'soft-xl': '0 20px 27px 0 rgba(0, 0, 0, 0.05)',
                        'inner-soft': 'inset 0 2px 4px 0 rgba(0, 0, 0, 0.06)',
                    }
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
                radial-gradient(#3F95FF10 1px, transparent 1px),
                radial-gradient(#3F95FF05 1px, transparent 1px);
            background-size: 40px 40px;
            background-position: 0 0, 20px 20px;
        }
        
        .button-effect {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
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
            opacity: 0.1;
            animation: blobAnimation 15s ease-in-out infinite;
        }
        
        @keyframes blobAnimation {
            0% { border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%; }
            25% { border-radius: 70% 30% 50% 50% / 30% 60% 70% 40%; }
            50% { border-radius: 50% 50% 30% 70% / 50% 60% 30% 40%; }
            75% { border-radius: 60% 40% 50% 50% / 40% 50% 60% 50%; }
            100% { border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%; }
        }
        
        .cta-box {
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        
        .cta-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(63, 149, 255, 0.1) 0%, rgba(63, 149, 255, 0.05) 100%);
            z-index: -1;
            border-radius: inherit;
        }
        
        .cta-effect {
            transition: all 0.3s ease;
        }
        
        .cta-effect:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(63, 149, 255, 0.2);
        }
        
        .highlight-dot {
            position: relative;
        }
        
        .highlight-dot::after {
            content: '';
            position: absolute;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background-color: #3F95FF;
            top: 50%;
            right: -12px;
            transform: translateY(-50%);
        }

        /* Estilo para los botones de tipo de usuario */
        .user-type-btn {
            @apply px-4 py-2 border rounded-md text-center cursor-pointer transition-all duration-300 w-full;
        }
    </style>
</head>
<body class="antialiased">
    <!-- Efectos de fondo -->
    <div class="fixed top-[-200px] right-[-100px] z-0 blob-animation"></div>
    <div class="fixed bottom-[-200px] left-[-100px] z-0 blob-animation" style="animation-delay: -5s;"></div>
    <div class="fixed top-[30%] left-[10%] z-0 blob-animation" style="animation-delay: -8s; width: 300px; height: 300px;"></div>
    
    <div class="min-h-screen flex flex-col md:flex-row items-center justify-center p-4 sm:p-6 lg:p-8 relative z-10 geometric-bg">
        <!-- Columna Izquierda - Logo y Mensaje -->
        <div class="w-full max-w-md mb-8 md:mb-0 md:mr-12 animate-float">
            <div class="flex justify-center md:justify-start">
                <img src="/images/logoElevate.png" alt="Logo" class="w-48 h-48 object-contain" />
            </div>
            
            <div class="hidden md:block mt-8 animate-slide-up">
                <h2 class="text-3xl font-bold text-brand-dark mb-4">Eleva tu negocio con nosotros</h2>
                <p class="text-gray-600 mb-6">Gestiona clientes, proyectos y facturación en una única plataforma diseñada para impulsar tu crecimiento.</p>
                
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-brand-blue" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <p class="text-gray-700">Interfaz intuitiva y moderna</p>
                </div>
                
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-brand-blue" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <p class="text-gray-700">Seguridad de datos avanzada</p>
                </div>
                
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-brand-blue" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <p class="text-gray-700">Soporte técnico 24/7</p>
                </div>
            </div>
        </div>
        
        <!-- Columna Derecha - Formulario de Login -->
        <div class="w-full max-w-md animate-fade-in">
            <div class="bg-white rounded-xl shadow-soft-xl overflow-hidden relative">
                <!-- Efecto shimmer decorativo -->
                <div class="absolute inset-0 shimmer animate-shimmer pointer-events-none"></div>
                
                <div class="p-8">
                    <div class="text-center mb-8 animate-slide-up" style="animation-delay: 100ms;">
                        <h2 class="text-2xl font-semibold text-brand-dark">Bienvenido</h2>
                        <p class="mt-2 text-sm text-gray-500">Accede a tu cuenta para continuar</p>
                    </div>
                    
                    <!-- Selector de tipo de usuario -->
                    <div class="mb-6 animate-slide-up" style="animation-delay: 150ms;">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de acceso</label>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="user-type-btn active bg-brand-blue text-white border-brand-blue" data-type="user">
                                <div class="flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Usuario
                                </div>
                            </div>
                            <div class="user-type-btn border-gray-300 text-gray-600 hover:bg-gray-50" data-type="admin">
                                <div class="flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    Administrador
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <form id="login-form" action="/api/login" method="post" class="space-y-8">
                        @csrf
                        <input type="hidden" id="user_type" name="user_type" value="user">
                        
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
                                onclick="console.log('Tipo de usuario al enviar:', document.getElementById('user_type').value);"
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
                
                <!-- CTA para nuevos usuarios -->
                <div class="cta-box p-6 mt-4 mb-2 mx-6 rounded-xl animate-slide-up" style="animation-delay: 500ms;">
                    <h3 class="text-base font-medium text-brand-dark mb-2 highlight-dot inline-block">¿No tienes cuenta?</h3>
                    <p class="text-sm text-gray-600 mb-4">Empieza a elevar tu negocio hoy mismo y descubre todo lo que nuestro sistema puede hacer por ti.</p>
                    <a href="#" class="inline-block text-sm px-6 py-2.5 bg-white text-brand-blue border border-brand-blue rounded-full font-medium cta-effect">
                        Solicitar acceso
                    </a>
                </div>
                
                <div class="py-3 text-center border-t border-gray-100">
                    <p class="text-xs text-gray-400 animate-pulse-slow">
                        Elevate CRM © {{ date('Y') }}
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
            const userTypeButtons = document.querySelectorAll('.user-type-btn');
            const userTypeInput = document.getElementById('user_type');
            
            // Manejar cambio de tipo de usuario
            userTypeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Quitar clases activas de todos los botones
                    userTypeButtons.forEach(btn => {
                        btn.classList.remove('active');
                        btn.classList.remove('bg-brand-blue');
                        btn.classList.remove('text-white');
                        btn.classList.remove('border-brand-blue');
                        btn.classList.add('border-gray-300');
                        btn.classList.add('text-gray-600');
                        btn.classList.add('hover:bg-gray-50');
                    });
                    
                    // Agregar clases activas al botón clickeado
                    this.classList.add('active');
                    this.classList.add('bg-brand-blue');
                    this.classList.add('text-white');
                    this.classList.add('border-brand-blue');
                    this.classList.remove('border-gray-300');
                    this.classList.remove('text-gray-600');
                    this.classList.remove('hover:bg-gray-50');
                    
                    // Actualizar valor del input hidden
                    userTypeInput.value = this.dataset.type;
                    
                    // Debug - mostrar en consola
                    console.log("Tipo de usuario seleccionado:", this.dataset.type);
                });
            });
            
            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    // Mostrar estado de carga
                    loadingSpinner.classList.remove('hidden');
                    
                    const formData = new FormData(form);
                    const data = {
                        username: formData.get('username'),
                        password: formData.get('password'),
                        user_type: formData.get('user_type'),
                        _token: formData.get('_token')
                    };
                    
                    console.log("Enviando login con:", data);
                    
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