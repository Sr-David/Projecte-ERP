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
                            <p class="text-2xl font-semibold text-gray-900">{{ $stats['clients']['total'] }}</p>
                            <p class="ml-2 text-sm font-medium {{ $stats['clients']['growth'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $stats['clients']['growth'] >= 0 ? '+' : '' }}{{ $stats['clients']['growth'] }}%
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('clients.index') }}" class="text-sm font-medium text-brand-blue hover:underline">
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
                            <p class="text-2xl font-semibold text-gray-900">{{ $stats['projects']['total'] }}</p>
                            <p class="ml-2 text-sm font-medium {{ $stats['projects']['growth'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $stats['projects']['growth'] >= 0 ? '+' : '' }}{{ $stats['projects']['growth'] }}%
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('proyectos.index') }}" class="text-sm font-medium text-indigo-600 hover:underline">
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
                            <p class="text-2xl font-semibold text-gray-900">${{ number_format($stats['sales']['total'], 2) }}</p>
                            <p class="ml-2 text-sm font-medium {{ $stats['sales']['growth'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $stats['sales']['growth'] >= 0 ? '+' : '' }}{{ $stats['sales']['growth'] }}%
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('ventas.resumen') }}" class="text-sm font-medium text-green-600 hover:underline">
                        Ver detalles
                    </a>
                </div>
            </div>
            
            <!-- (Notas) -->
            <div class="card bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                <div class="flex items-center">
        <div class="flex-shrink-0 bg-purple-100 rounded-full p-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                        </svg>
                    </div>
                    <div class="ml-4">
            <h3 class="text-sm font-medium text-gray-500">Notas</h3>
                        <div class="mt-1 flex items-baseline">
                <p class="text-2xl font-semibold text-gray-900">{{ $stats['notes']['total'] }}</p>
                <p class="ml-2 text-sm font-medium {{ $stats['notes']['change'] <= 0 ? 'text-gray-600' : 'text-gray-600' }}">
                    {{ $stats['notes']['change'] >= 0 ? '+' : '' }}{{ $stats['notes']['change'] }}
                </p>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
        <a href="{{ route('notes.index') }}" class="text-sm font-medium text-purple-600 hover:underline">
            Ver notas
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
                    <select id="period-selector" class="bg-white border border-gray-300 rounded-md text-gray-700 px-3 py-1 pr-8 text-sm focus:outline-none focus:ring-2 focus:ring-brand-blue/50">
                        <option value="year">Este Año</option>
                        <option value="month">Este Mes</option>
                        <option value="last-month">Último Mes</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="relative h-64">
                <div id="salesChart" class="w-full h-full"></div>
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
                    @foreach($recentActivities as $activity)
                    <li class="py-4">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <span class="h-8 w-8 rounded-full 
                                    @if($activity['type'] == 'client') bg-blue-100 
                                    @elseif($activity['type'] == 'project_completed') bg-green-100 
                                    @elseif($activity['type'] == 'project_created') bg-indigo-100 
                                    @elseif($activity['type'] == 'note') bg-yellow-100 
                                    @endif
                                    flex items-center justify-center">
                                    @if($activity['type'] == 'client')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-brand-blue" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                    @elseif($activity['type'] == 'project_completed')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    @elseif($activity['type'] == 'project_created')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                    </svg>
                                    @elseif($activity['type'] == 'note')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                    @endif
                                </span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">
                                    {{ $activity['title'] }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    {{ $activity['detail'] }}
                                </p>
                            </div>
                            <div class="flex-shrink-0 text-right">
                                <p class="text-sm text-gray-500">
                                    {{ $activity['time'] }}
                                </p>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="mt-8">
        <h2 class="text-lg font-medium text-gray-900 mb-4">Acciones Rápidas</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('clients.create') }}" class="block p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-50 transition-colors duration-200">
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
            
            <a href="{{ route('proyectos.create') }}" class="block p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-50 transition-colors duration-200">
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
            
            <a href="{{ route('ventas.propuestas.create') }}" class="block p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-50 transition-colors duration-200">
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
            
            <a href="{{ route('notes.create') }}" class="block p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-50 transition-colors duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-purple-100 rounded-full p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-900">Crear Nota</h3>
                        <p class="text-xs text-gray-500 mt-1">Añadir una nueva nota</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Datos de ventas
        const salesData = @json($salesData);
        
        // Configurar el gráfico de ventas con ApexCharts
        const salesChartOptions = {
            series: [{
                name: 'Ventas Mensuales',
                data: salesData.map(item => item.amount)
            }],
            chart: {
                type: 'area',
                height: 350,
                fontFamily: 'Poppins, sans-serif',
                toolbar: {
                    show: true,
                    tools: {
                        download: true,
                        selection: true,
                        zoom: true,
                        zoomin: true,
                        zoomout: true,
                        pan: true,
                    }
                },
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800,
                    animateGradually: {
                        enabled: true,
                        delay: 150
                    },
                    dynamicAnimation: {
                        enabled: true,
                        speed: 350
                    }
                }
            },
            colors: ['#3F95FF'],
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'light',
                    type: 'vertical',
                    shadeIntensity: 0.3,
                    opacityFrom: 0.7,
                    opacityTo: 0.2,
                    stops: [0, 100]
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 3
            },
            xaxis: {
                categories: salesData.map(item => item.month + ' ' + item.year),
                labels: {
                    style: {
                        colors: '#666',
                        fontSize: '12px',
                        fontFamily: 'Poppins, sans-serif',
                        fontWeight: 500
                    }
                }
            },
            yaxis: {
                labels: {
                    formatter: function(val) {
                        return '€' + val.toFixed(2);
                    },
                    style: {
                        colors: '#666',
                        fontSize: '12px',
                        fontFamily: 'Poppins, sans-serif',
                        fontWeight: 500
                    }
                }
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return '€' + val.toFixed(2);
                    }
                },
                theme: 'dark',
                x: {
                    show: true
                }
            },
            grid: {
                borderColor: '#e0e0e0',
                strokeDashArray: 5,
                xaxis: {
                    lines: {
                        show: true
                    }
                },
                yaxis: {
                    lines: {
                        show: true
                    }
                }
            },
            markers: {
                size: 5,
                colors: ['#3F95FF'],
                strokeColors: '#fff',
                strokeWidth: 2,
                hover: {
                    size: 7
                }
            }
        };

        const salesChart = new ApexCharts(document.getElementById('salesChart'), salesChartOptions);
        salesChart.render();
        
        // Cambiar datos según el período seleccionado
        document.getElementById('period-selector').addEventListener('change', function() {
            const period = this.value;
            let filteredData = [];
            
            if (period === 'year') {
                filteredData = salesData;
            } else if (period === 'month') {
                // Filtrar para mostrar solo el mes actual
                const currentMonth = new Date().getMonth();
                const currentYear = new Date().getFullYear();
                filteredData = salesData.filter(item => {
                    const date = new Date(`${item.month} 1, ${item.year}`);
                    return date.getMonth() === currentMonth && date.getFullYear() === currentYear;
                });
            } else if (period === 'last-month') {
                // Filtrar para mostrar solo el mes anterior
                let lastMonth = new Date().getMonth() - 1;
                let year = new Date().getFullYear();
                if (lastMonth < 0) {
                    lastMonth = 11;
                    year -= 1;
                }
                filteredData = salesData.filter(item => {
                    const date = new Date(`${item.month} 1, ${item.year}`);
                    return date.getMonth() === lastMonth && date.getFullYear() === year;
                });
            }
            
            // Actualizar el gráfico
            salesChart.updateOptions({
                xaxis: {
                    categories: filteredData.map(item => item.month + ' ' + item.year)
                }
            });
            salesChart.updateSeries([{
                name: 'Ventas Mensuales',
                data: filteredData.map(item => item.amount)
            }]);
        });
    });
</script>
@endsection 