@extends('layouts.app')

@section('content')
<div class="flex flex-col flex-1 justify-center">
    <div class="max-w-4xl mx-auto py-8 flex-1">
        <h1 class="text-2xl font-bold mb-6">Resumen de Ventas</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded shadow p-6 flex flex-col items-center">
                <span class="text-4xl font-bold text-brand-blue">{{ $ventasCount }}</span>
                <span class="mt-2 text-lg">Ventas confirmadas</span>
                <a href="{{ route('ventas.index') }}" class="mt-4 px-4 py-2 bg-brand-blue text-white rounded hover:bg-blue-700">Ver todas</a>
            </div>
            <div class="bg-white rounded shadow p-6 flex flex-col items-center">
                <span class="text-4xl font-bold text-indigo-600">{{ $propuestasCount }}</span>
                <span class="mt-2 text-lg">Propuestas de venta</span>
                <a href="{{ route('ventas.propuestas') }}" class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Ver todas</a>
            </div>
        </div>
    </div>
</div>
@endsection