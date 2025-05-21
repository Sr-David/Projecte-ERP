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
    </style>

    @yield('styles')
</head>

<body class="bg-gray-50 antialiased">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside
            class="fixed inset-y-0 left-0 w-64 bg-white shadow-lg z-10 transition-all duration-300 ease-in-out transform"
            id="sidebar">
            <!-- Logo -->
            <div class="p-4 border-b flex items-center justify-center h-16">
                <a href="{{ url('/dashboard') }}" class="flex items-center">
                    <img src="/images/logoElevate.png" alt="Elevate CRM" class="h-8">
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

                    <!-- Ajustes -->
                    <a href="{{ url('/ajustes') }}"
                        class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->is('ajustes*') ? 'sidebar-active' : 'text-gray-700 hover:bg-gray-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="mr-3 h-5 w-5 {{ request()->is('ajustes*') ? 'text-brand-blue' : 'text-gray-500 group-hover:text-gray-600' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Ajustes
                    </a>
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
                            <p class="text-sm font-medium text-gray-700 group-hover:text-gray-900">Admin User</p>
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
                            <!-- Notifications -->
                            <button type="button"
                                class="relative p-1 rounded-full text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-blue">
                                <span class="sr-only">Ver notificaciones</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                <!-- Notification Badge -->
                                <span
                                    class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>
                            </button>

                            <!-- Help -->
                            <button type="button"
                                class="p-1 rounded-full text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-blue">
                                <span class="sr-only">Ayuda</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </button>

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

    <!-- Scripts -->
    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-btn')?.addEventListener('click', function () {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('-translate-x-full');
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
    </script>

    @yield('scripts')
</body>

</html>