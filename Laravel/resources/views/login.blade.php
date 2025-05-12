<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Acceso Administrador | Sistema ERP-CRM</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    @if (file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.jsx'])
    @else
        <!-- Fallback cuando el manifiesto de Vite no existe -->
        <style>
            /* Estilos CSS básicos */
            body {
                font-family: ui-sans-serif, system-ui, sans-serif;
                background-color: #f9fafb;
                color: #1f2937;
            }
        </style>
    @endif
    
    <!-- Tailwind CDN como fallback en caso de problemas con Vite -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="antialiased">
    <div id="login-container" class="min-h-screen">
        <!-- El componente React de Login se renderizará aquí -->
    </div>
    
    <!-- Contenido fallback por si React no carga -->
    <noscript>
        <div class="max-w-7xl mx-auto p-6">
            <h1 class="text-3xl font-bold mb-6">Acceso Administrador</h1>
            
            <div class="grid grid-cols-1 gap-6">
                <div class="rounded-xl border bg-white p-6 shadow">
                    <div class="flex flex-col space-y-1.5 pb-4">
                        <h3 class="font-semibold text-xl">Iniciar sesión</h3>
                        <p class="text-gray-500 text-sm">Se requiere JavaScript para acceder al sistema</p>
                    </div>
                    <div>
                        <p>Por favor, habilite JavaScript en su navegador para continuar.</p>
                    </div>
                    <div class="flex justify-between pt-4">
                        <button class="rounded-md border px-4 py-2 text-sm">Cancelar</button>
                        <button class="rounded-md bg-blue-600 text-white px-4 py-2 text-sm">Acceder</button>
                    </div>
                </div>
            </div>
        </div>
    </noscript>
</body>
</html> 