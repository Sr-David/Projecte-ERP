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
                <div class="w-full max-w-full">
                    <div id="productoPorFechaChart" class="animate__animated animate__fadeIn"></div>
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
                        <div id="ventasVsPropuestasChart" class="animate__animated animate__fadeIn"></div>
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
                        <div id="ventasPorProductoChart" class="animate__animated animate__fadeIn"></div>
                    </div>
                </div>
            </div>

        </div>
        ...
@endsection

    @section('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Gráfico circular de ventas vs propuestas
                const ventasVsPropuestasOptions = {
                    series: [{{ $ventasCount }}, {{ $propuestasCount }}],
                    chart: {
                        type: 'donut',
                        height: 350,
                        fontFamily: 'Poppins, sans-serif',
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
                    labels: ['Ventas Confirmadas', 'Propuestas de Venta'],
                    colors: ['#3F95FF', '#6366F1'],
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '70%',
                                labels: {
                                    show: true,
                                    name: {
                                        show: true,
                                        fontSize: '16px',
                                        fontFamily: 'Poppins, sans-serif',
                                        fontWeight: 600,
                                        offsetY: -10
                                    },
                                    value: {
                                        show: true,
                                        fontSize: '26px',
                                        fontFamily: 'Poppins, sans-serif',
                                        fontWeight: 600,
                                        offsetY: 5,
                                        formatter: function (val) {
                                            return val;
                                        }
                                    },
                                    total: {
                                        show: true,
                                        label: 'Total',
                                        fontSize: '16px',
                                        fontWeight: 600,
                                        formatter: function (w) {
                                            return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                        }
                                    }
                                }
                            }
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        width: 3,
                        colors: ['#E5EFFF']
                    },
                    legend: {
                        position: 'bottom',
                        fontFamily: 'Poppins, sans-serif',
                        fontSize: '14px',
                        fontWeight: 600,
                        markers: {
                            width: 12,
                            height: 12,
                            strokeWidth: 0,
                            radius: 12
                        },
                        itemMargin: {
                            horizontal: 8,
                            vertical: 8
                        }
                    },
                    tooltip: {
                        theme: 'dark',
                        y: {
                            formatter: function(val, opts) {
                                const total = opts.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                const percentage = ((val * 100) / total).toFixed(1);
                                return `${val} (${percentage}%)`;
                            }
                        }
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

                const ventasVsPropuestasChart = new ApexCharts(document.getElementById('ventasVsPropuestasChart'), ventasVsPropuestasOptions);
                ventasVsPropuestasChart.render();

                // Gráfico de ventas por producto
                const ventasPorProductoOptions = {
                    series: {!! json_encode($productosValores ?? []) !!},
                    chart: {
                    type: 'pie',
                        height: 350,
                        fontFamily: 'Poppins, sans-serif',
                        animations: {
                            enabled: true,
                            easing: 'easeinout',
                            speed: 800
                        }
                    },
                        labels: {!! json_encode($productosLabels ?? []) !!},
                    colors: ['#3F95FF', '#6366F1', '#16BA81', '#F59E42', '#F43F5E', '#A855F7', '#FACC15', '#10B981'],
                    dataLabels: {
                        enabled: true,
                        formatter: function (val, opts) {
                            return opts.w.globals.labels[opts.seriesIndex] + ": " + val.toFixed(1) + "%";
                        },
                        style: {
                            fontSize: '14px',
                            fontFamily: 'Poppins, sans-serif',
                            fontWeight: 'bold'
                        },
                        dropShadow: {
                            enabled: true,
                            blur: 3,
                            opacity: 0.4
                        }
                    },
                    stroke: {
                        width: 2,
                        colors: ['#fff']
                    },
                    legend: {
                        position: 'bottom',
                        fontFamily: 'Poppins, sans-serif',
                        fontSize: '14px',
                        fontWeight: 600
                    },
                    tooltip: {
                        theme: 'dark',
                        y: {
                            formatter: function(val, opts) {
                                const total = opts.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                const percentage = ((val * 100) / total).toFixed(1);
                                return `${val} (${percentage}%)`;
                            }
                        }
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

                const ventasPorProductoChart = new ApexCharts(document.getElementById('ventasPorProductoChart'), ventasPorProductoOptions);
                ventasPorProductoChart.render();

                // Gráfico de ventas por producto específico a lo largo del tiempo
                const ventasPorProductoParaSelector = @json($ventasPorProductoParaSelector);
                const selector = document.getElementById('productoSelector');

                function getChartData(productId) {
                    const datos = ventasPorProductoParaSelector[productId];
                    
                    return {
                        series: [{
                            name: datos ? datos.nombre : '',
                            data: datos ? datos.valores : []
                        }],
                        xaxis: {
                            categories: datos ? datos.fechas : []
                        }
                    };
                }

                // Inicializar con el primer producto
                let currentProductId = selector.value;
                let chartData = getChartData(currentProductId);
                
                const productoPorFechaOptions = {
                    series: chartData.series,
                    chart: {
                    type: 'bar',
                        height: 350,
                        fontFamily: 'Poppins, sans-serif',
                        toolbar: {
                            show: true
                        },
                        animations: {
                            enabled: true,
                            easing: 'easeinout',
                            speed: 800
                        }
                    },
                    colors: ['#3F95FF'],
                    plotOptions: {
                        bar: {
                            borderRadius: 4,
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
                        categories: chartData.xaxis.categories,
                        title: {
                            text: 'Fecha',
                            style: {
                                fontSize: '14px',
                                fontFamily: 'Poppins, sans-serif',
                                fontWeight: 600
                            }
                        }
                    },
                    yaxis: {
                        title: {
                            text: 'Ventas',
                            style: {
                                fontSize: '14px',
                                fontFamily: 'Poppins, sans-serif',
                                fontWeight: 600
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

                const productoPorFechaChart = new ApexCharts(document.getElementById('productoPorFechaChart'), productoPorFechaOptions);
                productoPorFechaChart.render();

                // Actualizar el gráfico cuando cambia la selección de producto
                selector.addEventListener('change', function () {
                    currentProductId = this.value;
                    const newData = getChartData(currentProductId);
                    
                    productoPorFechaChart.updateOptions({
                        xaxis: {
                            categories: newData.xaxis.categories
                        }
                    });
                    
                    productoPorFechaChart.updateSeries(newData.series);
                });
            });
        </script>
    @endsection