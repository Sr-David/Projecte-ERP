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

    .card-animation {
        animation: fadeInUp 0.5s ease-out forwards;
    }

    .chart-container canvas {
        max-height: 100%;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .gradient-blue {
        background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
    }
    
    .gradient-green {
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
    }
    
    .gradient-purple {
        background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);
    }
    
    .gradient-amber {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }
</style>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Filtros -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-3 md:space-y-0">
            <h3 class="text-lg font-semibold text-gray-800">Filtros</h3>
            
            <form action="{{ route('reportes.index') }}" method="GET" class="flex flex-wrap gap-3">
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
                    <input type="date" id="start-date" name="start_date" class="rounded-none rounded-r-md border-gray-300 focus:border-brand-blue focus:ring focus:ring-brand-blue focus:ring-opacity-50 block w-full text-sm" value="{{ isset($startDate) ? $startDate->format('Y-m-d') : date('Y-m-d', strtotime('-30 days')) }}">
                </div>
                
                <div class="flex rounded-md shadow-sm">
                    <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                        Hasta
                    </span>
                    <input type="date" id="end-date" name="end_date" class="rounded-none rounded-r-md border-gray-300 focus:border-brand-blue focus:ring focus:ring-brand-blue focus:ring-opacity-50 block w-full text-sm" value="{{ isset($endDate) ? $endDate->format('Y-m-d') : date('Y-m-d') }}">
                </div>
                
                <button type="submit" id="apply-filters" class="bg-brand-blue hover:bg-blue-600 text-white py-2 px-4 rounded-md text-sm font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-blue">
                    Aplicar
                </button>
            </form>
        </div>
    </div>
    
    <!-- Tarjetas de Métricas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Clientes -->
        <div class="bg-white rounded-lg shadow-sm p-6 metric-card card-animation" style="animation-delay: 0.1s">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total de Clientes</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['clients']['total'] }}</h3>
                    <p class="text-xs {{ $stats['clients']['growth'] >= 0 ? 'text-green-600' : 'text-red-600' }} flex items-center mt-1">
                        @if($stats['clients']['growth'] >= 0)
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586l3.293-3.293A1 1 0 0112 7z" clip-rule="evenodd" />
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12 13a1 1 0 100 2h5a1 1 0 001-1V9a1 1 0 10-2 0v2.586l-4.293-4.293a1 1 0 00-1.414 0L8 9.586l-4.293-4.293a1 1 0 00-1.414 1.414l5 5a1 1 0 001.414 0L11 9.414l3.293 3.293A1 1 0 0012 13z" clip-rule="evenodd" />
                            </svg>
                        @endif
                        <span>{{ abs($stats['clients']['growth']) }}% {{ $stats['clients']['growth'] >= 0 ? 'más' : 'menos' }} que el período anterior</span>
                    </p>
                </div>
                <div class="gradient-blue p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Ventas -->
        <div class="bg-white rounded-lg shadow-sm p-6 metric-card card-animation" style="animation-delay: 0.2s">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total de Ventas</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-1">€{{ number_format($stats['sales']['total'], 2) }}</h3>
                    <p class="text-xs {{ $stats['sales']['growth'] >= 0 ? 'text-green-600' : 'text-red-600' }} flex items-center mt-1">
                        @if($stats['sales']['growth'] >= 0)
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586l3.293-3.293A1 1 0 0112 7z" clip-rule="evenodd" />
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12 13a1 1 0 100 2h5a1 1 0 001-1V9a1 1 0 10-2 0v2.586l-4.293-4.293a1 1 0 00-1.414 0L8 9.586l-4.293-4.293a1 1 0 00-1.414 1.414l5 5a1 1 0 001.414 0L11 9.414l3.293 3.293A1 1 0 0012 13z" clip-rule="evenodd" />
                            </svg>
                        @endif
                        <span>{{ abs($stats['sales']['growth']) }}% {{ $stats['sales']['growth'] >= 0 ? 'más' : 'menos' }} que el período anterior</span>
                    </p>
                </div>
                <div class="gradient-green p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Proyectos -->
        <div class="bg-white rounded-lg shadow-sm p-6 metric-card card-animation" style="animation-delay: 0.3s">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Proyectos Activos</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['projects']['total'] }}</h3>
                    <p class="text-xs {{ $stats['projects']['growth'] >= 0 ? 'text-green-600' : 'text-red-600' }} flex items-center mt-1">
                        @if($stats['projects']['growth'] >= 0)
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586l3.293-3.293A1 1 0 0112 7z" clip-rule="evenodd" />
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12 13a1 1 0 100 2h5a1 1 0 001-1V9a1 1 0 10-2 0v2.586l-4.293-4.293a1 1 0 00-1.414 0L8 9.586l-4.293-4.293a1 1 0 00-1.414 1.414l5 5a1 1 0 001.414 0L11 9.414l3.293 3.293A1 1 0 0012 13z" clip-rule="evenodd" />
                            </svg>
                        @endif
                        <span>{{ abs($stats['projects']['growth']) }}% {{ $stats['projects']['growth'] >= 0 ? 'más' : 'menos' }} que el período anterior</span>
                    </p>
                </div>
                <div class="gradient-purple p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Leads -->
        <div class="bg-white rounded-lg shadow-sm p-6 metric-card card-animation" style="animation-delay: 0.4s">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Leads Activos</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['leads']['total'] }}</h3>
                    <p class="text-xs {{ $stats['leads']['growth'] >= 0 ? 'text-green-600' : 'text-red-600' }} flex items-center mt-1">
                        @if($stats['leads']['growth'] >= 0)
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586l3.293-3.293A1 1 0 0112 7z" clip-rule="evenodd" />
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12 13a1 1 0 100 2h5a1 1 0 001-1V9a1 1 0 10-2 0v2.586l-4.293-4.293a1 1 0 00-1.414 0L8 9.586l-4.293-4.293a1 1 0 00-1.414 1.414l5 5a1 1 0 001.414 0L11 9.414l3.293 3.293A1 1 0 0012 13z" clip-rule="evenodd" />
                            </svg>
                        @endif
                        <span>{{ abs($stats['leads']['growth']) }}% {{ $stats['leads']['growth'] >= 0 ? 'más' : 'menos' }} que el período anterior</span>
                    </p>
                </div>
                <div class="gradient-amber p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Gráficos -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 py-6 mb-8 rounded-xl shadow-lg border border-blue-700 card-animation" style="animation-delay: 0.5s">
        <div class="container mx-auto px-6">
            <h2 class="text-2xl font-bold text-white mb-2 text-center">Dashboard de Reportes</h2>
            <p class="text-blue-100 text-center">Análisis y estadísticas de rendimiento del {{ $startDate->format('d/m/Y') }} al {{ $endDate->format('d/m/Y') }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Gráfico de Ventas -->
        <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-200 card-animation" style="animation-delay: 0.6s">
            <h3 class="text-xl font-semibold text-blue-700 mb-4 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                Ventas
            </h3>
            <div class="chart-container h-64">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
        
        <!-- Gráfico de Clientes -->
        <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-200 card-animation" style="animation-delay: 0.7s">
            <h3 class="text-xl font-semibold text-green-600 mb-4 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Nuevos Clientes
            </h3>
            <div class="chart-container h-64">
                <canvas id="clientsChart"></canvas>
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Gráfico Distribución de Ventas -->
        <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-200 card-animation" style="animation-delay: 0.8s">
            <h3 class="text-xl font-semibold text-indigo-600 mb-4 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                </svg>
                Distribución de Ventas por Categoría
            </h3>
            <div class="chart-container h-64">
                <canvas id="salesDistributionChart"></canvas>
            </div>
        </div>
        
        <!-- Estado de Leads -->
        <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-200 card-animation" style="animation-delay: 0.9s">
            <h3 class="text-xl font-semibold text-purple-600 mb-4 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                Estado de Leads
            </h3>
            <div class="chart-container h-64">
                <canvas id="leadsChart"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Tabla de Rendimiento -->
    <div class="bg-white rounded-lg shadow-sm p-6 card-animation" style="animation-delay: 1s">
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
                    @forelse ($topProducts as $product)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $product->Name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $product->quantity }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">€{{ number_format($product->revenue, 2) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $product->growth >= 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $product->growth >= 0 ? '+' : '' }}{{ $product->growth }}%
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                            No hay datos disponibles para el período seleccionado
                        </td>
                    </tr>
                    @endforelse
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
            },
            tooltip: {
                backgroundColor: 'rgba(17, 24, 39, 0.9)',
                titleFont: {
                    size: 13,
                    weight: 'bold',
                    family: "'Inter', sans-serif"
                },
                bodyFont: {
                    size: 12,
                    family: "'Inter', sans-serif"
                },
                padding: 12,
                cornerRadius: 8,
                boxPadding: 6
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(226, 232, 240, 0.6)',
                    drawBorder: false
                }
            },
            x: {
                grid: {
                    display: false,
                    drawBorder: false
                }
            }
        },
        elements: {
            point: {
                radius: 3,
                hoverRadius: 5,
                borderWidth: 2
            },
            line: {
                tension: 0.3
            }
        }
    };

    // Datos para el gráfico de ventas
    const salesChartData = {
        labels: {!! json_encode($salesChartData['labels']) !!},
        datasets: [{
            label: 'Ventas',
            data: {!! json_encode($salesChartData['data']) !!},
            borderColor: brandBlue,
            backgroundColor: 'rgba(63, 149, 255, 0.1)',
            borderWidth: 2,
            fill: true
        }]
    };

    // Datos para el gráfico de clientes
    const clientsChartData = {
        labels: {!! json_encode($clientsChartData['labels']) !!},
        datasets: [{
            label: 'Nuevos Clientes',
            data: {!! json_encode($clientsChartData['data']) !!},
            borderColor: brandGreen,
            backgroundColor: 'rgba(76, 175, 80, 0.1)',
            borderWidth: 2,
            fill: true
        }]
    };

    // Datos para el gráfico de distribución de ventas
    const salesDistributionChartData = {
        labels: {!! json_encode($salesDistributionData['labels']) !!},
        datasets: [{
            label: 'Distribución de Ventas',
            data: {!! json_encode($salesDistributionData['data']) !!},
            backgroundColor: {!! json_encode($salesDistributionData['colors']) !!},
            borderWidth: 0
        }]
    };

    // Datos para el gráfico de estado de leads
    const leadsChartData = {
        labels: {!! json_encode($leadsStatusData['labels']) !!},
        datasets: [{
            label: 'Estado de Leads',
            data: {!! json_encode($leadsStatusData['data']) !!},
            backgroundColor: {!! json_encode($leadsStatusData['colors']) !!},
            borderWidth: 0
        }]
    };

    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar gráfico de ventas
        const salesChart = new Chart(
            document.getElementById('salesChart'),
            {
                type: 'line',
                data: salesChartData,
                options: {
                    ...lineChartOptions,
                    plugins: {
                        legend: {
                            position: 'top'
                        },
                        tooltip: {
                            backgroundColor: 'rgba(17, 24, 39, 0.9)',
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += new Intl.NumberFormat('es-ES', { style: 'currency', currency: 'EUR' }).format(context.parsed.y);
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                }
            }
        );

        // Inicializar gráfico de clientes
        const clientsChart = new Chart(
            document.getElementById('clientsChart'),
            {
                type: 'bar',
                data: clientsChartData,
                options: {
                    ...lineChartOptions,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(226, 232, 240, 0.6)',
                                drawBorder: false
                            },
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            }
        );

        // Inicializar gráfico de distribución de ventas
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
                            position: 'right',
                            labels: {
                                font: {
                                    size: 11
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(17, 24, 39, 0.9)',
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.parsed;
                                    const total = context.dataset.data.reduce((acc, data) => acc + data, 0);
                                    const percentage = Math.round((value / total) * 100);
                                    const amount = new Intl.NumberFormat('es-ES', { style: 'currency', currency: 'EUR' }).format(value);
                                    return `${label}: ${amount} (${percentage}%)`;
                                }
                            }
                        }
                    },
                    cutout: '70%',
                    elements: {
                        arc: {
                            borderWidth: 0
                        }
                    }
                }
            }
        );

        // Inicializar gráfico de leads
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
                        },
                        tooltip: {
                            backgroundColor: 'rgba(17, 24, 39, 0.9)',
                            callbacks: {
                                label: function(context) {
                                    const value = context.parsed.x;
                                    const total = context.dataset.data.reduce((acc, data) => acc + data, 0);
                                    const percentage = Math.round((value / total) * 100);
                                    return `${context.dataset.label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            grid: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                precision: 0
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