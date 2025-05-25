@extends('layouts.app')


@section('content')
<div class="flex flex-col flex-1 justify-center">
    
    <div class="max-w-4xl mx-auto py-8 flex-1">
        <h1 class="text-2xl font-bold mb-6">Resumen de Ventas</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded shadow p-6 flex flex-col items-center">
                <span class="text-4xl font-bold text-brand-blue">{{ $ventasCount }}</span>
                <span class="mt-2 text-lg">Ventas confirmadas</span>
                <a href="{{ route('ventas.ventas') }}" class="mt-4 px-4 py-2 bg-brand-blue text-white rounded hover:bg-blue-700">Ver todas</a>
            </div>
            <div class="bg-white rounded shadow p-6 flex flex-col items-center">
                <span class="text-4xl font-bold text-indigo-600">{{ $propuestasCount }}</span>
                <span class="mt-2 text-lg">Propuestas de venta</span>
                <a href="{{ route('ventas.propuestas') }}" class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Ver todas</a>
            </div>
        </div>
    </div>

 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <h1 class="text-2xl font-bold mb-6">Análisis</h1>

        <div class="col-span-2 bg-white rounded shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Ventas por Fecha</h2>
            <div class="chart-container" style="height:300px;">
                <canvas id="ventasPorFechaChart"></canvas>
            </div>
        </div>
    </div>
...
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('ventasPorFechaChart').getContext('2d');
    const ventasPorFechaChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($labels ?? ['01/06', '02/06', '03/06', '04/06', '05/06']) !!}, // Fechas
            datasets: [{
                label: 'Ventas',
                data: {!! json_encode($ventasPorFecha ?? [5, 8, 3, 7, 6]) !!}, // Cantidad de ventas por fecha
                backgroundColor: '#3F95FF'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: { title: { display: true, text: 'Fecha' } },
                y: { beginAtZero: true, title: { display: true, text: 'Ventas' } }
            }
        }
    });
});
</script>
@endsection