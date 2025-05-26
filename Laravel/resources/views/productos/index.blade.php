@extends('layouts.app')

@section('title', 'Productos y Servicios')

@section('header', 'Productos y Servicios')
@section('breadcrumb', 'Gestión de Inventario')

@section('content')
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-6 flex justify-between items-center border-b">
            <h2 class="text-2xl font-bold text-gray-800">Lista de Productos y Servicios</h2>
            <a href="{{ route('productos.create') }}"
                class="bg-brand-blue hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md flex items-center transition-colors duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Nuevo Producto
            </a>
        </div>

        <!-- Los mensajes de estado ahora son manejados desde app.blade.php en un formato unificado -->

        <!-- Search and Filter -->
        <div class="p-6 bg-gray-50 border-b">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <div class="relative">
                        <input type="text" id="searchInput" placeholder="Buscar productos..."
                            class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <div class="absolute right-3 top-2 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="flex space-x-2">
                    <div class="relative">
                        <button id="stockFilterBtn"
                            class="px-4 py-2 bg-white border rounded-md hover:bg-gray-50 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 flex items-center">
                            Stock <span class="ml-1 text-xs" id="stockFilterIcon">▼</span>
                        </button>
                        <div id="stockFilterMenu"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg hidden z-10">
                            <div class="py-1">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                    data-action="stock-none">Sin filtro</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                    data-action="stock-asc">Menor a mayor</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                    data-action="stock-desc">Mayor a menor</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                    data-action="stock-low">Stock bajo (≤ 10)</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                    data-action="stock-out">Sin stock</a>
                            </div>
                        </div>
                    </div>

                    <div class="relative">
                        <button id="dateFilterBtn"
                            class="px-4 py-2 bg-white border rounded-md hover:bg-gray-50 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 flex items-center">
                            Fecha de Entrada <span class="ml-1 text-xs" id="dateFilterIcon">▼</span>
                        </button>
                        <div id="dateFilterMenu"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg hidden z-10">
                            <div class="py-1">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                    data-action="date-none">Sin filtro</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                    data-action="date-asc">Más antigua primero</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                    data-action="date-desc">Más reciente primero</a>
                            </div>
                        </div>
                    </div>

                    <div class="relative">
                        <button id="priceFilterBtn"
                            class="px-4 py-2 bg-white border rounded-md hover:bg-gray-50 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 flex items-center">
                            Precio <span class="ml-1 text-xs" id="priceFilterIcon">▼</span>
                        </button>
                        <div id="priceFilterMenu"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg hidden z-10">
                            <div class="py-1">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                    data-action="price-none">Sin filtro</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                    data-action="price-asc">Menor a mayor</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                    data-action="price-desc">Mayor a menor</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

 
  
        <!-- Products Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Descripción</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha de
                            Entrada</th>
                        <th scope="col"
                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="productsTable">
                    @forelse ($products as $product)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div
                                        class="flex-shrink-0 h-10 w-10 flex items-center justify-center bg-blue-100 rounded-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $product->Name }}</div>
                                        <div class="text-sm text-gray-500">ID: {{ $product->idProductService }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 truncate max-w-xs">
                                    {{ $product->Description ?: 'Sin descripción' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-gray-900">€{{ number_format($product->Price, 2) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($product->Stock > 10)
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        {{ $product->Stock }} unidades
                                    </span>
                                @elseif ($product->Stock > 0)
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        {{ $product->Stock }} unidades
                                    </span>
                                @else
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Sin stock
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $product->EntryDate ? $product->EntryDate->format('d/m/Y') : 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <a href="{{ route('productos.show', $product->idProductService) }}"
                                        class="text-indigo-600 hover:text-indigo-900 bg-indigo-100 hover:bg-indigo-200 p-2 rounded-md transition-colors duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('productos.edit', $product->idProductService) }}"
                                        class="text-yellow-600 hover:text-yellow-900 bg-yellow-100 hover:bg-yellow-200 p-2 rounded-md transition-colors duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('productos.destroy', $product->idProductService) }}" method="POST"
                                        class="inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-600 hover:text-red-900 bg-red-100 hover:bg-red-200 p-2 rounded-md transition-colors duration-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400 mb-3" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                    <p class="text-lg font-medium">No hay productos registrados</p>
                                    <p class="text-sm text-gray-500 mt-1">Añade nuevos productos para comenzar</p>
                                    <a href="{{ route('productos.create') }}"
                                        class="mt-4 bg-brand-blue hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md flex items-center transition-colors duration-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        Crear Producto
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>


        

        <!-- Pagination and Info -->
        <div class="px-6 py-4 bg-gray-50 border-t flex items-center justify-between">
            <div class="text-sm text-gray-500">
                Mostrando <span class="font-medium">{{ count($products) }}</span> productos
            </div>
            <!-- Add pagination here if needed -->
        </div>


        
    </div>

       <div class="my-10"></div>

    <!-- Sección de Análisis mejorada -->
    <div class="flex flex-col items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2 flex items-center gap-2">
      
            Análisis
        </h1>
    </div>

<div class="bg-gradient-to-r from-blue-600 to-indigo-600 py-6 mb-8 rounded-xl shadow-lg border border-blue-700 animate__animated animate__fadeIn">
    <div class="container mx-auto px-6">
        <h2 class="text-2xl font-bold text-white mb-2 text-center">Análisis de Productos</h2>
        <p class="text-blue-100 text-center">Estadísticas e información detallada</p>
    </div>
</div>

<div class="w-full max-w-4xl mx-auto bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 mt-6 border border-gray-200">
    <h3 class="text-xl font-semibold text-blue-700 mb-6 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
        </svg>
        Productos por Fecha
    </h3>
    <div id="productosPorFechaChart" class="animate__animated animate__fadeIn"></div>
</div>

<div class="w-full max-w-4xl mx-auto bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 mt-6 border border-gray-200">
    <h3 class="text-xl font-semibold text-green-700 mb-6 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
        </svg>
        Ventas por Producto y Fecha
    </h3>
    <div id="lineVentasPorProductoFecha" class="animate__animated animate__fadeIn"></div>
</div>

@endsection

@section('scripts')
<script>
        document.addEventListener('DOMContentLoaded', function () {
            // Productos por fecha
            const productosFechasLabels = {!! json_encode($productosFechasLabels ?? []) !!};
            const productosFechasValores = {!! json_encode($productosFechasValores ?? []) !!};
            
            const productosPorFechaOptions = {
                series: [{
                    name: 'Productos añadidos',
                    data: productosFechasValores
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
                    categories: productosFechasLabels,
                    labels: {
                        style: {
                            fontSize: '12px',
                            fontFamily: 'Poppins, sans-serif'
                        },
                        rotate: -45,
                        rotateAlways: false
                    }
                },
                yaxis: {
                    title: {
                        text: 'Cantidad',
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

            // Ventas por producto y fecha
            const fechas = {!! json_encode($fechas ?? []) !!};
            const lineChartDatasets = {!! json_encode($lineChartDatasets ?? []) !!};
            
            // Convertir datasets de Chart.js a formato ApexCharts
            const apexSeries = [];
            if (lineChartDatasets && lineChartDatasets.length > 0) {
                lineChartDatasets.forEach(dataset => {
                    apexSeries.push({
                        name: dataset.label,
                        data: dataset.data,
                        color: dataset.borderColor
            });
        });
            }
            
            const ventasPorProductoFechaOptions = {
                series: apexSeries,
                chart: {
                    type: 'line',
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
                stroke: {
                    width: 3,
                    curve: 'smooth'
                },
                markers: {
                    size: 4,
                    strokeWidth: 2,
                    hover: {
                        size: 6
                    }
                },
                xaxis: {
                    categories: fechas,
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
                legend: {
                    position: 'bottom',
                    horizontalAlign: 'center',
                    fontSize: '14px',
                    fontFamily: 'Poppins, sans-serif',
                    markers: {
                        width: 10,
                        height: 10,
                        radius: 2
                    },
                    itemMargin: {
                        horizontal: 10,
                        vertical: 8
                    }
                },
                tooltip: {
                    theme: 'dark',
                    shared: true,
                    intersect: false
                },
                grid: {
                    borderColor: '#e0e0e0',
                    strokeDashArray: 5,
                    yaxis: {
                        lines: {
                            show: true
                        }
                    },
                    padding: {
                        top: 0,
                        right: 0,
                        bottom: 0,
                        left: 10
                    }
                }
            };

            // Renderizar los gráficos
            const productosPorFechaChart = new ApexCharts(document.getElementById('productosPorFechaChart'), productosPorFechaOptions);
            productosPorFechaChart.render();
            
            const lineVentasPorProductoFecha = new ApexCharts(document.getElementById('lineVentasPorProductoFecha'), ventasPorProductoFechaOptions);
            lineVentasPorProductoFecha.render();
        });

        // Delete confirmation
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                if (confirm('¿Estás seguro que deseas eliminar este producto? Esta acción no se puede deshacer.')) {
                    this.submit();
                }
            });
        });

        // Simple search functionality
        document.getElementById('searchInput').addEventListener('keyup', function () {
            const searchValue = this.value.toLowerCase();
            const rows = document.querySelectorAll('#productsTable tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchValue) ? '' : 'none';
            });
        });

        // Dropdown toggle functions
        const stockFilterBtn = document.getElementById('stockFilterBtn');
        const stockFilterMenu = document.getElementById('stockFilterMenu');
        const priceFilterBtn = document.getElementById('priceFilterBtn');
        const priceFilterMenu = document.getElementById('priceFilterMenu');
        const stockFilterIcon = document.getElementById('stockFilterIcon');
        const priceFilterIcon = document.getElementById('priceFilterIcon');

        // Close dropdowns when clicking outside
        document.addEventListener('click', function (e) {
            if (!stockFilterBtn.contains(e.target) && !stockFilterMenu.contains(e.target)) {
                stockFilterMenu.classList.add('hidden');
            }
            if (!priceFilterBtn.contains(e.target) && !priceFilterMenu.contains(e.target)) {
                priceFilterMenu.classList.add('hidden');
            }
        });

        // Toggle stock filter dropdown
        stockFilterBtn.addEventListener('click', function () {
            stockFilterMenu.classList.toggle('hidden');
            priceFilterMenu.classList.add('hidden'); // Close other dropdown
        });

        // Toggle price filter dropdown
        priceFilterBtn.addEventListener('click', function () {
            priceFilterMenu.classList.toggle('hidden');
            stockFilterMenu.classList.add('hidden'); // Close other dropdown
        });

        // Helper function to extract numeric values
        function getNumericValue(element, type) {
            if (type === 'price') {
                // Extract price from "€xx.xx" format
                const priceText = element.querySelector('div.text-sm.font-semibold').textContent;
                return parseFloat(priceText.replace('€', '').replace(',', ''));
            } else if (type === 'stock') {
                // Extract stock number from the element
                const stockText = element.textContent;
                const match = stockText.match(/(\d+)/);
                return match ? parseInt(match[0]) : 0;
            }
            return 0;
        }


        function getDateValue(element) {
            // Espera formato dd/mm/yyyy
            const dateText = element.textContent.trim();
            const parts = dateText.split('/');
            if (parts.length === 3) {
                // yyyy-mm-dd para Date
                return new Date(parts[2], parts[1] - 1, parts[0]);
            }
            return new Date(0);
        }

        // Sort table functionality
        function sortTable(type, direction) {
    const tableBody = document.getElementById('productsTable');
    const rows = Array.from(tableBody.querySelectorAll('tr'));
    const emptyStateRow = rows.find(row => row.querySelector('td[colspan="6"]'));
    if (emptyStateRow && rows.length === 1) {
        return;
    }
    // Solo filas visibles (no display: none)
    const dataRows = rows.filter(row => !row.querySelector('td[colspan="6"]') && row.style.display !== 'none');
    dataRows.sort((a, b) => {
        let aValue, bValue;
        if (type === 'price') {
            aValue = getNumericValue(a.cells[2], 'price');
            bValue = getNumericValue(b.cells[2], 'price');
        } else if (type === 'stock') {
            aValue = getNumericValue(a.cells[3], 'stock');
            bValue = getNumericValue(b.cells[3], 'stock');
        } else if (type === 'date') {
            aValue = getDateValue(a.cells[4]);
            bValue = getDateValue(b.cells[4]);
        }
        if (type === 'date') {
            return direction === 'asc' ? aValue - bValue : bValue - aValue;
        }
        return direction === 'asc' ? aValue - bValue : bValue - aValue;
    });
    // Reinsertar solo las filas visibles ordenadas
    dataRows.forEach(row => tableBody.appendChild(row));
    // Mantener la fila de estado vacío al final si existe
    if (emptyStateRow) {
        tableBody.appendChild(emptyStateRow);
    }
}
        // Filter stock functionality
        function filterStock(action) {
            const rows = document.querySelectorAll('#productsTable tr');

            rows.forEach(row => {
                // Skip the empty state row
                if (row.querySelector('td[colspan="6"]')) return;

                const stockCell = row.querySelector('td:nth-child(4)');
                if (!stockCell) return;

                const stockText = stockCell.textContent.trim();
                const stockValue = getNumericValue(stockCell, 'stock');

                switch (action) {
                    case 'stock-none':
                        row.style.display = ''; // Show all
                        break;
                    case 'stock-low':
                        row.style.display = (stockValue > 0 && stockValue <= 10) ? '' : 'none';
                        break;
                    case 'stock-out':
                        row.style.display = (stockValue === 0 || stockText.includes('Sin stock')) ? '' : 'none';
                        break;
                    case 'stock-asc':
                        row.style.display = ''; // Will be sorted by the sortTable function
                        sortTable('stock', 'asc');
                        break;
                    case 'stock-desc':
                        row.style.display = ''; // Will be sorted by the sortTable function
                        sortTable('stock', 'desc');
                        break;
                }
            });
        }

        // Price filtering/sorting functionality
        function filterPrice(action) {
            if (action === 'price-asc') {
                sortTable('price', 'asc');
            } else if (action === 'price-desc') {
                sortTable('price', 'desc');
            } else {
                // Show all rows for 'none' option
                document.querySelectorAll('#productsTable tr').forEach(row => {
                    row.style.display = '';
                });
            }
        }

        // Add event listeners to stock filter menu items
        document.querySelectorAll('#stockFilterMenu a').forEach(item => {
            item.addEventListener('click', function (e) {
                e.preventDefault();
                const action = this.getAttribute('data-action');

                // Update button text to indicate active filter
                const filterTexts = {
                    'stock-none': 'Stock ▼',
                    'stock-asc': 'Stock (↑)',
                    'stock-desc': 'Stock (↓)',
                    'stock-low': 'Stock ≤10',
                    'stock-out': 'Sin stock'
                };

                stockFilterBtn.innerHTML = filterTexts[action];
                stockFilterMenu.classList.add('hidden');

                // Apply the filter
                filterStock(action);
            });
        });

        // Add event listeners to price filter menu items
        document.querySelectorAll('#priceFilterMenu a').forEach(item => {
            item.addEventListener('click', function (e) {
                e.preventDefault();
                const action = this.getAttribute('data-action');

                // Update button text to indicate active filter
                const filterTexts = {
                    'price-none': 'Precio ▼',
                    'price-asc': 'Precio (↑)',
                    'price-desc': 'Precio (↓)'
                };

                priceFilterBtn.innerHTML = filterTexts[action];
                priceFilterMenu.classList.add('hidden');

                // Apply the filter
                filterPrice(action);
            });
        });



        const dateFilterBtn = document.getElementById('dateFilterBtn');
        const dateFilterMenu = document.getElementById('dateFilterMenu');
        dateFilterBtn.addEventListener('click', function () {
            dateFilterMenu.classList.toggle('hidden');
            stockFilterMenu.classList.add('hidden');
            priceFilterMenu.classList.add('hidden');
        });

        // Listeners para el menú de fecha
        document.querySelectorAll('#dateFilterMenu a').forEach(item => {
            item.addEventListener('click', function (e) {
                e.preventDefault();
                const action = this.getAttribute('data-action');
                const filterTexts = {
                    'date-none': 'Fecha de Entrada ▼',
                    'date-asc': 'Más antigua primero',
                    'date-desc': 'Más reciente primero'
                };
                dateFilterBtn.innerHTML = filterTexts[action];
                dateFilterMenu.classList.add('hidden');
                if (action === 'date-asc') {
                    sortTable('date', 'asc');
                } else if (action === 'date-desc') {
                    sortTable('date', 'desc');
                } else {
                    document.querySelectorAll('#productsTable tr').forEach(row => {
                        row.style.display = '';
                    });
                }
            });
        });




    </script>
@endsection