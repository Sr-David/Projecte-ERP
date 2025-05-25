@extends('layouts.app')

@section('title', 'Crear Cliente')
@section('header', 'Crear Nuevo Cliente')
@section('breadcrumb', 'Clientes / Crear')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-medium text-gray-900">Formulario de Registro</h3>
                <p class="mt-1 text-sm text-gray-500">Complete todos los campos requeridos (*)</p>
            </div>
            
            <form action="{{ route('clients.store') }}" method="POST">
                @csrf
                <div class="p-6 space-y-6">
                    <!-- Información Personal -->
                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <!-- Nombre -->
                        <div class="sm:col-span-3">
                            <label for="Name" class="block text-sm font-medium text-gray-700">Nombre *</label>
                            <div class="mt-1">
                                <input type="text" name="Name" id="Name" value="{{ old('Name') }}" required
                                    class="shadow-sm focus:ring-brand-blue focus:border-brand-blue block w-full sm:text-sm border-gray-300 rounded-md @error('Name') border-red-300 @enderror">
                                @error('Name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Apellido -->
                        <div class="sm:col-span-3">
                            <label for="LastName" class="block text-sm font-medium text-gray-700">Apellido *</label>
                            <div class="mt-1">
                                <input type="text" name="LastName" id="LastName" value="{{ old('LastName') }}" required
                                    class="shadow-sm focus:ring-brand-blue focus:border-brand-blue block w-full sm:text-sm border-gray-300 rounded-md @error('LastName') border-red-300 @enderror">
                                @error('LastName')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="sm:col-span-3">
                            <label for="Email" class="block text-sm font-medium text-gray-700">Email *</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                    </svg>
                                </div>
                                <input type="email" name="Email" id="Email" value="{{ old('Email') }}" required
                                    class="pl-10 focus:ring-brand-blue focus:border-brand-blue block w-full sm:text-sm border-gray-300 rounded-md @error('Email') border-red-300 @enderror">
                                @error('Email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Teléfono -->
                        <div class="sm:col-span-3">
                            <label for="Phone" class="block text-sm font-medium text-gray-700">Teléfono *</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                    </svg>
                                </div>
                                <input type="tel" name="Phone" id="Phone" value="{{ old('Phone') }}" required
                                    class="pl-10 focus:ring-brand-blue focus:border-brand-blue block w-full sm:text-sm border-gray-300 rounded-md @error('Phone') border-red-300 @enderror">
                                @error('Phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Dirección -->
                        <div class="sm:col-span-6">
                            <label for="Address" class="block text-sm font-medium text-gray-700">Dirección</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="text" name="Address" id="Address" value="{{ old('Address') }}"
                                    class="pl-10 focus:ring-brand-blue focus:border-brand-blue block w-full sm:text-sm border-gray-300 rounded-md @error('Address') border-red-300 @enderror">
                                @error('Address')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Tipo de Cliente -->
                        <div class="sm:col-span-3">
                            <label for="ClientTypeID" class="block text-sm font-medium text-gray-700">Tipo de Cliente *</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <select name="ClientTypeID" id="ClientTypeID" required
                                    class="pl-10 focus:ring-brand-blue focus:border-brand-blue block w-full sm:text-sm border-gray-300 rounded-md @error('ClientTypeID') border-red-300 @enderror">
                                    <option value="" disabled selected>Seleccionar tipo de cliente</option>
                                    @if(isset($clientTypes) && count($clientTypes) > 0)
                                        @foreach($clientTypes as $type)
                                            <option value="{{ $type->idClientType }}" {{ old('ClientTypeID') == $type->idClientType ? 'selected' : '' }}>
                                                {{ $type->ClientType }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="" disabled>No hay tipos de cliente disponibles</option>
                                    @endif
                                </select>
                                @error('ClientTypeID')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Acciones -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-3">
                    <a href="{{ route('clients.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-blue">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-brand-blue hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-blue">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Guardar Cliente
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection 