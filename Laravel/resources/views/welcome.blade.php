<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bienvenido | Elevate CRM</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700" rel="stylesheet" />


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
                            'spin-slow': 'spin 8s linear infinite',
                            'wiggle': 'wiggle 1s ease-in-out infinite',
                            'scale': 'scale 1.5s ease-in-out infinite',
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
                            wiggle: {
                                '0%, 100%': { transform: 'rotate(-3deg)' },
                                '50%': { transform: 'rotate(3deg)' },
                            },
                            scale: {
                                '0%, 100%': { transform: 'scale(1)' },
                                '50%': { transform: 'scale(1.05)' },
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
            
            .geometric-bg {
                background-image: 
                    radial-gradient(#3F95FF10 1px, transparent 1px),
                    radial-gradient(#3F95FF05 1px, transparent 1px);
                background-size: 40px 40px;
                background-position: 0 0, 20px 20px;
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
            
            .feature-card {
                transition: all 0.3s ease;
                border: 1px solid transparent;
                position: relative;
                overflow: hidden;
            }
            
            .feature-card:hover {
                transform: translateY(-5px);
                border-color: #3F95FF20;
                box-shadow: 0 10px 25px rgba(63, 149, 255, 0.1);
            }
            
            .feature-card:hover .icon-container {
                transform: scale(1.1);
                background-color: rgba(63, 149, 255, 0.2);
            }
            
            .feature-card::before {
                content: '';
                position: absolute;
                top: -100%;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(45deg, transparent, rgba(63, 149, 255, 0.05), transparent);
                transform: rotate(45deg);
                transition: all 0.8s ease;
            }
            
            .feature-card:hover::before {
                top: 100%;
                left: 100%;
            }
            
            .icon-container {
                transition: all 0.3s ease;
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
            
            .shimmer {
                background: linear-gradient(90deg, 
                    rgba(255, 255, 255, 0) 0%, 
                    rgba(255, 255, 255, 0.8) 50%, 
                    rgba(255, 255, 255, 0) 100%);
                background-size: 40rem 100%;
                background-repeat: no-repeat;
                background-position: -40rem 0;
            }
            </style>
    </head>
<body class="antialiased geometric-bg">
    <!-- Efectos de fondo -->
    <div class="fixed top-[-200px] right-[-100px] z-0 blob-animation"></div>
    <div class="fixed bottom-[-200px] left-[-100px] z-0 blob-animation" style="animation-delay: -5s;"></div>
    <div class="fixed top-[30%] left-[10%] z-0 blob-animation" style="animation-delay: -8s; width: 300px; height: 300px;"></div>
    
    <!-- Elementos decorativos adicionales -->
    <div class="fixed top-[20%] right-[15%] w-4 h-4 rounded-full bg-brand-blue opacity-10 animate-ping" style="animation-duration: 3s;"></div>
    <div class="fixed bottom-[25%] right-[20%] w-3 h-3 rounded-full bg-brand-blue opacity-10 animate-ping" style="animation-duration: 5s;"></div>
    <div class="fixed top-[50%] left-[20%] w-2 h-2 rounded-full bg-brand-blue opacity-10 animate-ping" style="animation-duration: 4s;"></div>
    
    <div class="min-h-screen flex flex-col relative z-10">
        <!-- Barra de navegación -->
        <header class="w-full py-4 px-6 md:px-12 flex justify-between items-center">
            <div class="flex items-center justify-center w-full">
                <img src="/images/logoElevate.png" alt="Elevate CRM Logo" class="h-20 md:h-24 object-contain mx-auto">
            </div>
            
            @if (Route::has('login'))
                <nav class="hidden md:flex items-center space-x-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-4 py-2 rounded-full border border-brand-blue text-brand-blue hover:bg-brand-blue hover:text-white transition-all">Dashboard</a>
                    @else
                        <a href="{{ url('/login') }}" class="px-4 py-2 rounded-full border border-transparent hover:border-gray-200 transition-all">Iniciar sesión</a>
                        
                        <a href="{{ url('/login') }}" class="px-4 py-2 rounded-full bg-brand-blue text-white hover:shadow-lg button-effect relative overflow-hidden">
                            <span class="relative z-10">Registrarse</span>
                        </a>
                    @endauth
                </nav>
                
                <!-- Menú móvil -->
                <div class="md:hidden">
                    <button class="text-gray-700 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            @endif
        </header>
        
        <!-- Contenido principal -->
        <main class="flex-grow flex flex-col">
            <!-- Hero Section -->
            <section class="pt-12 md:pt-20 pb-24 px-6 md:px-12 flex flex-col md:flex-row items-center justify-between max-w-7xl mx-auto">
                <div class="md:w-1/2 mb-12 md:mb-0 animate-slide-right">
                    <h1 class="text-4xl md:text-5xl font-bold text-brand-dark mb-6 relative">
                        Gestiona tu negocio de forma <span class="text-brand-blue relative inline-block after:content-[''] after:absolute after:w-full after:h-1 after:bg-brand-blue/30 after:bottom-0 after:left-0">inteligente</span>
                    </h1>
                    <p class="text-lg text-gray-600 mb-8 animate-fade-in" style="animation-delay: 0.3s;">
                        Elevate CRM es la plataforma todo en uno para gestionar clientes, proyectos, facturación y mucho más. Diseñada para impulsar el crecimiento de tu empresa.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ url('/login') }}" class="group px-6 py-3 rounded-full bg-brand-blue text-white font-medium hover:shadow-lg button-effect relative overflow-hidden transition-all duration-300 hover:pl-10">
                            <span class="absolute left-0 top-0 h-full w-0 bg-white/20 transition-all duration-300 group-hover:w-10 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-0 group-hover:opacity-100 transition-opacity duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </span>
                            <span class="relative z-10">Comenzar ahora</span>
                        </a>
                        <a href="#features" class="px-6 py-3 rounded-full border border-gray-300 text-gray-700 font-medium hover:border-brand-blue hover:text-brand-blue transition-all hover:scale-105">
                            Explorar funciones
                        </a>
                    </div>
                </div>
                <div class="md:w-1/2 flex justify-center md:justify-end animate-slide-left">
                    <div class="relative w-full max-w-lg p-4 bg-white rounded-lg shadow-soft-xl">
                        <img src="/images/growing-chart.svg" alt="Gráfico de crecimiento" class="w-full h-auto rounded-lg">
                        <div class="absolute bottom-0 left-0 right-0 p-4 bg-gradient-to-t from-white to-transparent">
                            <p class="text-xs text-gray-500 text-center">Las empresas que utilizan Elevate CRM muestran un crecimiento sostenido</p>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Features Section -->
            <section id="features" class="py-16 px-6 md:px-12 bg-gray-50">
                <div class="max-w-7xl mx-auto">
                    <div class="text-center mb-16">
                        <h2 class="text-3xl font-bold text-brand-dark mb-4">Características principales</h2>
                        <p class="text-gray-600 max-w-2xl mx-auto">Descubre cómo nuestras funciones pueden transformar la forma en que gestionas tu negocio.</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <!-- Feature 1 -->
                        <div class="feature-card bg-white p-6 rounded-xl">
                            <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center mb-4 icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-brand-blue" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold mb-3 text-brand-dark">Gestión de Clientes</h3>
                            <p class="text-gray-600">Organiza y gestiona toda la información de tus clientes en un solo lugar para mejorar la relación comercial.</p>
                        </div>
                        
                        <!-- Feature 2 -->
                        <div class="feature-card bg-white p-6 rounded-xl">
                            <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center mb-4 icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-brand-blue" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold mb-3 text-brand-dark">Seguimiento de Proyectos</h3>
                            <p class="text-gray-600">Planifica, realiza seguimiento y completa proyectos eficientemente con nuestras herramientas intuitivas.</p>
                        </div>
                        
                        <!-- Feature 3 -->
                        <div class="feature-card bg-white p-6 rounded-xl">
                            <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center mb-4 icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-brand-blue" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold mb-3 text-brand-dark">Análisis y Reportes</h3>
                            <p class="text-gray-600">Obtén insights valiosos con informes detallados y gráficos interactivos sobre el rendimiento de tu negocio.</p>
                        </div>
                        
                        <!-- Feature 4 -->
                        <div class="feature-card bg-white p-6 rounded-xl">
                            <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center mb-4 icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-brand-blue" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold mb-3 text-brand-dark">Facturación y Pagos</h3>
                            <p class="text-gray-600">Automatiza tu proceso de facturación y gestión de pagos para ahorrar tiempo y reducir errores.</p>
                        </div>
                        
                        <!-- Feature 5 -->
                        <div class="feature-card bg-white p-6 rounded-xl">
                            <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center mb-4 icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-brand-blue" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold mb-3 text-brand-dark">Notificaciones</h3>
                            <p class="text-gray-600">Mantente al tanto de todo con alertas personalizables sobre nuevos clientes, tareas y pagos.</p>
                        </div>
                        
                        <!-- Feature 6 -->
                        <div class="feature-card bg-white p-6 rounded-xl">
                            <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center mb-4 icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-brand-blue" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                            </div>
                            <h3 class="text-xl font-semibold mb-3 text-brand-dark">Seguridad Avanzada</h3>
                            <p class="text-gray-600">Protege tus datos con nuestra infraestructura segura y políticas de privacidad de nivel empresarial.</p>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- CTA Section -->
            <section class="py-20 px-6 md:px-12 relative overflow-hidden">
                <div class="absolute inset-0 bg-brand-blue opacity-5"></div>
                <!-- Decoraciones de fondo para CTA -->
                <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0">
                    <div class="absolute top-5 left-[10%] w-12 h-12 rounded-full border border-brand-blue/20 animate-spin-slow"></div>
                    <div class="absolute bottom-10 right-[10%] w-16 h-16 rounded-full border-2 border-brand-blue/20 animate-spin-slow" style="animation-delay: 1s; animation-duration: 12s;"></div>
                    <div class="absolute top-1/3 right-[15%] w-8 h-8 rounded-full border border-brand-blue/20 animate-spin-slow" style="animation-delay: 0.5s; animation-duration: 7s;"></div>
                </div>
                
                <div class="max-w-5xl mx-auto relative z-10 text-center">
                    <span class="inline-block mb-3 px-4 py-1 rounded-full bg-brand-blue/10 text-brand-blue text-sm font-medium animate-pulse-slow">
                        ✨ Potencia tu negocio
                    </span>
                    <h2 class="text-3xl md:text-4xl font-bold text-brand-dark mb-6 animate-fade-in">
                        Comienza a <span class="text-brand-blue relative inline-block">elevar<span class="absolute -bottom-2 left-0 w-full h-1 bg-brand-blue/30 rounded"></span></span> tu negocio hoy
                    </h2>
                    <p class="text-lg text-gray-600 mb-10 max-w-2xl mx-auto animate-fade-in" style="animation-delay: 0.2s;">
                        Únete a miles de empresas que ya han transformado su forma de gestionar clientes y procesos con Elevate CRM.
                    </p>
                    <div class="flex flex-wrap justify-center gap-4 animate-fade-in" style="animation-delay: 0.4s;">
                        <a href="{{ url('/login') }}" class="group px-8 py-4 rounded-full bg-brand-blue text-white font-medium hover:shadow-lg relative overflow-hidden transition-all duration-300">
                            <span class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full animate-shimmer hover:animate-none"></span>
                            <span class="relative z-10 group-hover:scale-105 inline-block transition-transform duration-300">Crear cuenta gratis</span>
                        </a>
                        <a href="{{ url('/login') }}" class="group px-8 py-4 rounded-full border border-gray-300 text-gray-700 font-medium hover:border-brand-blue hover:text-brand-blue transition-all">
                            <span class="relative z-10 group-hover:translate-x-1 inline-block transition-transform duration-300">Iniciar sesión</span>
                        </a>
                    </div>
                </div>
            </section>
        </main>
        
        <!-- Footer -->
        <footer class="bg-gray-50 py-12 px-6 md:px-12">
            <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="md:col-span-1">
                    <img src="/images/logoElevate.png" alt="Elevate CRM Logo" class="h-20 object-contain mb-4">
                    <p class="text-gray-600 text-sm">Elevando tu negocio al siguiente nivel con soluciones inteligentes de gestión.</p>
                </div>
                
                <div>
                    <h3 class="font-semibold text-brand-dark mb-4">Producto</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="text-gray-600 hover:text-brand-blue">Características</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-brand-blue">Precios</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-brand-blue">Integraciones</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-brand-blue">Actualizaciones</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="font-semibold text-brand-dark mb-4">Soporte</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="text-gray-600 hover:text-brand-blue">Centro de ayuda</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-brand-blue">Documentación</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-brand-blue">Guías</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-brand-blue">Contacto</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="font-semibold text-brand-dark mb-4">Empresa</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="text-gray-600 hover:text-brand-blue">Sobre nosotros</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-brand-blue">Blog</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-brand-blue">Carreras</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-brand-blue">Prensa</a></li>
                    </ul>
                </div>
        </div>

            <div class="max-w-7xl mx-auto pt-8 mt-8 border-t border-gray-200">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-gray-600 text-sm">© {{ date('Y') }} Elevate CRM. Todos los derechos reservados.</p>
                    <div class="flex space-x-6 mt-4 md:mt-0">
                        <a href="#" class="text-gray-600 hover:text-brand-blue">
                            <span class="sr-only">Facebook</span>
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-600 hover:text-brand-blue">
                            <span class="sr-only">Instagram</span>
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-600 hover:text-brand-blue">
                            <span class="sr-only">Twitter</span>
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-600 hover:text-brand-blue">
                            <span class="sr-only">LinkedIn</span>
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M4.98 3.5c0 1.381-1.11 2.5-2.48 2.5s-2.48-1.119-2.48-2.5c0-1.38 1.11-2.5 2.48-2.5s2.48 1.12 2.48 2.5zm.02 4.5h-5v16h5v-16zm7.982 0h-4.968v16h4.969v-8.399c0-4.67 6.029-5.052 6.029 0v8.399h4.988v-10.131c0-7.88-8.922-7.593-11.018-3.714v-2.155z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    </body>
</html>
