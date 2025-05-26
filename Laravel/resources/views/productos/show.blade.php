@extends('layouts.app')

@section('title', 'Detalles del Producto')

@section('header', 'Detalles del Producto')
@section('breadcrumb', 'Productos / Ver detalles')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">{{ $product->Name }}</h1>
            <p class="text-sm text-gray-600">ID: {{ $product->idProductService }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('productos.index') }}" class="flex items-center text-gray-600 hover:text-gray-900">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Volver
            </a>
            <a href="{{ route('productos.edit', $product->idProductService) }}" class="flex items-center text-brand-blue hover:text-blue-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Editar
            </a>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-md rounded-lg">
        <!-- Product Summary -->
        <div class="p-6 border-b border-gray-200 flex flex-col md:flex-row">
            <div class="w-full md:w-1/3 flex justify-center md:justify-start mb-6 md:mb-0">
                <div class="w-40 h-40 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
            </div>

            <div class="w-full md:w-2/3 md:pl-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <h2 class="text-xs font-medium text-gray-500 uppercase tracking-wide">Precio</h2>
                        <p class="mt-1 text-2xl font-bold text-gray-900">€{{ number_format($product->Price, 2) }}</p>
                    </div>

                    <div>
                        <h2 class="text-xs font-medium text-gray-500 uppercase tracking-wide">Stock</h2>
                        <div class="mt-1">
                            @if ($product->Stock > 10)
                                <span class="px-2 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    {{ $product->Stock }} unidades disponibles
                                </span>
                            @elseif ($product->Stock > 0)
                                <span class="px-2 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    {{ $product->Stock }} unidades disponibles
                                </span>
                            @else
                                <span class="px-2 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Sin stock
                                </span>
                            @endif
                        </div>
                    </div>

                    <div>
                        <h2 class="text-xs font-medium text-gray-500 uppercase tracking-wide">Fecha de entrada</h2>
                        <p class="mt-1 text-gray-900">{{ $product->EntryDate ? $product->EntryDate->format('d/m/Y H:i') : 'No disponible' }}</p>
                    </div>

                    <div>
                        <h2 class="text-xs font-medium text-gray-500 uppercase tracking-wide">ID de Empresa</h2>
                        <p class="mt-1 text-gray-900">{{ $product->idEmpresa }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Description -->
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Descripción del producto</h2>
            <div class="prose max-w-none">
                @if ($product->Description)
                    <p class="text-gray-700">{{ $product->Description }}</p>
                @else
                    <p class="text-gray-500 italic">No hay descripción disponible para este producto.</p>
                @endif
            </div>
        </div>

        <!-- Related Information -->
        <div class="bg-gray-50 p-6 border-t border-gray-200">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Operaciones</h2>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('productos.edit', $product->idProductService) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-brand-blue hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Editar producto
                </a>
                
                <form action="{{ route('productos.destroy', $product->idProductService) }}" method="POST" class="inline delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Eliminar producto
                    </button>
                </form>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <div class="border border-gray-200 rounded-lg shadow-sm p-4">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Historial de ventas</h3>
                <div id="ventasPorProductoChart"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Delete confirmation
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            if (confirm('¿Estás seguro que deseas eliminar este producto? Esta acción no se puede deshacer.')) {
                this.submit();
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const productosLabels = {!! json_encode($productosLabels ?? []) !!};
        const productosValores = {!! json_encode($productosValores ?? []) !!};
        
        const ventasOptions = {
            series: [{
                name: 'Ventas totales',
                data: productosValores
            }],
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
                categories: productosLabels,
                labels: {
                    style: {
                        fontSize: '12px',
                        fontFamily: 'Poppins, sans-serif'
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

        const ventasChart = new ApexCharts(document.getElementById('ventasPorProductoChart'), ventasOptions);
        ventasChart.render();
    });
</script>
@endsection 