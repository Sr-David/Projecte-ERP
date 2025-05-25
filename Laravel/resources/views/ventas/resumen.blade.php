@extends('layouts.app')


@section('content')
    <div class="flex flex-col flex-1 justify-center">

        <div class="max-w-4xl mx-auto py-8 flex-1">
            <h1 class="text-2xl font-bold mb-6">Resumen de Ventas</h1>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded shadow p-6 flex flex-col items-center">
                    <span class="text-4xl font-bold text-brand-blue">{{ $ventasCount }}</span>
                    <span class="mt-2 text-lg">Ventas confirmadas</span>
                    <a href="{{ route('ventas.ventas') }}"
                        class="mt-4 px-4 py-2 bg-brand-blue text-white rounded hover:bg-blue-700">Ver todas</a>
                </div>
                <div class="bg-white rounded shadow p-6 flex flex-col items-center">
                    <span class="text-4xl font-bold text-indigo-600">{{ $propuestasCount }}</span>
                    <span class="mt-2 text-lg">Propuestas de venta</span>
                    <a href="{{ route('ventas.propuestas') }}"
                        class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Ver todas</a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="col-span-2">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 py-6 mb-8 rounded-xl shadow-lg border border-blue-700 animate__animated animate__fadeIn">
                    <div class="container mx-auto px-6">
                        <h1 class="text-2xl font-bold text-white mb-2 text-center">Resumen de Ventas</h1>
                        <p class="text-blue-100 text-center">Análisis detallado del rendimiento comercial</p>
                    </div>
                </div>
            </div>
            
            <div class="col-span-2 bg-white rounded-xl shadow-lg p-6 mt-6 hover:shadow-xl transition-all duration-300 animate__animated animate__fadeIn">
                <h2 class="text-xl font-semibold text-blue-700 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                    </svg>
                    Ventas por Fecha de Producto
                </h2>
                <div class="mb-4">
                    <label for="productoSelector" class="block text-sm font-medium text-gray-700 mb-1">Selecciona un
                        producto:</label>
                    <select id="productoSelector" class="rounded-lg border-gray-300 px-4 py-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                        <option value="all">Todos los productos</option>
                        @foreach($productos as $producto)
                            <option value="{{ $producto->idProductService }}">{{ $producto->Name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="chart-container h-80">
                    <canvas id="productoPorFechaChart" class="animate__animated animate__fadeIn"></canvas>
                </div>
            </div>
            
            <div class="col-span-2 bg-white rounded-xl shadow-lg p-6 mt-6 hover:shadow-xl transition-all duration-300 animate__animated animate__fadeIn animate__delay-1s">
                <h2 class="text-xl font-semibold text-indigo-700 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                    </svg>
                    Proporción Ventas Confirmadas / Propuestas
                </h2>
                <div class="flex flex-col md:flex-row justify-center items-center gap-8 bg-white p-4 rounded-lg">
                    <div class="w-full md:w-1/2 max-w-xs">
                        <canvas id="ventasVsPropuestasChart" class="animate__animated animate__fadeIn"></canvas>
                    </div>
                    <div class="flex flex-col items-center animate__animated animate__fadeInRight">
                        @php
                            $conversion = ($propuestasCount > 0) ? round(($ventasCount / $propuestasCount) * 100, 1) : 0;
                        @endphp
                        <span class="text-5xl font-bold text-brand-blue">{{ $conversion }}%</span>
                        <span class="mt-2 text-gray-600 text-center">Conversión de propuesta a venta confirmada</span>
                        <div class="mt-4 px-5 py-2 bg-blue-50 rounded-full text-blue-800 text-sm font-medium border border-blue-100">
                            {{ $ventasCount }} ventas de {{ $propuestasCount }} propuestas
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-2 bg-white rounded-xl shadow-lg p-6 mt-6 hover:shadow-xl transition-all duration-300 animate__animated animate__fadeIn animate__delay-2s">
                <h2 class="text-xl font-semibold text-green-700 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    Ventas por Producto
                </h2>
                <div class="flex justify-center">
                    <div class="w-full max-w-md">
                        <canvas id="ventasPorProductoChart" class="animate__animated animate__fadeIn"></canvas>
                    </div>
                </div>
            </div>

        </div>
        ...
@endsection

    @section('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Gráfico de barras
                // const ctx = document.getElementById('ventasPorFechaChart').getContext('2d');
                // const ventasPorFechaChart = new Chart(ctx, {
                //     type: 'bar',
                //     data: {
                //         labels: {!! json_encode($labels) !!},
                //         datasets: [{
                //             label: 'Ventas',
                //             data: {!! json_encode($valores) !!},
                //             backgroundColor: '#3F95FF'
                //         }]
                //     },
                //     options: {
                //         responsive: true,
                //         maintainAspectRatio: false,
                //         scales: {
                //             x: { title: { display: true, text: 'Fecha' } },
                //             y: { beginAtZero: true, title: { display: true, text: 'Ventas' } }
                //         }
                //     }
                // });

                // Gráfico circular
                const ctxDoughnut = document.getElementById('ventasVsPropuestasChart').getContext('2d');
                new Chart(ctxDoughnut, {
                    type: 'doughnut',
                    data: {
                        labels: ['Ventas Confirmadas', 'Propuestas de Venta'],
                        datasets: [{
                            data: [{{ $ventasCount }}, {{ $propuestasCount }}],
                            backgroundColor: ['#3F95FF', '#6366F1'],
                            borderColor: ['#E5EFFF', '#E5EFFF'],
                            borderWidth: 3,
                            hoverOffset: 15,
                            borderRadius: 5
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        cutout: '70%',
                        layout: {
                            padding: 20
                        },
                        animation: {
                            animateScale: true,
                            animateRotate: true,
                            duration: 2000,
                            easing: 'easeOutQuart'
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'bottom',
                                labels: {
                                    color: '#1A1A1A',
                                    font: { 
                                        weight: 'bold',
                                        size: 12
                                    },
                                    padding: 20
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0,0,0,0.8)',
                                bodyFont: {
                                    size: 14
                                },
                                padding: 15,
                                cornerRadius: 8,
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.raw;
                                        const total = context.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                                        const percentage = Math.round((value / total) * 100);
                                        return `${label}: ${value} (${percentage}%)`;
                                    }
                                }
                            }
                        }
                    }
                });




                const ctxPie = document.getElementById('ventasPorProductoChart').getContext('2d');
                new Chart(ctxPie, {
                    type: 'pie',
                    data: {
                        labels: {!! json_encode($productosLabels ?? []) !!},
                        datasets: [{
                            data: {!! json_encode($productosValores ?? []) !!},
                            backgroundColor: [
                                '#3F95FF', '#6366F1', '#16BA81', '#F59E42', '#F43F5E', '#A855F7', '#FACC15', '#10B981'
                            ],
                            borderColor: '#fff',
                            borderWidth: 2
                        }]
                    },
                    options: {
                        plugins: {
                            legend: {
                                display: true,
                                position: 'bottom',
                                labels: {
                                    color: '#1A1A1A',
                                    font: { weight: 'bold' }
                                }
                            }
                        }
                    }
                });




                const ventasPorProductoParaSelector = @json($ventasPorProductoParaSelector);

                const selector = document.getElementById('productoSelector');
                const ctxProducto = document.getElementById('productoPorFechaChart').getContext('2d');

                function getChartData(productId) {
                    const datos = ventasPorProductoParaSelector[productId];
                    return {
                        labels: datos ? datos.fechas : [],
                        datasets: [{
                            label: datos ? datos.nombre : '',
                            data: datos ? datos.valores : [],
                            backgroundColor: '#3F95FF'
                        }]
                    };
                }

                // Inicializar con el primer producto
                let currentProductId = selector.value;
                let productoChart = new Chart(ctxProducto, {
                    type: 'bar',
                    data: getChartData(currentProductId),
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: { title: { display: true, text: 'Fecha' } },
                            y: { beginAtZero: true, title: { display: true, text: 'Ventas' } }
                        }
                    }
                });

                selector.addEventListener('change', function () {
                    currentProductId = this.value;
                    const newData = getChartData(currentProductId);
                    productoChart.data = newData;
                    productoChart.update();
                });



            });
        </script>
    @endsection