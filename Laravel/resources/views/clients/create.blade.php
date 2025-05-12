@extends('layouts.app')

@section('title', 'Crear Cliente')
@section('header', 'Crear Nuevo Cliente')
@section('breadcrumb')
    <li class="text-sm font-medium text-gray-500 hover:text-gray-900">
        <a href="{{ route('dashboard') }}">Inicio</a>
    </li>
    <li class="text-sm font-medium text-gray-500 pl-2">
        /
    </li>
    <li class="text-sm font-medium text-gray-500 hover:text-gray-900 pl-2">
        <a href="{{ route('clients.index') }}">Clientes</a>
    </li>
    <li class="text-sm font-medium text-gray-500 pl-2">
        /
    </li>
    <li class="text-sm font-medium text-gray-900 pl-2">Crear Cliente</li>
@endsection

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
            <form action="{{ route('clients.store') }}" method="POST">
                @csrf
                <div class="p-6 space-y-6">
                    <!-- Información Personal -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 border-b pb-3">Información Personal</h3>
                        <div class="mt-4 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
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
                                <div class="mt-1">
                                    <input type="email" name="Email" id="Email" value="{{ old('Email') }}" required
                                        class="shadow-sm focus:ring-brand-blue focus:border-brand-blue block w-full sm:text-sm border-gray-300 rounded-md @error('Email') border-red-300 @enderror">
                                    @error('Email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Teléfono -->
                            <div class="sm:col-span-3">
                                <label for="Phone" class="block text-sm font-medium text-gray-700">Teléfono *</label>
                                <div class="mt-1">
                                    <input type="tel" name="Phone" id="Phone" value="{{ old('Phone') }}" required
                                        class="shadow-sm focus:ring-brand-blue focus:border-brand-blue block w-full sm:text-sm border-gray-300 rounded-md @error('Phone') border-red-300 @enderror">
                                    @error('Phone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Dirección -->
                            <div class="sm:col-span-6">
                                <label for="Address" class="block text-sm font-medium text-gray-700">Dirección</label>
                                <div class="mt-1">
                                    <input type="text" name="Address" id="Address" value="{{ old('Address') }}"
                                        class="shadow-sm focus:ring-brand-blue focus:border-brand-blue block w-full sm:text-sm border-gray-300 rounded-md @error('Address') border-red-300 @enderror">
                                    @error('Address')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Tipo de Cliente -->
                            <div class="sm:col-span-3">
                                <label for="ClientType_ID" class="block text-sm font-medium text-gray-700">Tipo de Cliente *</label>
                                <div class="mt-1">
                                    <select name="ClientType_ID" id="ClientType_ID" required
                                        class="shadow-sm focus:ring-brand-blue focus:border-brand-blue block w-full sm:text-sm border-gray-300 rounded-md @error('ClientType_ID') border-red-300 @enderror">
                                        <option value="">Seleccionar tipo de cliente</option>
                                        @foreach($clientTypes as $type)
                                            <option value="{{ $type->id }}" {{ old('ClientType_ID') == $type->id ? 'selected' : '' }}>
                                                {{ $type->ClientType }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('ClientType_ID')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Acciones -->
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6 flex justify-end space-x-3">
                    <a href="{{ route('clients.index') }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-blue">
                        Cancelar
                    </a>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-brand-blue hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-blue">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection 