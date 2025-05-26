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
                <div id="salesChart"></div>
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
                <div id="clientsChart"></div>
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
                Ventas por Producto
            </h3>
            <div class="chart-container h-64">
                <div id="salesDistributionChart"></div>
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
                <div id="leadsChart"></div>
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
<script>
    // Definir algunos colores para los gráficos
    const brandBlue = '#3F95FF';
    const brandGreen = '#10b981';
    const brandPurple = '#8b5cf6';
    const brandAmber = '#f59e0b';
    const brandRed = '#ef4444';
    
    // Datos para los gráficos
    const salesData = {!! json_encode($salesChartData['data']) !!};
    const clientsData = {!! json_encode($clientsChartData['data']) !!};
    const salesDistributionLabels = {!! json_encode($salesDistributionData['labels']) !!};
    const salesDistributionValues = {!! json_encode($salesDistributionData['data']) !!};
    const salesDistributionColors = {!! json_encode($salesDistributionData['colors']) !!};
    const leadsLabels = {!! json_encode($leadsStatusData['labels']) !!};
    const leadsValues = {!! json_encode($leadsStatusData['data']) !!};
    const leadsColors = {!! json_encode($leadsStatusData['colors']) !!};

    // Depuración - Verificar si los datos están llegando
    console.log('Datos de ventas por producto:', {
        labels: salesDistributionLabels,
        values: salesDistributionValues,
        colors: salesDistributionColors
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Gráfico de ventas
        const salesChartOptions = {
            series: [{
                name: 'Ventas',
                data: salesData
            }],
            chart: {
                type: 'area',
                height: 300,
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
                    dynamicAnimation: {
                        enabled: true,
                        speed: 350
                    }
                }
            },
            colors: [brandBlue],
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'light',
                    type: 'vertical',
                    shadeIntensity: 0.3,
                    opacityFrom: 0.7,
                    opacityTo: 0.2,
                    stops: [0, 90, 100]
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
                categories: {!! json_encode($salesChartData['labels']) !!},
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
                        return '€' + new Intl.NumberFormat('es-ES').format(val);
                    },
                    style: {
                        colors: '#666',
                        fontSize: '12px'
                    }
                }
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return '€' + new Intl.NumberFormat('es-ES').format(val);
                    }
                },
                theme: 'dark'
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
                colors: [brandBlue],
                strokeColors: '#fff',
                strokeWidth: 2,
                hover: {
                    size: 7
                }
            }
        };

        // Gráfico de clientes
        const clientsChartOptions = {
            series: [{
                name: 'Nuevos Clientes',
                data: clientsData
            }],
            chart: {
                type: 'bar',
                height: 300,
                fontFamily: 'Poppins, sans-serif',
                toolbar: {
                    show: true
                },
                animations: {
                    enabled: true,
                    dynamicAnimation: {
                        speed: 350
                    }
                }
            },
            colors: [brandGreen],
            plotOptions: {
                bar: {
                    borderRadius: 5,
                    columnWidth: '60%',
                    dataLabels: {
                        position: 'top'
                    }
                }
            },
            dataLabels: {
                enabled: false
            },
            xaxis: {
                categories: {!! json_encode($clientsChartData['labels']) !!},
                labels: {
                    style: {
                        colors: '#666',
                        fontSize: '12px'
                    }
                }
            },
            yaxis: {
                labels: {
                    formatter: function(val) {
                        return val.toFixed(0);
                    },
                    style: {
                        colors: '#666',
                        fontSize: '12px'
                    }
                }
            },
            tooltip: {
                theme: 'dark'
            },
                            grid: {
                borderColor: '#e0e0e0',
                strokeDashArray: 5,
                yaxis: {
                    lines: {
                        show: true
                    }
                }
            }
        };

        // Gráfico de distribución de ventas
        const salesDistributionChartOptions = {
            series: salesDistributionValues,
            chart: {
                type: 'donut',
                height: 300,
                fontFamily: 'Poppins, sans-serif'
            },
            labels: salesDistributionLabels,
            colors: salesDistributionColors,
            plotOptions: {
                pie: {
                    donut: {
                        size: '70%',
                        labels: {
                            show: true,
                            name: {
                                show: true,
                                fontSize: '16px'
                            },
                            value: {
                                show: true,
                                fontSize: '20px',
                                formatter: function(val) {
                                    return '€' + new Intl.NumberFormat('es-ES').format(val);
                                }
                            },
                            total: {
                                show: true,
                                label: 'Total',
                                fontSize: '16px',
                                formatter: function(w) {
                                    const total = w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                    return '€' + new Intl.NumberFormat('es-ES').format(total);
                                }
                            }
                        }
                    }
                }
            },
            dataLabels: {
                enabled: false
            },
            legend: {
                position: 'right',
                fontSize: '14px',
                fontFamily: 'Poppins, sans-serif',
                labels: {
                    colors: '#666'
                },
                markers: {
                    width: 12,
                    height: 12,
                    strokeWidth: 0,
                    radius: 12
                },
                itemMargin: {
                    horizontal: 8,
                    vertical: 5
                }
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return '€' + new Intl.NumberFormat('es-ES').format(val);
                    }
                },
                theme: 'dark'
            },
            stroke: {
                width: 0
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 300
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };

        // Gráfico de leads
        const leadsChartOptions = {
            series: [{
                name: 'Leads',
                data: leadsValues
            }],
            chart: {
                type: 'bar',
                height: 300,
                fontFamily: 'Poppins, sans-serif',
                toolbar: {
                    show: false
                }
            },
            colors: leadsColors,
            plotOptions: {
                bar: {
                    horizontal: true,
                    distributed: true,
                    borderRadius: 5,
                    barHeight: '70%',
                    dataLabels: {
                        position: 'center'
                    }
                }
            },
            dataLabels: {
                enabled: true,
                textAnchor: 'start',
                style: {
                    colors: ['#fff']
                },
                formatter: function(val, opt) {
                    const total = leadsValues.reduce((a, b) => a + b, 0);
                    const percentage = ((val * 100) / total).toFixed(1);
                    return val + ` (${percentage}%)`;
                },
                offsetX: 0
            },
            xaxis: {
                categories: leadsLabels,
                labels: {
                    style: {
                        colors: '#666',
                        fontSize: '12px'
                    }
                }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: '#666',
                        fontSize: '12px'
                    }
                }
            },
            tooltip: {
                theme: 'dark',
                y: {
                    formatter: function(val) {
                        const total = leadsValues.reduce((a, b) => a + b, 0);
                        const percentage = ((val * 100) / total).toFixed(1);
                        return val + ` (${percentage}%)`;
                    }
                }
            },
            grid: {
                show: false
            }
        };

        // Renderizar los gráficos
        const salesChart = new ApexCharts(document.getElementById('salesChart'), salesChartOptions);
        salesChart.render();

        const clientsChart = new ApexCharts(document.getElementById('clientsChart'), clientsChartOptions);
        clientsChart.render();

        // Verificar si el contenedor existe
        const salesDistributionContainer = document.getElementById('salesDistributionChart');
        console.log('Contenedor del gráfico de ventas por producto:', salesDistributionContainer);
        
        if (salesDistributionContainer) {
            // Verificar si hay datos
            if (salesDistributionValues && salesDistributionValues.length > 0) {
                const salesDistributionChart = new ApexCharts(salesDistributionContainer, salesDistributionChartOptions);
                salesDistributionChart.render();
            } else {
                console.error('No hay datos para el gráfico de ventas por producto');
                salesDistributionContainer.innerHTML = '<div class="flex items-center justify-center h-full"><div class="text-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg><p class="mt-2 text-gray-500">No hay datos disponibles para mostrar</p></div></div>';
            }
        } else {
            console.error('No se encontró el contenedor del gráfico de ventas por producto');
        }

        const leadsChart = new ApexCharts(document.getElementById('leadsChart'), leadsChartOptions);
        leadsChart.render();
        
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