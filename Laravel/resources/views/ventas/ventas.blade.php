@extends('layouts.app')

@section('title', 'Ventas Confirmadas')
@section('header', 'Ventas Confirmadas')
@section('breadcrumb')
    <a href="javascript:history.back()"
       class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-700 rounded hover:bg-gray-200 text-xs font-medium mr-2 transition-colors">
        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        Volver
    </a>
    Ventas / Confirmadas
@endsection

@section('content')
    <div class="max-w-5xl mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Ventas Confirmadas</h1>

<!-- Buscador de ventas -->
<div class="mb-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div class="flex gap-2 w-full md:w-1/2">
        <select id="search-field" class="px-2 py-2 border rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500">
            <option value="all">Todos los campos</option>
            <option value="1">Cliente</option>
            <option value="2">Producto</option>
            <option value="3">Cantidad</option>
            <option value="4">Importe Total</option>
            <option value="5">Estado</option>
            <option value="6">Fecha</option>
        </select>
        <input type="text" id="search-ventas" placeholder="Buscar..." 
            class="w-full px-4 py-2 border rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500" />
    </div>


       <!-- NUEVO: Selectores de orden -->
    <div class="flex gap-2 w-full md:w-1/3">
        <select id="sort-field" class="px-2 py-2 border rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500">
            <option value="0">Ordenar por ID</option>
            <option value="1">Cliente</option>
            <option value="2">Producto</option>
            <option value="3">Cantidad</option>
            <option value="4">Importe Total</option>
            <option value="5">Estado</option>
            <option value="6">Fecha</option>
        </select>
        <select id="sort-direction" class="px-2 py-2 border rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500">
            <option value="asc">Ascendente</option>
            <option value="desc">Descendente</option>
        </select>
    </div>
</div>
<!-- Fin buscador -->




