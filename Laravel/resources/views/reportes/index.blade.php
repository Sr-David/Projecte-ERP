@extends('layouts.app')

@section('title', 'Reportes')
@section('header', 'Reportes y Estadísticas')
@section('breadcrumb', 'Dashboard / Reportes')

@section('styles')
<style>
    .chart-container {
        position: relative;
        height: 300px;
        width: 100%;
    }

    .metric-card {
        transition: all 0.3s ease;
    }

    .metric-card:hover {
        transform: translateY(-5px);
    }
</style>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Filtros -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-3 md:space-y-0">
            <h3 class="text-lg font-semibold text-gray-800">Filtros</h3>
            
            <div class="flex flex-wrap gap-3">
                <select id="period-filter" class="rounded-md border-gray-300 shadow-sm focus:border-brand-blue focus:ring focus:ring-brand-blue focus:ring-opacity-50 text-sm">
                    <option value="7">Últimos 7 días</option>
                    <option value="30" selected>Últimos 30 días</option>
                    <option value="90">Últimos 3 meses</option>
                    <option value="180">Últimos 6 meses</option>
                    <option value="365">Último año</option>
                </select>
                
                <div class="flex rounded-md shadow-sm">
                    <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                        Desde
                    </span>
                    <input type="date" id="start-date" class="rounded-none rounded-r-md border-gray-300 focus:border-brand-blue focus:ring focus:ring-brand-blue focus:ring-opacity-50 block w-full text-sm" value="{{ date('Y-m-d', strtotime('-30 days')) }}">
                </div>
                
                <div class="flex rounded-md shadow-sm">
                    <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                        Hasta
                    </span>
                    <input type="date" id="end-date" class="rounded-none rounded-r-md border-gray-300 focus:border-brand-blue focus:ring focus:ring-brand-blue focus:ring-opacity-50 block w-full text-sm" value="{{ date('Y-m-d') }}">
                </div>
                
                <button id="apply-filters" class="bg-brand-blue hover:bg-blue-600 text-white py-2 px-4 rounded-md text-sm font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-blue">
                    Aplicar
                </button>
            </div>
        </div>
    </div>
    
    <!-- Tarjetas de Métricas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Clientes -->
        <div class="bg-white rounded-lg shadow-sm p-6 metric-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total de Clientes</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-1">128</h3>
                    <p class="text-xs text-green-600 flex items-center mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586l3.293-3.293A1 1 0 0112 7z" clip-rule="evenodd" />
                        </svg>
                        <span>12% más que el mes pasado</span>
                    </p>
                </div>
                <div class="bg-blue-50 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-brand-blue" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Ventas -->
        <div class="bg-white rounded-lg shadow-sm p-6 metric-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total de Ventas</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-1">€24,580</h3>
                    <p class="text-xs text-green-600 flex items-center mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586l3.293-3.293A1 1 0 0112 7z" clip-rule="evenodd" />
                        </svg>
                        <span>8.2% más que el mes pasado</span>
                    </p>
                </div>
                <div class="bg-green-50 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Proyectos -->
        <div class="bg-white rounded-lg shadow-sm p-6 metric-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total de Proyectos</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-1">42</h3>
                    <p class="text-xs text-green-600 flex items-center mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586l3.293-3.293A1 1 0 0112 7z" clip-rule="evenodd" />
                        </svg>
                        <span>15% más que el mes pasado</span>
                    </p>
                </div>
                <div class="bg-purple-50 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Leads -->
        <div class="bg-white rounded-lg shadow-sm p-6 metric-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Leads Activos</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-1">56</h3>
                    <p class="text-xs text-yellow-600 flex items-center mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                        </svg>
                        <span>2% menos que el mes pasado</span>
                    </p>
                </div>
                <div class="bg-yellow-50 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Gráficos -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Gráfico de Ventas -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Ventas Mensuales</h3>
            <div class="chart-container">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
        
        <!-- Gráfico de Clientes -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Nuevos Clientes</h3>
            <div class="chart-container">
                <canvas id="clientsChart"></canvas>
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Gráfico Distribución de Ventas -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Distribución de Ventas por Categoría</h3>
            <div class="chart-container">
                <canvas id="salesDistributionChart"></canvas>
            </div>
        </div>
        
        <!-- Estado de Leads -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Estado de Leads</h3>
            <div class="chart-container">
                <canvas id="leadsChart"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Tabla de Rendimiento -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Productos/Servicios con Mejor Rendimiento</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Producto/Servicio
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Ventas
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Ingresos
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Crecimiento
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">Servicio de Consultoría</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">87</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">€12,354</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                +24%
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">Desarrollo Web</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">64</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">€9,845</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                +18%
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">Marketing Digital</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">51</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">€7,240</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                +4%
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">Soporte Técnico</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">42</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">€5,150</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                -2%
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Colores de la aplicación
    const brandBlue = '#3F95FF';
    const brandBlueLight = '#D1E5FF';
    const brandGreen = '#4CAF50';
    const brandPurple = '#9C27B0';
    const brandYellow = '#FFC107';
    
    // Configuración común para los gráficos de línea
    const lineChartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'top',
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    drawBorder: false
                }
            },
            x: {
                grid: {
                    display: false,
                    drawBorder: false
                }
            }
        }
    };

    // Datos para el gráfico de ventas
    const salesChartData = {
        labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        datasets: [{
            label: 'Ventas 2023',
            data: [12000, 14500, 13000, 15500, 16200, 17500, 18000, 19500, 22000, 24580, 0, 0],
            borderColor: brandBlue,
            backgroundColor: 'rgba(63, 149, 255, 0.1)',
            borderWidth: 2,
            fill: true,
            tension: 0.4
        }, {
            label: 'Ventas 2022',
            data: [10000, 11800, 12500, 13200, 14500, 15200, 16000, 17200, 18500, 19800, 20600, 22500],
            borderColor: '#E2E8F0',
            borderWidth: 2,
            tension: 0.4,
            borderDash: [5, 5]
        }]
    };

    // Datos para el gráfico de clientes
    const clientsChartData = {
        labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        datasets: [{
            label: 'Nuevos Clientes',
            data: [8, 12, 10, 15, 18, 14, 16, 19, 22, 26, 0, 0],
            borderColor: brandGreen,
            backgroundColor: 'rgba(76, 175, 80, 0.1)',
            borderWidth: 2,
            fill: true,
            tension: 0.4
        }]
    };

    // Datos para el gráfico de distribución de ventas
    const salesDistributionChartData = {
        labels: ['Consultoría', 'Desarrollo Web', 'Marketing Digital', 'Soporte Técnico', 'Diseño Gráfico'],
        datasets: [{
            data: [35, 25, 20, 15, 5],
            backgroundColor: [brandBlue, brandGreen, brandPurple, brandYellow, '#FF5722'],
            borderWidth: 0
        }]
    };

    // Datos para el gráfico de estado de leads
    const leadsChartData = {
        labels: ['Nuevo', 'Contactado', 'Cualificado', 'Propuesta', 'Negociación', 'Cerrado'],
        datasets: [{
            data: [25, 20, 15, 10, 8, 22],
            backgroundColor: [brandBlueLight, '#BBDEFB', '#90CAF9', '#64B5F6', '#42A5F5', brandBlue],
            borderWidth: 0
        }]
    };

    // Función para inicializar los gráficos cuando el documento esté listo
    document.addEventListener('DOMContentLoaded', function() {
        // Gráfico de Ventas
        const salesChart = new Chart(
            document.getElementById('salesChart'),
            {
                type: 'line',
                data: salesChartData,
                options: lineChartOptions
            }
        );

        // Gráfico de Clientes
        const clientsChart = new Chart(
            document.getElementById('clientsChart'),
            {
                type: 'line',
                data: clientsChartData,
                options: lineChartOptions
            }
        );
        
        // Gráfico de Distribución de Ventas
        const salesDistributionChart = new Chart(
            document.getElementById('salesDistributionChart'),
            {
                type: 'doughnut',
                data: salesDistributionChartData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right'
                        }
                    }
                }
            }
        );
        
        // Gráfico de Estado de Leads
        const leadsChart = new Chart(
            document.getElementById('leadsChart'),
            {
                type: 'bar',
                data: leadsChartData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    indexAxis: 'y',
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            grid: {
                                display: false,
                                drawBorder: false
                            }
                        },
                        y: {
                            grid: {
                                display: false,
                                drawBorder: false
                            }
                        }
                    }
                }
            }
        );
        
        // Gestionar los filtros
        document.getElementById('period-filter').addEventListener('change', function(e) {
            const days = parseInt(e.target.value);
            const end = new Date();
            const start = new Date();
            start.setDate(end.getDate() - days);
            
            document.getElementById('start-date').value = formatDate(start);
            document.getElementById('end-date').value = formatDate(end);
        });
        
        document.getElementById('apply-filters').addEventListener('click', function() {
            // Aquí iría la lógica para recargar los datos según los filtros
            alert('Aplicando filtros... (Esta funcionalidad se implementaría con datos reales)');
        });
        
        // Función auxiliar para formatear fechas como YYYY-MM-DD
        function formatDate(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }
    });
</script>
@endsection 