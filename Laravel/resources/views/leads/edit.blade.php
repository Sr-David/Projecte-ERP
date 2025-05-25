@extends('layouts.app')

@section('title', 'Editar Lead')
@section('header', 'Editar Lead')
@section('breadcrumb', 'Leads / Editar')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Mensajes de error -->
        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm" role="alert">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium">Por favor corrige los siguientes errores:</p>
                        <ul class="mt-1 text-sm list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Formulario de Leads -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Información del Lead</h3>
            </div>
            
            <form action="{{ route('leads.update', $lead->idLead) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nombre -->
                    <div>
                        <label for="Name" class="block text-sm font-medium text-gray-700 mb-1">Nombre <span class="text-red-500">*</span></label>
                        <input type="text" name="Name" id="Name" value="{{ old('Name', $lead->Name) }}" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    
                    <!-- Apellido -->
                    <div>
                        <label for="LastName" class="block text-sm font-medium text-gray-700 mb-1">Apellido <span class="text-red-500">*</span></label>
                        <input type="text" name="LastName" id="LastName" value="{{ old('LastName', $lead->LastName) }}" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    
                    <!-- Email -->
                    <div>
                        <label for="Email" class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="Email" id="Email" value="{{ old('Email', $lead->Email) }}" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    
                    <!-- Teléfono -->
                    <div>
                        <label for="Phone" class="block text-sm font-medium text-gray-700 mb-1">Teléfono <span class="text-red-500">*</span></label>
                        <input type="tel" name="Phone" id="Phone" value="{{ old('Phone', $lead->Phone) }}" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    
                    <!-- Dirección -->
                    <div class="md:col-span-2">
                        <label for="Address" class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
                        <input type="text" name="Address" id="Address" value="{{ old('Address', $lead->Address) }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    
                    <!-- Tipo de Cliente -->
                    <div>
                        <label for="ClientTypeID" class="block text-sm font-medium text-gray-700 mb-1">Tipo de Cliente <span class="text-red-500">*</span></label>
                        <select name="ClientTypeID" id="ClientTypeID" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Seleccionar tipo...</option>
                            @foreach($clientTypes as $type)
                                <option value="{{ $type->idClientType }}" {{ old('ClientTypeID', $lead->ClientTypeID) == $type->idClientType ? 'selected' : '' }}>
                                    {{ $type->ClientType }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Origen -->
                    <div>
                        <label for="Source" class="block text-sm font-medium text-gray-700 mb-1">Origen <span class="text-red-500">*</span></label>
                        <select name="Source" id="Source" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Seleccionar origen...</option>
                            <option value="Website" {{ old('Source', $lead->Source) == 'Website' ? 'selected' : '' }}>Sitio Web</option>
                            <option value="Referral" {{ old('Source', $lead->Source) == 'Referral' ? 'selected' : '' }}>Referido</option>
                            <option value="Social Media" {{ old('Source', $lead->Source) == 'Social Media' ? 'selected' : '' }}>Redes Sociales</option>
                            <option value="Email Campaign" {{ old('Source', $lead->Source) == 'Email Campaign' ? 'selected' : '' }}>Campaña Email</option>
                            <option value="Cold Call" {{ old('Source', $lead->Source) == 'Cold Call' ? 'selected' : '' }}>Llamada en Frío</option>
                            <option value="Event" {{ old('Source', $lead->Source) == 'Event' ? 'selected' : '' }}>Evento</option>
                            <option value="Other" {{ old('Source', $lead->Source) == 'Other' ? 'selected' : '' }}>Otro</option>
                        </select>
                    </div>
                    
                    <!-- Estado -->
                    <div>
                        <label for="Status" class="block text-sm font-medium text-gray-700 mb-1">Estado <span class="text-red-500">*</span></label>
                        <select name="Status" id="Status" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="New" {{ old('Status', $lead->Status) == 'New' ? 'selected' : '' }}>Nuevo</option>
                            <option value="Contacted" {{ old('Status', $lead->Status) == 'Contacted' ? 'selected' : '' }}>Contactado</option>
                            <option value="Qualified" {{ old('Status', $lead->Status) == 'Qualified' ? 'selected' : '' }}>Calificado</option>
                            <option value="Negotiation" {{ old('Status', $lead->Status) == 'Negotiation' ? 'selected' : '' }}>En Negociación</option>
                            <option value="Lost" {{ old('Status', $lead->Status) == 'Lost' ? 'selected' : '' }}>Perdido</option>
                            <option value="Converted" {{ old('Status', $lead->Status) == 'Converted' ? 'selected' : '' }}>Convertido</option>
                        </select>
                    </div>
                    
                    <!-- Notas -->
                    <div class="md:col-span-2">
                        <label for="Notes" class="block text-sm font-medium text-gray-700 mb-1">Notas</label>
                        <textarea name="Notes" id="Notes" rows="3"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('Notes', $lead->Notes) }}</textarea>
                    </div>
                </div>
                
                <div class="flex justify-end mt-6 gap-3">
                    <a href="{{ route('leads.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancelar
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-brand-blue hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Actualizar Lead
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection 