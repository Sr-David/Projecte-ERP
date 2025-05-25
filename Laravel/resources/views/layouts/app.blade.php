<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Elevate CRM') | Sistema ERP-CRM</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Tailwind CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    
    <!-- Animation Library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <style>
        /* Base Styles */
        body {
            font-family: 'Poppins', sans-serif;
        }

        /* Custom Colors */
        .bg-brand-blue {
            background-color: #3F95FF;
        }

        .text-brand-blue {
            color: #3F95FF;
        }

        .border-brand-blue {
            border-color: #3F95FF;
        }

        /* Custom Shadows */
        .shadow-card {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        /* Sidebar Active Link */
        .sidebar-active {
            background-color: rgba(63, 149, 255, 0.1);
            color: #3F95FF;
            border-left: 3px solid #3F95FF;
        }

        /* Animations */
        @keyframes pulse-light {

            0%,
            100% {
                opacity: 0.8;
            }

            50% {
                opacity: 1;
            }
        }

        .animate-pulse-light {
            animation: pulse-light 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        /* Page Transition Animation */
        .page-transition-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(5px);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        .page-transition-overlay.active {
            opacity: 1;
            pointer-events: auto;
        }

        .bars-container {
            display: flex;
            align-items: flex-end;
            height: 100px;
            gap: 5px;
        }

        .bar {
            width: 10px;
            background-color: #3F95FF;
            border-radius: 3px;
            transform-origin: bottom;
        }

        @keyframes barAnimation {
            0% { height: 20px; }
            50% { height: 100px; }
            100% { height: 20px; }
        }

        .bar:nth-child(1) { animation: barAnimation 1.2s ease-in-out 0s infinite; }
        .bar:nth-child(2) { animation: barAnimation 1.2s ease-in-out 0.1s infinite; }
        .bar:nth-child(3) { animation: barAnimation 1.2s ease-in-out 0.2s infinite; }
        .bar:nth-child(4) { animation: barAnimation 1.2s ease-in-out 0.3s infinite; }
        .bar:nth-child(5) { animation: barAnimation 1.2s ease-in-out 0.4s infinite; }
        .bar:nth-child(6) { animation: barAnimation 1.2s ease-in-out 0.3s infinite; }
        .bar:nth-child(7) { animation: barAnimation 1.2s ease-in-out 0.2s infinite; }
        .bar:nth-child(8) { animation: barAnimation 1.2s ease-in-out 0.1s infinite; }

        /* Background patterns */
        .geometric-bg {
            background-color: #f9fafb;
            background-image: radial-gradient(#3F95FF 0.5px, transparent 0.5px);
            background-size: 15px 15px;
            background-position: 0 0, 10px 10px;
            background-attachment: fixed;
        }

        /* Transitions */
        .sidebar-transition {
            transition: all 0.3s ease-in-out;
        }

        /* Hover Effects */
        .hover-lift {
            transition: transform 0.2s ease;
        }

        .hover-lift:hover {
            transform: translateY(-2px);
        }

        /* Custom Scrollbar for Sidebar */
        .sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-scroll::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 10px;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }

        /* Admin badge */
        .admin-badge {
            background-color: #4f46e5;
            color: white;
            font-size: 0.7rem;
            padding: 0.15rem 0.5rem;
            border-radius: 1rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-left: 0.5rem;
        }
    </style>

    @yield('styles')
</head>

<body class="bg-gray-50 antialiased">
    <!-- Page Transition Animation Overlay -->
    <div class="page-transition-overlay" id="pageTransition">
        <div class="bars-container">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>
    </div>
    
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside
            class="fixed inset-y-0 left-0 w-64 bg-white shadow-lg z-10 transition-all duration-300 ease-in-out transform"
            id="sidebar">
            <!-- Logo -->
            <div class="p-4 border-b flex items-center justify-center h-20">
                <a href="{{ url('/dashboard') }}" class="flex items-center">
                    <img src="/images/logoElevate.png" alt="Elevate CRM" class="h-12 animate__animated animate__pulse animate__infinite animate__slower">
                </a>
            </div>

            <!-- Sidebar Navigation -->
            <nav class="mt-4 px-2 sidebar-scroll overflow-y-auto h-[calc(100vh-8rem)]">
                <div class="space-y-1">
                    <!-- Dashboard -->
                    <a href="{{ url('/dashboard') }}"
                        class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->is('dashboard') ? 'sidebar-active' : 'text-gray-700 hover:bg-gray-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="mr-3 h-5 w-5 {{ request()->is('dashboard') ? 'text-brand-blue' : 'text-gray-500 group-hover:text-gray-600' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Dashboard
                    </a>

                    <!-- Leads -->
                    <a href="{{ url('/leads') }}"
                        class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->is('leads*') ? 'sidebar-active' : 'text-gray-700 hover:bg-gray-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="mr-3 h-5 w-5 {{ request()->is('leads*') ? 'text-brand-blue' : 'text-gray-500 group-hover:text-gray-600' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Leads
                    </a>


                    <!-- Clientes -->
                    <a href="{{ url('/clientes') }}"
                        class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->is('clientes*') ? 'sidebar-active' : 'text-gray-700 hover:bg-gray-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="mr-3 h-5 w-5 {{ request()->is('clientes*') ? 'text-brand-blue' : 'text-gray-500 group-hover:text-gray-600' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Clientes
                    </a>

                    <a href="{{ url('/ventas') }}"
                        class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->is('ventas*') ? 'sidebar-active' : 'text-gray-700 hover:bg-gray-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="mr-3 h-5 w-5 {{ request()->is('ventas*') ? 'text-brand-blue' : 'text-gray-500 group-hover:text-gray-600' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 17v-2a4 4 0 014-4h10a4 4 0 014 4v2M16 21v-2a4 4 0 00-3-3.87" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 21v-2a4 4 0 013-3.87" />
                        </svg>
                        Ventas
                    </a>

                    <!-- Productos -->
                    <a href="{{ url('/productos') }}"
                        class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->is('productos*') ? 'sidebar-active' : 'text-gray-700 hover:bg-gray-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="mr-3 h-5 w-5 {{ request()->is('productos*') ? 'text-brand-blue' : 'text-gray-500 group-hover:text-gray-600' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        Productos
                    </a>

                    <!-- Proyectos -->
                    <a href="{{ url('/proyectos') }}"
                        class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->is('proyectos*') ? 'sidebar-active' : 'text-gray-700 hover:bg-gray-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="mr-3 h-5 w-5 {{ request()->is('proyectos*') ? 'text-brand-blue' : 'text-gray-500 group-hover:text-gray-600' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                        Proyectos
                    </a>

                    <!-- Notas -->
                    <a href="{{ url('/notas') }}"
                        class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->is('notas*') ? 'sidebar-active' : 'text-gray-700 hover:bg-gray-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="mr-3 h-5 w-5 {{ request()->is('notas*') ? 'text-brand-blue' : 'text-gray-500 group-hover:text-gray-600' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Notas
                    </a>

                    <!-- Facturación -->
                    <a href="{{ url('/facturacion') }}"
                        class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->is('facturacion*') ? 'sidebar-active' : 'text-gray-700 hover:bg-gray-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="mr-3 h-5 w-5 {{ request()->is('facturacion*') ? 'text-brand-blue' : 'text-gray-500 group-hover:text-gray-600' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Facturación
                    </a>

                    <!-- Reportes -->
                    <a href="{{ url('/reportes') }}"
                        class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->is('reportes*') ? 'sidebar-active' : 'text-gray-700 hover:bg-gray-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="mr-3 h-5 w-5 {{ request()->is('reportes*') ? 'text-brand-blue' : 'text-gray-500 group-hover:text-gray-600' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        Reportes
                    </a>

                    <!-- Sección para administradores -->
                    @if(isset($isAdmin) && $isAdmin)
                    <div class="pt-4 mt-4 border-t border-gray-200">
                        <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Administración
                        </h3>
                        
                        <!-- Gestión de Usuarios -->
                        <a href="{{ url('/ajustes') }}"
                            class="group flex items-center px-3 py-2 mt-1 text-sm font-medium rounded-md {{ request()->is('ajustes*') ? 'sidebar-active' : 'text-gray-700 hover:bg-gray-100' }}">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="mr-3 h-5 w-5 {{ request()->is('ajustes*') ? 'text-brand-blue' : 'text-gray-500 group-hover:text-gray-600' }}"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            Gestión de Usuarios
                        </a>
                        
                        <!-- Configuración del Sistema -->
                        <a href="{{ url('/sistema') }}"
                            class="group flex items-center px-3 py-2 mt-1 text-sm font-medium rounded-md {{ request()->is('sistema*') ? 'sidebar-active' : 'text-gray-700 hover:bg-gray-100' }}">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="mr-3 h-5 w-5 {{ request()->is('sistema*') ? 'text-brand-blue' : 'text-gray-500 group-hover:text-gray-600' }}"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            </svg>
                            Configuración del Sistema
                        </a>
                    </div>
                    @endif
                </div>
            </nav>

            <!-- User Profile -->
            <div class="absolute bottom-0 w-full border-t border-gray-200">
                <div class="p-4">
                    <div class="group flex items-center">
                        <div class="flex-shrink-0">
                            <span class="inline-block h-8 w-8 rounded-full bg-gray-200 overflow-hidden">
                                <svg class="h-full w-full text-gray-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </span>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-700 group-hover:text-gray-900">
                                {{ $userName ?? 'Usuario' }}
                                @if(isset($isAdmin) && $isAdmin)
                                <span class="admin-badge">Admin</span>
                                @endif
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ $companyName ?? 'Empresa' }}
                                @if(isset($isAdmin) && $isAdmin)
                                <span class="text-xs text-indigo-600">(Administración)</span>
                                @endif
                            </p>
                            <p class="text-xs font-medium text-gray-500 group-hover:text-gray-700">
                                <button id="logout-btn" class="text-brand-blue hover:underline">Cerrar sesión</button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 ml-64">
            <!-- Top Navigation -->
            <header class="bg-white shadow-sm h-16 flex items-center">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                    <div class="flex justify-between items-center">
                        <!-- Page Title -->
                        <div>
                            <h1 class="text-xl font-semibold text-gray-800">@yield('header', 'Dashboard')</h1>
                            <p class="text-sm text-gray-500">@yield('breadcrumb', 'Inicio')</p>
                        </div>

                        <!-- Header Actions -->
                        <div class="flex items-center space-x-4">
                            <!-- Help Button -->
                            <button type="button" id="help-button"
                                class="p-1 rounded-full text-gray-500 hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-blue transition-all duration-300 transform hover:scale-110">
                                <span class="sr-only">Ayuda</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </button>

                            <!-- User Type Badge (solo visible en la versión móvil) -->
                            @if(isset($isAdmin) && $isAdmin)
                            <span class="md:hidden admin-badge">Admin</span>
                            @endif

                            <!-- Mobile Menu Button -->
                            <button id="mobile-menu-btn" type="button"
                                class="md:hidden p-1 rounded-full text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-blue">
                                <span class="sr-only">Abrir menú</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <main class="py-6 px-4 sm:px-6 lg:px-8">
                <!-- Content Container -->
                <div class="max-w-7xl mx-auto">
                    @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 relative" role="alert">
                        <strong class="font-bold">Error:</strong>
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                    @endif
                    
                    @yield('content')
                </div>
            </main>

            <!-- Footer -->
            <footer class="bg-white p-4 border-t mt-auto">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center">
                        <div class="text-sm text-gray-500">
                            &copy; 2023 Elevate CRM. Todos los derechos reservados.
                        </div>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-500 hover:text-gray-700">
                                <span class="sr-only">Términos</span>
                                <span class="text-xs">Términos de uso</span>
                            </a>
                            <a href="#" class="text-gray-500 hover:text-gray-700">
                                <span class="sr-only">Privacidad</span>
                                <span class="text-xs">Política de privacidad</span>
                            </a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Modal de Ayuda -->
    <div id="help-modal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-modal="true">
        <div class="flex min-h-screen items-center justify-center px-4 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-900/75 transition-opacity" aria-hidden="true"></div>
            
            <!-- Modal Panel -->
            <div class="inline-block transform overflow-hidden rounded-lg bg-white text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-3xl sm:align-middle">
                <!-- Header con logo -->
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-4 py-6 sm:px-6 text-center">
                    <img src="/images/logoElevate.png" alt="Elevate CRM" class="h-16 mx-auto mb-3 animate__animated animate__pulse animate__infinite animate__slower">
                    <h3 class="text-xl font-semibold text-white">Centro de Ayuda</h3>
                    <p class="mt-1 text-sm text-blue-100">Encuentra respuestas a tus preguntas y descubre cómo sacar el máximo provecho del sistema</p>
                </div>
                
                <!-- Contenido del modal -->
                <div class="px-4 py-5 sm:p-6">
                    <!-- Pestañas de navegación -->
                    <div class="border-b border-gray-200 mb-6">
                        <div class="flex -mb-px">
                            <button class="help-tab active py-4 px-6 border-b-2 border-blue-500 font-medium text-sm text-blue-600" data-tab="faq">
                                Preguntas Frecuentes
                            </button>
                            <button class="help-tab py-4 px-6 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="guides">
                                Guías Rápidas
                            </button>
                            <button class="help-tab py-4 px-6 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="support">
                                Soporte
                            </button>
                        </div>
                    </div>
                    
                    <!-- Contenido de las pestañas -->
                    <div>
                        <!-- FAQs -->
                        <div id="faq-content" class="help-content">
                            <div class="space-y-4">
                                <details class="rounded-lg bg-gray-50 overflow-hidden">
                                    <summary class="cursor-pointer text-sm font-medium px-4 py-3 text-gray-800 flex justify-between items-center">
                                        ¿Cómo agregar un nuevo cliente?
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </summary>
                                    <div class="px-4 py-3 text-sm text-gray-600 border-t border-gray-200">
                                        <p>Para agregar un nuevo cliente, haz lo siguiente:</p>
                                        <ol class="list-decimal list-inside mt-2 space-y-1 ml-2">
                                            <li>Navega a la sección "Clientes" en el menú lateral</li>
                                            <li>Haz clic en el botón "Nuevo Cliente"</li>
                                            <li>Rellena todos los campos requeridos</li>
                                            <li>Haz clic en "Guardar" para crear el cliente</li>
                                        </ol>
                                    </div>
                                </details>
                                
                                <details class="rounded-lg bg-gray-50 overflow-hidden">
                                    <summary class="cursor-pointer text-sm font-medium px-4 py-3 text-gray-800 flex justify-between items-center">
                                        ¿Cómo crear una propuesta de venta?
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </summary>
                                    <div class="px-4 py-3 text-sm text-gray-600 border-t border-gray-200">
                                        <p>Para crear una propuesta de venta:</p>
                                        <ol class="list-decimal list-inside mt-2 space-y-1 ml-2">
                                            <li>Ve a la sección "Ventas" en el menú lateral</li>
                                            <li>Selecciona "Propuestas"</li>
                                            <li>Haz clic en "Nueva Propuesta"</li>
                                            <li>Selecciona el cliente</li>
                                            <li>Agrega los productos o servicios</li>
                                            <li>Completa la información requerida</li>
                                            <li>Guarda la propuesta</li>
                                        </ol>
                                    </div>
                                </details>
                                
                                <details class="rounded-lg bg-gray-50 overflow-hidden">
                                    <summary class="cursor-pointer text-sm font-medium px-4 py-3 text-gray-800 flex justify-between items-center">
                                        ¿Cómo gestionar los permisos de usuario?
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </summary>
                                    <div class="px-4 py-3 text-sm text-gray-600 border-t border-gray-200">
                                        <p>Para gestionar los permisos de usuario:</p>
                                        <ol class="list-decimal list-inside mt-2 space-y-1 ml-2">
                                            <li>Accede a la sección "Gestión de Usuarios" en el menú de Administración</li>
                                            <li>Selecciona el usuario en el desplegable</li>
                                            <li>Marca o desmarca los permisos según necesites</li>
                                            <li>Haz clic en "Guardar Cambios"</li>
                                        </ol>
                                    </div>
                                </details>
                            </div>
                        </div>
                        
                        <!-- Guías Rápidas -->
                        <div id="guides-content" class="help-content hidden">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <a href="#" class="rounded-lg border border-gray-200 p-4 hover:shadow-md transition-shadow duration-200 flex flex-col">
                                    <div class="flex items-center mb-3">
                                        <div class="bg-blue-100 rounded-full p-2 mr-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                            </svg>
                                        </div>
                                        <h4 class="font-medium text-gray-800">Guía de inicio rápido</h4>
                                    </div>
                                    <p class="text-sm text-gray-600">Aprende los fundamentos básicos del sistema en menos de 10 minutos</p>
                                </a>

                                <a href="#" class="rounded-lg border border-gray-200 p-4 hover:shadow-md transition-shadow duration-200 flex flex-col">
                                    <div class="flex items-center mb-3">
                                        <div class="bg-green-100 rounded-full p-2 mr-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                            </svg>
                                        </div>
                                        <h4 class="font-medium text-gray-800">Reportes y análisis</h4>
                                    </div>
                                    <p class="text-sm text-gray-600">Aprende a generar informes y analizar los datos clave</p>
                                </a>

                                <a href="#" class="rounded-lg border border-gray-200 p-4 hover:shadow-md transition-shadow duration-200 flex flex-col">
                                    <div class="flex items-center mb-3">
                                        <div class="bg-purple-100 rounded-full p-2 mr-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                        </div>
                                        <h4 class="font-medium text-gray-800">Gestión de clientes y leads</h4>
                                    </div>
                                    <p class="text-sm text-gray-600">Aprende sobre el ciclo de vida completo de clientes y leads</p>
                                </a>

                                <a href="#" class="rounded-lg border border-gray-200 p-4 hover:shadow-md transition-shadow duration-200 flex flex-col">
                                    <div class="flex items-center mb-3">
                                        <div class="bg-yellow-100 rounded-full p-2 mr-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <h4 class="font-medium text-gray-800">Facturación y ventas</h4>
                                    </div>
                                    <p class="text-sm text-gray-600">Todo lo que necesitas saber sobre facturación y gestión de ventas</p>
                                </a>
                            </div>
                        </div>
                        
                        <!-- Soporte -->
                        <div id="support-content" class="help-content hidden">
                            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-blue-700">
                                            Nuestro equipo de soporte está disponible de lunes a viernes, de 8:00 a 18:00 (GMT+1).
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="space-y-6">
                                <div>
                                    <h4 class="text-base font-medium text-gray-900 mb-2">Contacto</h4>
                                    <div class="flex items-center mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        <a href="mailto:soporte@elevatecrm.com" class="text-blue-600 hover:text-blue-800">soporte@elevatecrm.com</a>
                                    </div>
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        <span class="text-gray-700">+34 91 123 45 67</span>
                                    </div>
                                </div>
                                
                                <div>
                                    <h4 class="text-base font-medium text-gray-900 mb-2">Enviar consulta</h4>
                                    <form class="space-y-4">
                                        <div>
                                            <label for="support-subject" class="block text-sm font-medium text-gray-700">Asunto</label>
                                            <input type="text" id="support-subject" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        </div>
                                        <div>
                                            <label for="support-message" class="block text-sm font-medium text-gray-700">Mensaje</label>
                                            <textarea id="support-message" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
                                        </div>
                                        <div class="text-right">
                                            <button type="button" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                Enviar mensaje
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Footer del modal -->
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-200">
                    <button type="button" id="close-help-modal" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-btn')?.addEventListener('click', function () {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('-translate-x-full');
        });

        // Modal de Ayuda
        document.addEventListener('DOMContentLoaded', function() {
            const helpButton = document.getElementById('help-button');
            const helpModal = document.getElementById('help-modal');
            const closeHelpModalBtn = document.getElementById('close-help-modal');
            const helpTabs = document.querySelectorAll('.help-tab');
            const helpContents = document.querySelectorAll('.help-content');
            
            // Abrir modal
            helpButton?.addEventListener('click', function() {
                helpModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden'; // Evitar scroll en el fondo
            });
            
            // Cerrar modal
            closeHelpModalBtn?.addEventListener('click', function() {
                helpModal.classList.add('hidden');
                document.body.style.overflow = '';
            });
            
            // Cerrar modal al hacer clic fuera del contenido
            helpModal?.addEventListener('click', function(e) {
                if (e.target === helpModal) {
                    helpModal.classList.add('hidden');
                    document.body.style.overflow = '';
                }
            });
            
            // Cambio de pestañas
            helpTabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    const targetTab = this.getAttribute('data-tab');
                    
                    // Actualizar pestañas activas
                    helpTabs.forEach(t => t.classList.remove('active', 'border-blue-500', 'text-blue-600'));
                    helpTabs.forEach(t => t.classList.add('border-transparent', 'text-gray-500'));
                    this.classList.add('active', 'border-blue-500', 'text-blue-600');
                    this.classList.remove('border-transparent', 'text-gray-500');
                    
                    // Mostrar contenido correspondiente
                    helpContents.forEach(content => content.classList.add('hidden'));
                    document.getElementById(`${targetTab}-content`).classList.remove('hidden');
                });
            });
        });

        // Logout functionality
        document.getElementById('logout-btn')?.addEventListener('click', async function () {
            try {
                const response = await fetch('/api/logout', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                });

                if (response.ok) {
                    window.location.href = '/login';
                } else {
                    console.error('Error al cerrar sesión');
                }
            } catch (error) {
                console.error('Error al cerrar sesión:', error);
            }
        });

        // Funciones de permisos para uso en JavaScript
        window.Permissions = {
            // Variable para almacenar permisos (se llenará mediante AJAX)
            userPermissions: {},
            
            // Obtener permisos del usuario actual
            fetchPermissions: async function() {
                try {
                    const response = await fetch('/api/user-permissions', {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    if (response.ok) {
                        const data = await response.json();
                        this.userPermissions = data.permissions || {};
                        return this.userPermissions;
                    }
                } catch (error) {
                    console.error('Error al obtener permisos:', error);
                }
                return {};
            },
            
            // Verificar si el usuario tiene un permiso específico
            hasPermission: function(modulo, permiso = 'ver') {
                // Si es admin, retornar true directamente
                if (this.isAdmin()) {
                    return true;
                }
                
                // Verificar en permisos del usuario
                return this.userPermissions && 
                       this.userPermissions[modulo] && 
                       this.userPermissions[modulo][permiso] === true;
            },
            
            // Verificar si el usuario es administrador
            isAdmin: function() {
                return document.body.dataset.isAdmin === 'true';
            },
            
            // Ocultar elementos basados en permisos
            hideIfNoPermission: function(selector, modulo, permiso = 'ver') {
                const elements = document.querySelectorAll(selector);
                if (!this.hasPermission(modulo, permiso)) {
                    elements.forEach(el => {
                        el.style.display = 'none';
                    });
                }
            }
        };
        
        // Inicializar permisos al cargar la página
        document.addEventListener('DOMContentLoaded', async function() {
            // Establecer si el usuario es administrador desde el backend
            document.body.dataset.isAdmin = '{{ isset($isAdmin) && $isAdmin ? "true" : "false" }}';
            
            // Obtener permisos si no es admin
            if (document.body.dataset.isAdmin !== 'true') {
                await window.Permissions.fetchPermissions();
                
                // Ocultar elementos que requieren permisos específicos
                // Ejemplo: Ocultar botones de crear clientes
                window.Permissions.hideIfNoPermission('.btn-crear-cliente', 'clientes', 'crear');
                window.Permissions.hideIfNoPermission('.btn-editar-cliente', 'clientes', 'editar');
                window.Permissions.hideIfNoPermission('.btn-eliminar-cliente', 'clientes', 'borrar');
                
                window.Permissions.hideIfNoPermission('.btn-crear-producto', 'productos', 'crear');
                window.Permissions.hideIfNoPermission('.btn-editar-producto', 'productos', 'editar');
                window.Permissions.hideIfNoPermission('.btn-eliminar-producto', 'productos', 'borrar');
                
                // Y así para los demás módulos...
            }
        });

        // Page transition animation
        document.addEventListener('DOMContentLoaded', function() {
            const pageTransition = document.getElementById('pageTransition');
            const links = document.querySelectorAll('a:not([target="_blank"]):not([href^="#"]):not([href^="javascript"]):not([href^="mailto"])');
            
            // Function to show the animation
            function showTransition() {
                pageTransition.classList.add('active');
                
                // Hide animation after a delay (1.5 seconds)
                setTimeout(() => {
                    pageTransition.classList.remove('active');
                }, 1500);
            }
            
            // Add click event listeners to all navigation links
            links.forEach(link => {
                link.addEventListener('click', function(e) {
                    // Check if it's a navigation link (not in-page anchor or external)
                    const href = link.getAttribute('href');
                    const isLocal = href && (href.startsWith('/') || href.startsWith(window.location.origin));
                    
                    if (isLocal && !e.ctrlKey && !e.metaKey) {
                        e.preventDefault();
                        showTransition();
                        
                        // Navigate to the new page after a short delay
                        setTimeout(() => {
                            window.location.href = href;
                        }, 300);
                    }
                });
            });

            // Also trigger the animation when navigating with browser history
            window.addEventListener('popstate', function() {
                showTransition();
            });
        });
    </script>

    @yield('scripts')
</body>

</html>