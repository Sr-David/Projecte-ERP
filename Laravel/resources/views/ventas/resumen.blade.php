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
            <h1 class="text-2xl font-bold mb-6">Análisis</h1>

            
                  <div class="col-span-2 bg-white rounded shadow p-6 mt-6">
                <h2 class="text-lg font-semibold mb-4">Ventas por Fecha de Producto</h2>
                <div class="mb-4">
                    <label for="productoSelector" class="block text-sm font-medium text-gray-700 mb-1">Selecciona un
                        producto:</label>
                    <select id="productoSelector" class="rounded border-gray-300 px-3 py-2">
                        <option value="all">Todos los productos</option>
                        @foreach($productos as $producto)
                            <option value="{{ $producto->idProductService }}">{{ $producto->Name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="chart-container" style="height:300px;">
                    <canvas id="productoPorFechaChart"></canvas>
                </div>
            </div>
            
            
            <!-- <div class="col-span-2 bg-white rounded shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Ventas por Fecha</h2>
                <div class="chart-container" style="height:300px;">
                    <canvas id="ventasPorFechaChart"></canvas>
                </div>
            </div> -->


            <div class="col-span-2 bg-white rounded shadow p-6 mt-6">
                <h2 class="text-lg font-semibold mb-4">Proporción Ventas Confirmadas / Propuestas</h2>
                <div class="flex justify-center items-center gap-8">
                    <div style="width:260px; height:260px;">
                        <canvas id="ventasVsPropuestasChart"></canvas>
                    </div>
                    <div class="flex flex-col items-center">
                        @php
                            $conversion = ($propuestasCount > 0) ? round(($ventasCount / $propuestasCount) * 100, 1) : 0;
                        @endphp
                        <span class="text-4xl font-bold text-brand-blue">{{ $conversion }}%</span>
                        <span class="mt-2 text-gray-600 text-center text-sm">Conversión de propuesta a venta
                            confirmada</span>
                    </div>
                </div>
            </div>

            <div class="col-span-2 bg-white rounded shadow p-6 mt-6">
                <h2 class="text-lg font-semibold mb-4">Ventas por Producto</h2>
                <div class="flex justify-center">
                    <div style="width:320px; height:320px;">
                        <canvas id="ventasPorProductoChart"></canvas>
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
                            borderWidth: 2
                        }]
                    },
                    options: {
                        cutout: '70%',
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