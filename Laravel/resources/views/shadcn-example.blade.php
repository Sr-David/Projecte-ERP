<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tailwind CSS en Laravel</title>
    
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
    <div id="example-shadcn">
        <!-- Contenido fallback por si React no carga -->
        <div class="max-w-7xl mx-auto p-6">
            <h1 class="text-3xl font-bold mb-6">Ejemplo con Tailwind CSS</h1>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="rounded-xl border bg-white p-6 shadow">
                    <div class="flex flex-col space-y-1.5 pb-4">
                        <h3 class="font-semibold text-xl">Tarjeta de ejemplo</h3>
                        <p class="text-gray-500 text-sm">Este es un ejemplo de una tarjeta</p>
                    </div>
                    <div>
                        <p>Aquí puedes incluir el contenido principal de tu tarjeta.</p>
                    </div>
                    <div class="flex justify-between pt-4">
                        <button class="rounded-md border px-4 py-2 text-sm">Cancelar</button>
                        <button class="rounded-md bg-blue-600 text-white px-4 py-2 text-sm">Enviar</button>
                    </div>
                </div>
                
                <div class="rounded-xl border bg-white p-6 shadow">
                    <div class="flex flex-col space-y-1.5 pb-4">
                        <h3 class="font-semibold text-xl">Características</h3>
                        <p class="text-gray-500 text-sm">Ventajas de usar Tailwind CSS</p>
                    </div>
                    <div>
                        <ul class="list-disc list-inside space-y-2">
                            <li>Componentes accesibles</li>
                            <li>Personalizable con clases</li>
                            <li>Sin estilos predeterminados</li>
                            <li>Código abierto</li>
                        </ul>
                    </div>
                    <div class="pt-4">
                        <button class="w-full rounded-md bg-gray-200 px-4 py-2 text-sm">Más información</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 