<div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
    <!-- ...resto del código... -->


        <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Producto</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Importe Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($ventas as $venta)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-2">{{ $venta->idSaleDetail ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $venta->salesProposal->client->Name ?? 'Sin cliente' }}</td>
                                <td class="px-4 py-2">{{ $venta->productService->Name ?? 'Sin producto' }}</td>
                                <td class="px-4 py-2">{{ $venta->QuantitySold }}</td>
                                <td class="px-4 py-2">
                                    {{ number_format($venta->UnitPrice * $venta->QuantitySold, 2) }} €
                                </td>
                                <td class="px-4 py-2">
                                    @if($venta->salesProposal->State === 'Efectuada')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            {{ $venta->salesProposal->State }}
                                        </span>
                                    @elseif($venta->salesProposal->State === 'Cancelada')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            {{ $venta->salesProposal->State }}
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            {{ $venta->salesProposal->State }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-2">
                                    {{ $venta->created_at ? \Carbon\Carbon::parse($venta->created_at)->format('d/m/Y') : '-' }}
                                </td>
                                <td class="px-4 py-2">
                                    <a href="#"
    class="text-brand-blue hover:underline text-sm"
    data-id="{{ $venta->idSaleDetail ?? '-' }}"
    data-propuestaid="{{ $venta->salesProposal->idSalesProposals ?? '-' }}"
    data-propuestadesc="{{ $venta->salesProposal->Details ?? 'Sin descripción' }}"
    data-fechapropuesta="{{ $venta->salesProposal->CreatedAt ? \Carbon\Carbon::parse($venta->salesProposal->CreatedAt)->format('d/m/Y') : '-' }}"
    data-cliente="{{ $venta->salesProposal->client->Name ?? 'Sin cliente' }}"
    data-producto="{{ $venta->productService->Name ?? 'Sin producto' }}"
    data-cantidad="{{ $venta->QuantitySold }}"
    data-precio="{{ number_format($venta->UnitPrice, 2) }}"
    data-total="{{ number_format($venta->UnitPrice * $venta->QuantitySold, 2) }}"
    data-estado="{{ $venta->salesProposal->State }}"
    data-fecha="{{ $venta->created_at ? \Carbon\Carbon::parse($venta->created_at)->format('d/m/Y') : '-' }}"
>Ver</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-4 text-center text-gray-500">No hay ventas confirmadas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $ventas->links() }}
            </div>
        </div>
    </div>


<!-- Modal Detalle de Venta estilo tarjeta -->
<div id="ventaDetailsModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-lg w-full relative z-10 border border-gray-200">
            <button id="closeVentaModal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-2xl focus:outline-none" title="Cerrar">&times;</button>
        <div class="px-8 py-6 space-y-6">
    <!-- Bloque de información de la Venta -->
    <div class="bg-gray-50 rounded-lg p-5 shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
        <h3 class="text-lg font-medium text-brand-blue mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-brand-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M9 16h6M9 20h6M12 4v4" />
            </svg>
            Información de la Venta
        </h3>
        <div class="space-y-2">
            <div class="flex justify-between">
                <span class="font-semibold text-gray-600">ID Venta:</span>
                <span id="modalVentaId" class="text-gray-800"></span>
            </div>
            <div class="flex justify-between">
                <span class="font-semibold text-gray-600">Cliente:</span>
                <span id="modalVentaCliente" class="text-gray-800"></span>
            </div>
            <div class="flex justify-between">
                <span class="font-semibold text-gray-600">Producto:</span>
                <span id="modalVentaProducto" class="text-gray-800"></span>
            </div>
            <div class="flex justify-between">
                <span class="font-semibold text-gray-600">Cantidad:</span>
                <span id="modalVentaCantidad" class="text-gray-800"></span>
            </div>
            <div class="flex justify-between">
                <span class="font-semibold text-gray-600">Precio Unitario:</span>
                <span id="modalVentaPrecio" class="text-gray-800"></span> €
            </div>
            <div class="flex justify-between">
                <span class="font-semibold text-gray-600">Importe Total:</span>
                <span id="modalVentaTotal" class="text-gray-800"></span> €
            </div>
            <div class="flex justify-between">
                <span class="font-semibold text-gray-600">Estado:</span>
                <span id="modalVentaEstado" class="text-gray-800"></span>
            </div>
            <div class="flex justify-between">
                <span class="font-semibold text-gray-600">Fecha:</span>
                <span id="modalVentaFecha" class="text-gray-800"></span>
            </div>
        </div>
    </div>

    <!-- Bloque de información de la Propuesta -->
    <div class="bg-gray-50 rounded-lg p-5 shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
        <h3 class="text-lg font-medium text-indigo-700 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Información de la Propuesta
        </h3>
        <div class="space-y-2">
            <div class="flex justify-between">
                <span class="font-semibold text-gray-600">ID Propuesta:</span>
                <span id="modalPropuestaId" class="text-gray-800"></span>
            </div>
            <div class="flex justify-between">
                <span class="font-semibold text-gray-600">Descripción Propuesta:</span>
                <span id="modalPropuestaDesc" class="text-gray-800"></span>
            </div>
            <div class="flex justify-between">
                <span class="font-semibold text-gray-600">Fecha creación propuesta:</span>
                <span id="modalFechaPropuesta" class="text-gray-800"></span>
            </div>
        </div>
    </div>
</div>
        </div>
</div>

@endsection

@section('scripts')
<script>
    // Abrir modal con datos
    document.querySelectorAll('a.text-brand-blue').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('modalVentaId').textContent = this.dataset.id;
        document.getElementById('modalPropuestaId').textContent = this.dataset.propuestaid;
        document.getElementById('modalPropuestaDesc').textContent = this.dataset.propuestadesc;
        document.getElementById('modalFechaPropuesta').textContent = this.dataset.fechapropuesta;
        document.getElementById('modalVentaCliente').textContent = this.dataset.cliente;
        document.getElementById('modalVentaProducto').textContent = this.dataset.producto;
        document.getElementById('modalVentaCantidad').textContent = this.dataset.cantidad;
        document.getElementById('modalVentaPrecio').textContent = this.dataset.precio;
        document.getElementById('modalVentaTotal').textContent = this.dataset.total;
        document.getElementById('modalVentaEstado').textContent = this.dataset.estado;
        document.getElementById('modalVentaFecha').textContent = this.dataset.fecha;
        document.getElementById('ventaDetailsModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    });
});
    // Cerrar modal
    document.getElementById('closeVentaModal').addEventListener('click', function() {
        document.getElementById('ventaDetailsModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    });
    // Cerrar modal al hacer clic fuera de la tarjeta
    document.getElementById('ventaDetailsModal').addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    });
    // Cerrar con ESC
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && !document.getElementById('ventaDetailsModal').classList.contains('hidden')) {
            document.getElementById('ventaDetailsModal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    });

document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-ventas');
    const searchField = document.getElementById('search-field');
    const sortField = document.getElementById('sort-field');
    const sortDirection = document.getElementById('sort-direction');
    const table = document.querySelector('table');
    const tbody = table.querySelector('tbody');
    let rows = Array.from(tbody.querySelectorAll('tr'));

    // Mostrar el tipo de ordenado actual
    function mostrarOrdenActual() {
        let textoCampo = sortField.options[sortField.selectedIndex].text;
        let textoDir = sortDirection.options[sortDirection.selectedIndex].text;
        let info = document.getElementById('orden-info');
        if (!info) {
            info = document.createElement('div');
            info.id = 'orden-info';
            info.className = 'text-sm text-gray-500 mt-2';
            sortField.parentNode.appendChild(info);
        }
        }

    function filterTable() {
        const value = searchInput.value.toLowerCase();
        const field = searchField.value;

        rows.forEach(row => {
            let text = '';
            if (field === 'all') {
                text = Array.from(row.querySelectorAll('td'))
                    .map(td => td.textContent.toLowerCase())
                    .join(' ');
            } else {
                const td = row.querySelectorAll('td')[parseInt(field)];
                text = td ? td.textContent.toLowerCase() : '';
            }
            row.style.display = text.includes(value) ? '' : 'none';
        });
    }

    function sortTable() {
        const field = parseInt(sortField.value);
        const direction = sortDirection.value;

        // Solo filas visibles (filtradas)
        const visibleRows = rows.filter(row => row.style.display !== 'none');

        visibleRows.sort((a, b) => {
            const aText = a.querySelectorAll('td')[field]?.textContent.trim().toLowerCase() || '';
            const bText = b.querySelectorAll('td')[field]?.textContent.trim().toLowerCase() || '';

            // Si es cantidad, importe o id, ordenar como número
            if ([0, 3, 4].includes(field)) {
                const aNum = parseFloat(aText.replace(/[^\d,.-]/g, '').replace(',', '.')) || 0;
                const bNum = parseFloat(bText.replace(/[^\d,.-]/g, '').replace(',', '.')) || 0;
                return direction === 'asc' ? aNum - bNum : bNum - aNum;
            }
            // Si es fecha, intentar parsear
            if (field === 6) {
                const parseDate = str => {
                    const [d, m, y] = str.split('/');
                    return y && m && d ? new Date(`${y}-${m}-${d}`) : new Date(0);
                };
                const aDate = parseDate(aText);
                const bDate = parseDate(bText);
                return direction === 'asc' ? aDate - bDate : bDate - aDate;
            }
            // Texto normal
            if (aText < bText) return direction === 'asc' ? -1 : 1;
            if (aText > bText) return direction === 'asc' ? 1 : -1;
            return 0;
        });

        // Reinsertar filas ordenadas
        visibleRows.forEach(row => tbody.appendChild(row));
        mostrarOrdenActual();
    }

    function filterAndSort() {
        filterTable();
        sortTable();
    }

    if (searchInput && searchField) {
        searchInput.addEventListener('input', filterAndSort);
        searchField.addEventListener('change', filterAndSort);
    }
    if (sortField && sortDirection) {
        sortField.addEventListener('change', sortTable);
        sortDirection.addEventListener('change', sortTable);
    }

    // Mostrar el orden actual al cargar la página
    mostrarOrdenActual();
    // Aplicar orden inicial
    sortTable();
});
</script>
@endsection