@extends('layouts.app')

@section('title', 'Dashboard')
@section('header', 'Panel de Control')
@section('breadcrumb', 'Inicio')

@section('content')
    <!-- Dashboard Overview -->
    <div class="mb-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Resumen General</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Clientes -->
            <div class="card bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-blue-100 rounded-full p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-brand-blue" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-500">Total Clientes</h3>
                        <div class="mt-1 flex items-baseline">
                            <p class="text-2xl font-semibold text-gray-900">127</p>
                            <p class="ml-2 text-sm font-medium text-green-600">+8%</p>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="#" class="text-sm font-medium text-brand-blue hover:underline">
                        Ver todos
                    </a>
                </div>
            </div>
            
            <!-- Proyectos Activos -->
            <div class="card bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-indigo-100 rounded-full p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-500">Proyectos Activos</h3>
                        <div class="mt-1 flex items-baseline">
                            <p class="text-2xl font-semibold text-gray-900">34</p>
                            <p class="ml-2 text-sm font-medium text-green-600">+12%</p>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="#" class="text-sm font-medium text-indigo-600 hover:underline">
                        Ver todos
                    </a>
                </div>
            </div>
            
            <!-- Facturación Mensual -->
            <div class="card bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-100 rounded-full p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-500">Facturación Mensual</h3>
                        <div class="mt-1 flex items-baseline">
                            <p class="text-2xl font-semibold text-gray-900">$45,280</p>
                            <p class="ml-2 text-sm font-medium text-green-600">+5.2%</p>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="#" class="text-sm font-medium text-green-600 hover:underline">
                        Ver detalles
                    </a>
                </div>
            </div>
            
            <!-- Tickets de Soporte -->
            <div class="card bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-red-100 rounded-full p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.5 9.5l5 5" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-500">Tickets de Soporte</h3>
                        <div class="mt-1 flex items-baseline">
                            <p class="text-2xl font-semibold text-gray-900">8</p>
                            <p class="ml-2 text-sm font-medium text-red-600">-2</p>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="#" class="text-sm font-medium text-red-600 hover:underline">
                        Resolver tickets
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Charts & Tables -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Growth Chart -->
        <div class="card bg-white rounded-lg shadow-sm p-6 border border-gray-200">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-medium text-gray-900">Crecimiento de Ventas</h3>
                <div class="relative">
                    <select class="bg-white border border-gray-300 rounded-md text-gray-700 px-3 py-1 pr-8 text-sm focus:outline-none focus:ring-2 focus:ring-brand-blue/50">
                        <option>Este Año</option>
                        <option>Este Mes</option>
                        <option>Último Mes</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="relative h-64">
                <img src="/images/growing-chart.svg" alt="Gráfico de Crecimiento" class="w-full h-full object-contain">
            </div>
        </div>
        
        <!-- Recent Activities -->
        <div class="card bg-white rounded-lg shadow-sm p-6 border border-gray-200">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-medium text-gray-900">Actividades Recientes</h3>
                <a href="#" class="text-sm font-medium text-brand-blue hover:underline">
                    Ver todas
                </a>
            </div>
            <div class="flow-root">
                <ul class="-my-5 divide-y divide-gray-200">
                    <li class="py-4">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <span class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-brand-blue" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">
                                    Nuevo cliente registrado
                                </p>
                                <p class="text-sm text-gray-500">
                                    Empresa Acme S.L.
                                </p>
                            </div>
                            <div class="flex-shrink-0 text-right">
                                <p class="text-sm text-gray-500">
                                    Hace 30 min
                                </p>
                            </div>
                        </div>
                    </li>
                    <li class="py-4">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <span class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">
                                    Proyecto completado
                                </p>
                                <p class="text-sm text-gray-500">
                                    Desarrollo E-commerce
                                </p>
                            </div>
                            <div class="flex-shrink-0 text-right">
                                <p class="text-sm text-gray-500">
                                    Hace 2 horas
                                </p>
                            </div>
                        </div>
                    </li>
                    <li class="py-4">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <span class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                    </svg>
                                </span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">
                                    Nuevo proyecto creado
                                </p>
                                <p class="text-sm text-gray-500">
                                    Rediseño de tienda online
                                </p>
                            </div>
                            <div class="flex-shrink-0 text-right">
                                <p class="text-sm text-gray-500">
                                    Hace 5 horas
                                </p>
                            </div>
                        </div>
                    </li>
                    <li class="py-4">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <span class="h-8 w-8 rounded-full bg-yellow-100 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                </span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">
                                    Nuevo ticket de soporte
                                </p>
                                <p class="text-sm text-gray-500">
                                    Problema con el servidor
                                </p>
                            </div>
                            <div class="flex-shrink-0 text-right">
                                <p class="text-sm text-gray-500">
                                    Hace 1 día
                                </p>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="mt-8">
        <h2 class="text-lg font-medium text-gray-900 mb-4">Acciones Rápidas</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="#" class="block p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-50 transition-colors duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-brand-blue/10 rounded-full p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-brand-blue" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-900">Nuevo Cliente</h3>
                        <p class="text-xs text-gray-500 mt-1">Registrar un nuevo cliente</p>
                    </div>
                </div>
            </a>
            
            <a href="#" class="block p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-50 transition-colors duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-indigo-100 rounded-full p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-900">Nuevo Proyecto</h3>
                        <p class="text-xs text-gray-500 mt-1">Crear un nuevo proyecto</p>
                    </div>
                </div>
            </a>
            
            <a href="#" class="block p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-50 transition-colors duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-100 rounded-full p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-900">Nueva Factura</h3>
                        <p class="text-xs text-gray-500 mt-1">Generar una nueva factura</p>
                    </div>
                </div>
            </a>
            
            <a href="#" class="block p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-50 transition-colors duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-purple-100 rounded-full p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-900">Enviar Comunicación</h3>
                        <p class="text-xs text-gray-500 mt-1">Notificar a todos los clientes</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Aquí podrían ir scripts específicos para el dashboard
</script>
@endsection 