@extends('layouts.app')

@section('title', 'Empresa')
@section('header', 'Gestión de Empresa')
@section('breadcrumb', 'Inicio > Empresa')

@section('styles')
<style>
    .empresa-banner {
        background: linear-gradient(135deg, #3F95FF, #3b82f6);
        border-radius: 0.5rem;
        overflow: hidden;
    }
    
    .empresa-logo {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        border: 4px solid white;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        object-fit: cover;
        background-color: white;
    }
    
    .empresa-info-card {
        transition: all 0.3s ease;
    }
    
    .empresa-info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
</style>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Banner de empresa -->
    <div class="empresa-banner p-6 sm:p-10 text-white relative">
        <div class="flex flex-col md:flex-row items-center md:items-start space-y-6 md:space-y-0 md:space-x-8">
            <!-- Logo de empresa -->
            <div class="flex-shrink-0">
                <img src="{{ asset('images/logoElevate.png') }}" alt="Logo Empresa" class="empresa-logo">
            </div>
            
            <!-- Información principal -->
            <div class="flex-grow text-center md:text-left">
                <h1 class="text-3xl font-bold mb-2">Elevate CRM</h1>
                <p class="text-lg opacity-90 mb-4">Sistema integral para gestión de clientes y proyectos</p>
                <div class="flex flex-wrap justify-center md:justify-start gap-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-white/20 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Barcelona, España
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-white/20 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Tecnología
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-white/20 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        info@elevatecrm.com
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Detalles de la empresa -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Información general -->
        <div class="bg-white rounded-lg shadow p-6 empresa-info-card">
            <div class="flex items-center mb-4">
                <div class="p-2 bg-blue-100 rounded-lg mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-brand-blue" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-gray-800">Información General</h2>
            </div>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Nombre fiscal:</span>
                    <span class="font-medium text-gray-800">Elevate CRM S.L.</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">CIF/NIF:</span>
                    <span class="font-medium text-gray-800">B12345678</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Año fundación:</span>
                    <span class="font-medium text-gray-800">2020</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Tamaño:</span>
                    <span class="font-medium text-gray-800">10-50 empleados</span>
                </div>
            </div>
        </div>
        
        <!-- Contacto -->
        <div class="bg-white rounded-lg shadow p-6 empresa-info-card">
            <div class="flex items-center mb-4">
                <div class="p-2 bg-blue-100 rounded-lg mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-brand-blue" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-gray-800">Contacto</h2>
            </div>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Teléfono:</span>
                    <span class="font-medium text-gray-800">+34 934 567 890</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Email:</span>
                    <span class="font-medium text-gray-800">info@elevatecrm.com</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Sitio web:</span>
                    <span class="font-medium text-gray-800">www.elevatecrm.com</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Horario:</span>
                    <span class="font-medium text-gray-800">L-V 9:00-18:00</span>
                </div>
            </div>
        </div>
        
        <!-- Dirección -->
        <div class="bg-white rounded-lg shadow p-6 empresa-info-card">
            <div class="flex items-center mb-4">
                <div class="p-2 bg-blue-100 rounded-lg mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-brand-blue" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-gray-800">Dirección</h2>
            </div>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Dirección:</span>
                    <span class="font-medium text-gray-800">C/ Ejemplo, 123</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Localidad:</span>
                    <span class="font-medium text-gray-800">Barcelona</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Provincia:</span>
                    <span class="font-medium text-gray-800">Barcelona</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Código Postal:</span>
                    <span class="font-medium text-gray-800">08001</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Descripción de la empresa -->
    <div class="bg-white rounded-lg shadow p-6 empresa-info-card">
        <div class="flex items-center mb-4">
            <div class="p-2 bg-blue-100 rounded-lg mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-brand-blue" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <h2 class="text-xl font-semibold text-gray-800">Acerca de la Empresa</h2>
        </div>
        <p class="text-gray-700 mb-4">
            Elevate CRM es una empresa líder en soluciones de gestión de relaciones con clientes. Nuestra misión es proporcionar herramientas innovadoras que permitan a las empresas mejorar su eficiencia, aumentar las ventas y fortalecer las relaciones con sus clientes.
        </p>
        <p class="text-gray-700">
            Fundada en 2020, nuestra plataforma ha ayudado a cientos de empresas a optimizar sus operaciones comerciales y a tomar decisiones basadas en datos. Combinamos tecnología de vanguardia con una interfaz intuitiva para ofrecer una solución completa que se adapta a las necesidades específicas de cada negocio.
        </p>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animaciones o funcionalidad específica para la sección de empresa
    });
</script>
@endsection 