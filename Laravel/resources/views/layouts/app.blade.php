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

    <link rel="icon" type="image/png" href="{{ asset('images/logoElevate.png') }}">


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

        /* Alert styles */
        .app-alert {
            background-color: #D1FAE5;
            border-radius: 0.375rem;
            padding: 1rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            border-left: 4px solid #10B981;
        }

        .app-alert-success {
            background-color: #D1FAE5;
            border-left-color: #10B981;
            color: #065F46;
        }

        .app-alert-error {
            background-color: #FEE2E2;
            border-left-color: #EF4444;
            color: #991B1B;
        }

        .app-alert-warning {
            background-color: #FEF3C7;
            border-left-color: #F59E0B;
            color: #92400E;
        }

        .app-alert-info {
            background-color: #DBEAFE;
            border-left-color: #3B82F6;
            color: #1E40AF;
        }

        .app-alert-icon {
            flex-shrink: 0;
            width: 1.25rem;
            height: 1.25rem;
            margin-right: 0.75rem;
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
                    <img src="/images/logoElevate.png" alt="Elevate CRM" class="h-16">
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
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
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
                        class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->is('proyectos*') ? 'sidebar-active' : 'text-gray-700 hover:bg-gray-100' }}"
                        id="nav-proyectos">
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
                    @if(session('success'))
                    <div class="app-alert app-alert-success" role="alert">
                        <svg class="app-alert-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="app-alert app-alert-error" role="alert">
                        <svg class="app-alert-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                    @endif

                    @if(session('warning'))
                    <div class="app-alert app-alert-warning" role="alert">
                        <svg class="app-alert-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <span>{{ session('warning') }}</span>
                    </div>
                    @endif

                    @if(session('info'))
                    <div class="app-alert app-alert-info" role="alert">
                        <svg class="app-alert-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ session('info') }}</span>
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
                            &copy; 2025 Elevate CRM. Todos los derechos reservados.
                        </div>
                        <div class="flex space-x-4">
                            <button id="terms-btn" class="text-gray-500 hover:text-gray-700">
                                <span class="text-xs">Términos de uso</span>
                            </button>
                            <button id="privacy-btn" class="text-gray-500 hover:text-gray-700">
                                <span class="text-xs">Política de privacidad</span>
                            </button>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Modal de Términos de Uso -->
    <div id="terms-modal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-modal="true">
        <div class="flex min-h-screen items-center justify-center px-4 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-900/75 transition-opacity" aria-hidden="true"></div>
            
            <!-- Modal Panel -->
            <div class="inline-block transform overflow-hidden rounded-lg bg-white text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-3xl sm:align-middle">
                <!-- Header -->
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-4 py-6 sm:px-6">
                    <div class="flex justify-between items-center">
                        <h3 class="text-xl font-semibold text-white">Términos de Uso</h3>
                        <button id="close-terms-modal" class="text-white hover:text-gray-200">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
                
                <!-- Contenido del modal -->
                <div class="px-4 py-5 sm:p-6 max-h-[70vh] overflow-y-auto">
                    <div class="prose prose-blue max-w-none">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">1. Aceptación de los Términos</h4>
                        <p class="mb-4 text-gray-700">Al acceder y utilizar este sistema ERP-CRM, usted acepta estar legalmente obligado por estos términos y condiciones. Si no está de acuerdo con alguno de estos términos, no debe utilizar este servicio.</p>
                        
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">2. Licencia de Uso</h4>
                        <p class="mb-4 text-gray-700">Elevate CRM otorga al usuario una licencia limitada, no exclusiva y no transferible para acceder y utilizar el sistema de acuerdo con estos términos y condiciones. Esta licencia está sujeta al cumplimiento continuo de estos términos.</p>
                        
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">3. Restricciones de Uso</h4>
                        <p class="mb-4 text-gray-700">El usuario se compromete a no:</p>
                        <ul class="list-disc pl-5 mb-4 text-gray-700">
                            <li>Utilizar el sistema para fines ilegales o no autorizados</li>
                            <li>Intentar acceder a áreas restringidas del sistema</li>
                            <li>Modificar, adaptar o piratear el sistema</li>
                            <li>Transmitir virus o código malicioso</li>
                            <li>Realizar ingeniería inversa del software</li>
                        </ul>
                        
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">4. Propiedad Intelectual</h4>
                        <p class="mb-4 text-gray-700">Todos los derechos de propiedad intelectual relacionados con el sistema, incluyendo pero no limitado a software, código, diseño, logotipos y marcas comerciales, son propiedad de Elevate CRM o sus licenciantes. Ninguna disposición de estos términos transfiere ningún derecho de propiedad al usuario.</p>
                        
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">5. Privacidad y Datos</h4>
                        <p class="mb-4 text-gray-700">El uso del sistema está sujeto a nuestra política de privacidad, que describe cómo recopilamos, utilizamos y protegemos la información proporcionada por los usuarios. Al utilizar este sistema, usted acepta el procesamiento de su información según lo establecido en nuestra política de privacidad.</p>
                        
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">6. Modificaciones</h4>
                        <p class="mb-4 text-gray-700">Elevate CRM se reserva el derecho de modificar estos términos en cualquier momento. Los cambios entrarán en vigor inmediatamente después de su publicación. El uso continuado del sistema después de dichos cambios constituirá su aceptación de los nuevos términos.</p>
                        
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">7. Terminación</h4>
                        <p class="mb-4 text-gray-700">Elevate CRM se reserva el derecho de terminar o suspender el acceso al sistema en cualquier momento y por cualquier motivo, sin previo aviso.</p>
                        
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">8. Limitación de Responsabilidad</h4>
                        <p class="mb-4 text-gray-700">En ningún caso Elevate CRM será responsable por daños directos, indirectos, incidentales, especiales o consecuentes que resulten del uso o la imposibilidad de usar el sistema.</p>
                        
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">9. Ley Aplicable</h4>
                        <p class="mb-4 text-gray-700">Estos términos se regirán e interpretarán de acuerdo con las leyes del país de operación de Elevate CRM, sin tener en cuenta sus disposiciones sobre conflictos de leyes.</p>
                    </div>
                </div>
                
                <!-- Footer del modal -->
                <div class="bg-gray-50 px-4 py-3 sm:px-6 flex justify-end border-t border-gray-200">
                    <button type="button" id="close-terms-btn" class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:w-auto sm:text-sm">
                        Aceptar
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal de Política de Privacidad -->
    <div id="privacy-modal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-modal="true">
        <div class="flex min-h-screen items-center justify-center px-4 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-900/75 transition-opacity" aria-hidden="true"></div>
            
            <!-- Modal Panel -->
            <div class="inline-block transform overflow-hidden rounded-lg bg-white text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-3xl sm:align-middle">
                <!-- Header -->
                <div class="bg-gradient-to-r from-green-600 to-teal-600 px-4 py-6 sm:px-6">
                    <div class="flex justify-between items-center">
                        <h3 class="text-xl font-semibold text-white">Política de Privacidad</h3>
                        <button id="close-privacy-modal" class="text-white hover:text-gray-200">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
                
                <!-- Contenido del modal -->
                <div class="px-4 py-5 sm:p-6 max-h-[70vh] overflow-y-auto">
                    <div class="prose prose-blue max-w-none">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">1. Información que Recopilamos</h4>
                        <p class="mb-4 text-gray-700">Elevate CRM puede recopilar la siguiente información personal:</p>
                        <ul class="list-disc pl-5 mb-4 text-gray-700">
                            <li>Información de contacto (nombre, dirección de correo electrónico, teléfono)</li>
                            <li>Información de la empresa (nombre, dirección, sector)</li>
                            <li>Datos de inicio de sesión y actividad en el sistema</li>
                            <li>Información del dispositivo y conexión</li>
                        </ul>
                        
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">2. Cómo Utilizamos su Información</h4>
                        <p class="mb-4 text-gray-700">Utilizamos la información recopilada para:</p>
                        <ul class="list-disc pl-5 mb-4 text-gray-700">
                            <li>Proporcionar y mantener nuestros servicios</li>
                            <li>Mejorar y personalizar la experiencia del usuario</li>
                            <li>Enviar información importante sobre el servicio</li>
                            <li>Proporcionar soporte al cliente</li>
                            <li>Garantizar la seguridad de nuestros sistemas</li>
                        </ul>
                        
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">3. Protección de Datos</h4>
                        <p class="mb-4 text-gray-700">Implementamos medidas de seguridad técnicas y organizativas para proteger sus datos personales contra el acceso no autorizado, la pérdida o alteración. Estas medidas incluyen encriptación de datos, acceso restringido y auditorías regulares de seguridad.</p>
                        
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">4. Compartir Datos</h4>
                        <p class="mb-4 text-gray-700">No vendemos, intercambiamos ni transferimos su información personal a terceros sin su consentimiento, excepto cuando sea necesario para proporcionar nuestros servicios o cumplir con requisitos legales.</p>
                        
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">5. Cookies y Tecnologías Similares</h4>
                        <p class="mb-4 text-gray-700">Utilizamos cookies y tecnologías similares para mejorar la experiencia del usuario, analizar el uso del sistema y personalizar el contenido. Puede configurar su navegador para rechazar cookies, pero esto puede limitar algunas funcionalidades del sistema.</p>
                        
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">6. Sus Derechos</h4>
                        <p class="mb-4 text-gray-700">Dependiendo de su ubicación, puede tener ciertos derechos con respecto a sus datos personales, incluyendo:</p>
                        <ul class="list-disc pl-5 mb-4 text-gray-700">
                            <li>Derecho de acceso a sus datos</li>
                            <li>Derecho a rectificar datos inexactos</li>
                            <li>Derecho a eliminar sus datos</li>
                            <li>Derecho a restringir el procesamiento</li>
                            <li>Derecho a la portabilidad de datos</li>
                            <li>Derecho a oponerse al procesamiento</li>
                        </ul>
                        
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">7. Retención de Datos</h4>
                        <p class="mb-4 text-gray-700">Conservaremos sus datos personales solo durante el tiempo necesario para cumplir con los fines para los que se recopilaron, incluido el cumplimiento de requisitos legales o reglamentarios.</p>
                        
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">8. Cambios en esta Política</h4>
                        <p class="mb-4 text-gray-700">Podemos actualizar nuestra política de privacidad periódicamente. Le notificaremos cualquier cambio publicando la nueva política de privacidad en esta página y, cuando sea apropiado, le informaremos por correo electrónico.</p>
                        
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">9. Contacto</h4>
                        <p class="mb-4 text-gray-700">Si tiene preguntas sobre esta política de privacidad, puede contactarnos a través de los canales de soporte proporcionados en el sistema.</p>
                    </div>
                </div>
                
                <!-- Footer del modal -->
                <div class="bg-gray-50 px-4 py-3 sm:px-6 flex justify-end border-t border-gray-200">
                    <button type="button" id="close-privacy-btn" class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:w-auto sm:text-sm">
                        Aceptar
                    </button>
                </div>
            </div>
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
                    <img src="/images/logoElevate.png" alt="Elevate CRM" class="h-20 mx-auto mb-3">
                    <h3 class="text-xl font-semibold text-white">Centro de Ayuda</h3>
                </div>
                
                <!-- Contenido del modal -->
                <div class="px-4 py-5 sm:p-6">
                    <!-- Pestañas de navegación -->
                    <div class="border-b border-gray-200 mb-6">
                        <div class="flex -mb-px">
                            <button class="help-tab active py-4 px-6 border-b-2 border-blue-500 font-medium text-sm text-blue-600 w-full" data-tab="faq">
                                Preguntas Frecuentes
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

                                <details class="rounded-lg bg-gray-50 overflow-hidden">
                                    <summary class="cursor-pointer text-sm font-medium px-4 py-3 text-gray-800 flex justify-between items-center">
                                        ¿Cómo crear un nuevo tipo de cliente?
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </summary>
                                    <div class="px-4 py-3 text-sm text-gray-600 border-t border-gray-200">
                                        <p>Para crear un nuevo tipo de cliente:</p>
                                        <ol class="list-decimal list-inside mt-2 space-y-1 ml-2">
                                            <li>Ve a la sección "Clientes" en el menú lateral</li>
                                            <li>Haz clic en el icono "+" junto al filtro de tipos de cliente</li>
                                            <li>Completa el nombre y descripción del nuevo tipo</li>
                                            <li>Haz clic en "Guardar"</li>
                                        </ol>
                            </div>
                                </details>

                                <details class="rounded-lg bg-gray-50 overflow-hidden">
                                    <summary class="cursor-pointer text-sm font-medium px-4 py-3 text-gray-800 flex justify-between items-center">
                                        ¿Cómo agregar un nuevo producto o servicio?
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </summary>
                                    <div class="px-4 py-3 text-sm text-gray-600 border-t border-gray-200">
                                        <p>Para agregar un nuevo producto o servicio:</p>
                                        <ol class="list-decimal list-inside mt-2 space-y-1 ml-2">
                                            <li>Ve a la sección "Productos" en el menú lateral</li>
                                            <li>Haz clic en "Nuevo Producto/Servicio"</li>
                                            <li>Completa la información requerida como nombre, descripción y precio</li>
                                            <li>Selecciona si es un producto o servicio</li>
                                            <li>Haz clic en "Guardar"</li>
                                        </ol>
                        </div>
                                </details>

                                <details class="rounded-lg bg-gray-50 overflow-hidden">
                                    <summary class="cursor-pointer text-sm font-medium px-4 py-3 text-gray-800 flex justify-between items-center">
                                        ¿Cómo generar un reporte de ventas?
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                            </svg>
                                    </summary>
                                    <div class="px-4 py-3 text-sm text-gray-600 border-t border-gray-200">
                                        <p>Para generar un reporte de ventas:</p>
                                        <ol class="list-decimal list-inside mt-2 space-y-1 ml-2">
                                            <li>Accede a la sección "Reportes" en el menú lateral</li>
                                            <li>Selecciona "Reporte de Ventas" del menú desplegable</li>
                                            <li>Configura el rango de fechas deseado</li>
                                            <li>Aplica los filtros necesarios (por cliente, producto, etc.)</li>
                                            <li>Haz clic en "Generar Reporte"</li>
                                            <li>Puedes exportar el reporte a PDF o Excel usando los botones correspondientes</li>
                                        </ol>
                                        </div>
                                </details>

                                <details class="rounded-lg bg-gray-50 overflow-hidden">
                                    <summary class="cursor-pointer text-sm font-medium px-4 py-3 text-gray-800 flex justify-between items-center">
                                        ¿Cómo convertir un lead en cliente?
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                            </svg>
                                    </summary>
                                    <div class="px-4 py-3 text-sm text-gray-600 border-t border-gray-200">
                                        <p>Para convertir un lead en cliente:</p>
                                        <ol class="list-decimal list-inside mt-2 space-y-1 ml-2">
                                            <li>Ve a la sección "Leads" en el menú lateral</li>
                                            <li>Encuentra el lead que deseas convertir</li>
                                            <li>Haz clic en el botón "Ver detalles" o accede a la página de edición</li>
                                            <li>Haz clic en el botón "Convertir a Cliente"</li>
                                            <li>Completa cualquier información adicional requerida</li>
                                            <li>Confirma la conversión</li>
                                        </ol>
                                        </div>
                                </details>

                                <details class="rounded-lg bg-gray-50 overflow-hidden">
                                    <summary class="cursor-pointer text-sm font-medium px-4 py-3 text-gray-800 flex justify-between items-center">
                                        ¿Cómo crear y gestionar notas?
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                            </svg>
                                    </summary>
                                    <div class="px-4 py-3 text-sm text-gray-600 border-t border-gray-200">
                                        <p>Para crear y gestionar notas:</p>
                                        <ol class="list-decimal list-inside mt-2 space-y-1 ml-2">
                                            <li>Accede a la sección "Notas" en el menú lateral</li>
                                            <li>Para crear una nueva nota, haz clic en "Nueva Nota"</li>
                                            <li>Selecciona el tipo de nota (cliente, lead, proyecto, etc.)</li>
                                            <li>Completa el título y contenido de la nota</li>
                                            <li>Asigna la nota a un elemento específico si es necesario</li>
                                            <li>Haz clic en "Guardar"</li>
                                            <li>Para editar o eliminar una nota existente, usa los botones correspondientes en la lista de notas</li>
                                        </ol>
                                        </div>
                                </details>

                                <details class="rounded-lg bg-gray-50 overflow-hidden">
                                    <summary class="cursor-pointer text-sm font-medium px-4 py-3 text-gray-800 flex justify-between items-center">
                                        ¿Cómo modificar mi perfil de usuario?
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                            </svg>
                                    </summary>
                                    <div class="px-4 py-3 text-sm text-gray-600 border-t border-gray-200">
                                        <p>Para modificar tu perfil de usuario:</p>
                                        <ol class="list-decimal list-inside mt-2 space-y-1 ml-2">
                                            <li>Haz clic en tu nombre o avatar en la esquina superior derecha</li>
                                            <li>Selecciona "Mi Perfil" del menú desplegable</li>
                                            <li>Edita la información que desees cambiar</li>
                                            <li>Para cambiar tu contraseña, usa la sección específica para ello</li>
                                            <li>Haz clic en "Guardar Cambios" para aplicar las modificaciones</li>
                                        </ol>
                                        </div>
                                </details>

                                <details class="rounded-lg bg-gray-50 overflow-hidden">
                                    <summary class="cursor-pointer text-sm font-medium px-4 py-3 text-gray-800 flex justify-between items-center">
                                        ¿Cómo filtrar y buscar clientes?
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </summary>
                                    <div class="px-4 py-3 text-sm text-gray-600 border-t border-gray-200">
                                        <p>Para filtrar y buscar clientes:</p>
                                        <ol class="list-decimal list-inside mt-2 space-y-1 ml-2">
                                            <li>Ve a la sección "Clientes" en el menú lateral</li>
                                            <li>Usa el campo de búsqueda para encontrar clientes por nombre</li>
                                            <li>Utiliza el filtro por tipo de cliente para refinar los resultados</li>
                                            <li>Los resultados se actualizarán automáticamente mientras escribes</li>
                                            <li>Para búsquedas más avanzadas, puedes combinar filtros o usar las opciones de ordenamiento</li>
                                        </ol>
                                    </div>
                                </details>

                                <details class="rounded-lg bg-gray-50 overflow-hidden">
                                    <summary class="cursor-pointer text-sm font-medium px-4 py-3 text-gray-800 flex justify-between items-center">
                                        ¿Cómo confirmar una propuesta de venta?
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </summary>
                                    <div class="px-4 py-3 text-sm text-gray-600 border-t border-gray-200">
                                        <p>Para confirmar una propuesta de venta:</p>
                                        <ol class="list-decimal list-inside mt-2 space-y-1 ml-2">
                                            <li>Ve a la sección "Ventas" en el menú lateral</li>
                                            <li>Selecciona "Propuestas"</li>
                                            <li>Encuentra la propuesta que deseas confirmar</li>
                                            <li>Haz clic en el botón "Confirmar Propuesta"</li>
                                            <li>Verifica los detalles de la venta</li>
                                            <li>Completa la información adicional si es necesario</li>
                                            <li>Haz clic en "Efectuar Venta" para finalizar el proceso</li>
                                        </ol>
                                    </div>
                                </details>

                                <details class="rounded-lg bg-gray-50 overflow-hidden">
                                    <summary class="cursor-pointer text-sm font-medium px-4 py-3 text-gray-800 flex justify-between items-center">
                                        ¿Cómo visualizar el historial de actividades de un cliente?
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </summary>
                                    <div class="px-4 py-3 text-sm text-gray-600 border-t border-gray-200">
                                        <p>Para visualizar el historial de actividades de un cliente:</p>
                                        <ol class="list-decimal list-inside mt-2 space-y-1 ml-2">
                                            <li>Ve a la sección "Clientes" en el menú lateral</li>
                                            <li>Encuentra y selecciona el cliente deseado</li>
                                            <li>Haz clic en "Ver detalles" para abrir la ficha completa</li>
                                            <li>Navega a la pestaña "Historial" o "Actividades"</li>
                                            <li>Allí verás todas las interacciones, notas, ventas y propuestas relacionadas con este cliente</li>
                                            <li>Puedes filtrar por tipo de actividad o rango de fechas si es necesario</li>
                                        </ol>
                                    </div>
                                </details>

                                <details class="rounded-lg bg-gray-50 overflow-hidden">
                                    <summary class="cursor-pointer text-sm font-medium px-4 py-3 text-gray-800 flex justify-between items-center">
                                        ¿Cómo exportar datos del sistema?
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </summary>
                                    <div class="px-4 py-3 text-sm text-gray-600 border-t border-gray-200">
                                        <p>Para exportar datos del sistema:</p>
                                        <ol class="list-decimal list-inside mt-2 space-y-1 ml-2">
                                            <li>Ve a la sección correspondiente (Clientes, Ventas, Productos, etc.)</li>
                                            <li>Aplica los filtros necesarios para seleccionar los datos que deseas exportar</li>
                                            <li>Busca el botón "Exportar" o el icono de descarga en la parte superior de la tabla</li>
                                            <li>Selecciona el formato deseado (CSV, Excel, PDF) según tus necesidades</li>
                                            <li>Confirma la exportación</li>
                                            <li>El archivo se descargará automáticamente a tu dispositivo</li>
                                        </ol>
                                        </div>
                                </details>
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
                    document.getElementById(`${targetTab}-content`)?.classList.remove('hidden');
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
                
                window.Permissions.hideIfNoPermission('.btn-crear-proyecto', 'proyectos', 'crear');
                window.Permissions.hideIfNoPermission('.btn-editar-proyecto', 'proyectos', 'editar');
                window.Permissions.hideIfNoPermission('.btn-eliminar-proyecto', 'proyectos', 'borrar');
                
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
            
            // Términos y Privacidad modals
            const termsBtn = document.getElementById('terms-btn');
            const termsModal = document.getElementById('terms-modal');
            const closeTermsModal = document.getElementById('close-terms-modal');
            const closeTermsBtn = document.getElementById('close-terms-btn');
            
            const privacyBtn = document.getElementById('privacy-btn');
            const privacyModal = document.getElementById('privacy-modal');
            const closePrivacyModal = document.getElementById('close-privacy-modal');
            const closePrivacyBtn = document.getElementById('close-privacy-btn');
            
            // Términos modal
            termsBtn?.addEventListener('click', function() {
                termsModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            });
            
            closeTermsModal?.addEventListener('click', function() {
                termsModal.classList.add('hidden');
                document.body.style.overflow = '';
            });
            
            closeTermsBtn?.addEventListener('click', function() {
                termsModal.classList.add('hidden');
                document.body.style.overflow = '';
            });
            
            termsModal?.addEventListener('click', function(e) {
                if (e.target === termsModal) {
                    termsModal.classList.add('hidden');
                    document.body.style.overflow = '';
                }
            });
            
            // Privacidad modal
            privacyBtn?.addEventListener('click', function() {
                privacyModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            });
            
            closePrivacyModal?.addEventListener('click', function() {
                privacyModal.classList.add('hidden');
                document.body.style.overflow = '';
            });
            
            closePrivacyBtn?.addEventListener('click', function() {
                privacyModal.classList.add('hidden');
                document.body.style.overflow = '';
            });
            
            privacyModal?.addEventListener('click', function(e) {
                if (e.target === privacyModal) {
                    privacyModal.classList.add('hidden');
                    document.body.style.overflow = '';
                }
            });
        });
    </script>

    <!-- ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    
    @yield('scripts')
</body>

</html>