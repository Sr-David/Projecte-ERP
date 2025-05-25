@extends('layouts.app')

@section('title', 'Editar Cliente')
@section('header', 'Editar Cliente')
@section('breadcrumb')
    <p class="text-sm font-medium text-gray-500 hover:text-gray-900">
        <a href="{{ route('dashboard') }}">Inicio</a> / <a href="{{ route('clients.index') }}">Clientes</a> / Editar Cliente

    </p>
@endsection

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
            <form action="{{ route('clients.update', $client) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="p-6 space-y-6">
                    <!-- Información Personal -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 border-b pb-3">Información Personal</h3>
                        <div class="mt-4 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <!-- Nombre -->
                            <div class="sm:col-span-3">
                                <label for="Name" class="block text-sm font-medium text-gray-700">Nombre *</label>
                                <div class="mt-1">
                                    <input type="text" name="Name" id="Name" value="{{ old('Name', $client->Name) }}"
                                        required
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
                                    <input type="text" name="LastName" id="LastName"
                                        value="{{ old('LastName', $client->LastName) }}" required
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
                                    <input type="email" name="Email" id="Email" value="{{ old('Email', $client->Email) }}"
                                        required
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
                                    <input type="tel" name="Phone" id="Phone" value="{{ old('Phone', $client->Phone) }}"
                                        required
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
                                    <input type="text" name="Address" id="Address"
                                        value="{{ old('Address', $client->Address) }}"
                                        class="shadow-sm focus:ring-brand-blue focus:border-brand-blue block w-full sm:text-sm border-gray-300 rounded-md @error('Address') border-red-300 @enderror">
                                    @error('Address')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Tipo de Cliente -->
                            <div class="sm:col-span-3">
                                <label for="clientTypeId" class="block text-sm font-medium text-gray-700">Tipo de Cliente
                                    *</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </div>
                                    <select name="ClientTypeID" id="ClientTypeID" required
                                        class="pl-10 focus:ring-brand-blue focus:border-brand-blue block w-full sm:text-sm border-gray-300 rounded-md @error('ClientTypeID') border-red-300 @enderror">
                                        <option value="">Seleccionar tipo de cliente</option>
                                        @foreach($clientTypes as $type)
                                            <option value="{{ $type->idClientType }}" {{ (old('ClientTypeID') ?? $client->ClientTypeID) == $type->idClientType ? 'selected' : '' }}>
                                                {{ $type->ClientType }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('ClientTypeID')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Acciones -->
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6 flex justify-end space-x-3">
                    <a href="{{ route('clients.index') }}"
                        class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-blue">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-brand-blue hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-blue">
                        Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection