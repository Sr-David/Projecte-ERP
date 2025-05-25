@extends('layouts.app')

@section('title', 'Propuestas de Venta')
@section('header', 'Propuestas de Venta')
@section('breadcrumb')
    <a href="javascript:history.back()"
       class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-700 rounded hover:bg-gray-200 text-xs font-medium mr-2 transition-colors">
        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        Volver
    </a>
    Ventas / Propuestas
@endsection

@section('content')
    <div class="max-w-5xl mx-auto py-8">


    
        <h1 class="text-2xl font-bold mb-6">Propuestas de Venta</h1>

        <div class="mb-4 flex justify-end">
            <a href="{{ route('ventas.propuestas.create') }}"
                class="inline-flex items-center px-4 py-2 bg-brand-blue text-white rounded hover:bg-blue-700 text-sm font-medium shadow">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Nueva Propuesta
            </a>
        </div>

        <!-- Buscador y orden -->
<div class="mb-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div class="flex gap-2 w-full md:w-1/2">
        <select id="search-field" class="px-2 py-2 border rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500">
            <option value="all">Todos los campos</option>
            <option value="1">Cliente</option>
            <option value="2">Estado</option>
            <option value="3">Fecha</option>
        </select>
        <input type="text" id="search-propuestas" placeholder="Buscar..." 
            class="w-full px-4 py-2 border rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500" />
    </div>
    <div class="flex gap-2 w-full md:w-1/3">
        <select id="sort-field" class="px-2 py-2 border rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500">
            <option value="0">Ordenar por ID</option>
            <option value="1">Cliente</option>
            <option value="2">Estado</option>
            <option value="3">Fecha</option>
        </select>
        <select id="sort-direction" class="px-2 py-2 border rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500">
            <option value="asc">Ascendente</option>
            <option value="desc">Descendente</option>
        </select>
    </div>
</div>
<!-- Fin buscador y orden -->

        <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Habilitación</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($propuestas as $propuesta)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-2">{{ $propuesta->idSalesProposals ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $propuesta->client->Name ?? 'Sin cliente' }}</td>
                                <td class="px-4 py-2">
                                    @if($propuesta->State === 'Efectuada')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            {{ $propuesta->State }}
                                        </span>
                                    @elseif($propuesta->State === 'Cancelada')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            {{ $propuesta->State }}
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            {{ $propuesta->State }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-2">
                                    {{ $propuesta->CreatedAt ? \Carbon\Carbon::parse($propuesta->CreatedAt)->format('d/m/Y') : '-' }}
                                </td>
                                <td class="px-4 py-2">
                                    @if($propuesta->State === 'Cancelada')
                                        <form action="{{ route('ventas.propuestas.rehabilitar', $propuesta->idSalesProposals) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="inline-flex items-center px-3 py-1 bg-yellow-500 text-white rounded text-xs hover:bg-yellow-600 transition-colors"
                                                onclick="return confirm('¿Seguro que quieres volver a habilitar esta propuesta?')">
                                                Volver a habilitar
                                            </button>
                                        </form>
                                    @elseif($propuesta->State !== 'Efectuada')
                                        <a href="{{ route('ventas.propuestas.confirmar', $propuesta->idSalesProposals) }}"
                                        class="inline-flex items-center px-3 py-1 bg-brand-blue text-white rounded text-xs hover:bg-blue-700 mr-2 transition-colors">
                                            Confirmar
                                        </a>
                                        <form action="{{ route('ventas.propuestas.cancelar', $propuesta->idSalesProposals) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="inline-flex items-center px-3 py-1 bg-red-500 text-white rounded text-xs hover:bg-red-600 transition-colors"
                                                onclick="return confirm('¿Seguro que quieres cancelar esta propuesta?')">
                                                Cancelar
                                            </button>
                                        </form>
                                    @elseif($propuesta->State === 'Efectuada')
                                        <span class="inline-flex items-center px-3 py-1 bg-gray-400 text-white rounded text-xs cursor-not-allowed mr-2">
                                            Efectuada
                                        </span>
                                        <a href="{{ route('ventas.propuestas.confirmar', $propuesta->idSalesProposals) }}"
                                        class="inline-flex items-center px-3 py-1 bg-brand-blue text-white rounded text-xs hover:bg-blue-700">
                                            Volver a realizar
                                        </a>
                                    @endif

                                    
                                </td>

                                <td>
                                    <button
                                        class="ver-propuesta-btn inline-flex items-center px-2 py-1 text-brand-blue text-xs transition-colors hover:bg-brand-blue hover:text-blue-700"
                                        data-id="{{ $propuesta->idSalesProposals ?? '-' }}"
                                        data-cliente="{{ $propuesta->client->Name ?? 'Sin cliente' }}"
                                        data-estado="{{ $propuesta->State ?? '-' }}"
                                        data-fecha="{{ $propuesta->CreatedAt ? \Carbon\Carbon::parse($propuesta->CreatedAt)->format('d/m/Y') : '-' }}"
                                        data-desc="{{ $propuesta->Details ?? 'Sin descripción' }}"
                                        title="Ver detalles"
                                    >
                                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Ver
                                    </button>
                                    <a href="{{ route('ventas.propuestas.edit', $propuesta->idSalesProposals) }}"
                                        class="inline-flex items-center px-2 py-1 text-brand-blue text-xs transition-colors hover:bg-brand-blue hover:text-blue-700 rounded ml-1"
                                        title="Editar propuesta">
                                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15.232 5.232l3.536 3.536M9 13l6-6m2 2l-6 6m-2 2h2v2a2 2 0 002 2h2a2 2 0 002-2v-2h2a2 2 0 002-2v-2a2 2 0 00-2-2h-2v-2a2 2 0 00-2-2h-2a2 2 0 00-2 2v2H7a2 2 0 00-2 2v2a2 2 0 002 2h2z" />
                                            </svg>
                                            Editar
                                    </a>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-4 text-center text-gray-500">No hay propuestas registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $propuestas->links() }}
            </div>
        </div>
    </div>













<!-- Modal Detalle de Propuesta -->
<div id="propuestaDetailsModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-lg w-full relative z-10 border border-gray-200">
            <button id="closePropuestaModal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-2xl focus:outline-none" title="Cerrar">&times;</button>
            <div class="px-8 py-6 space-y-6">
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
                            <span class="font-semibold text-gray-600">Cliente:</span>
                            <span id="modalPropuestaCliente" class="text-gray-800"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-semibold text-gray-600">Estado:</span>
                            <span id="modalPropuestaEstado" class="text-gray-800"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-semibold text-gray-600">Fecha creación:</span>
                            <span id="modalPropuestaFecha" class="text-gray-800"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-semibold text-gray-600">Descripción:</span>
                            <span id="modalPropuestaDesc" class="text-gray-800"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.querySelectorAll('.ver-propuesta-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            document.getElementById('modalPropuestaId').textContent = this.dataset.id;
            document.getElementById('modalPropuestaCliente').textContent = this.dataset.cliente;
            document.getElementById('modalPropuestaEstado').textContent = this.dataset.estado;
            document.getElementById('modalPropuestaFecha').textContent = this.dataset.fecha;
            document.getElementById('modalPropuestaDesc').textContent = this.dataset.desc;

            document.getElementById('propuestaDetailsModal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        });
    });

    document.getElementById('closePropuestaModal').addEventListener('click', function() {
        document.getElementById('propuestaDetailsModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    });
    document.getElementById('propuestaDetailsModal').addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    });
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && !document.getElementById('propuestaDetailsModal').classList.contains('hidden')) {
            document.getElementById('propuestaDetailsModal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    });



     document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search-propuestas');
        const searchField = document.getElementById('search-field');
        const sortField = document.getElementById('sort-field');
        const sortDirection = document.getElementById('sort-direction');
        const table = document.querySelector('table');
        const tbody = table.querySelector('tbody');
        let rows = Array.from(tbody.querySelectorAll('tr'));

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

                // Si es id, ordenar como número
                if (field === 0) {
                    const aNum = parseFloat(aText.replace(/[^\d,.-]/g, '').replace(',', '.')) || 0;
                    const bNum = parseFloat(bText.replace(/[^\d,.-]/g, '').replace(',', '.')) || 0;
                    return direction === 'asc' ? aNum - bNum : bNum - aNum;
                }
                // Si es fecha, intentar parsear
                if (field === 3) {
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
@endsection