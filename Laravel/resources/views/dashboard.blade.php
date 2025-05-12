<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Administrador | Sistema ERP-CRM</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.jsx'])
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6">Dashboard de Administración</h1>
        <div class="bg-white rounded-lg shadow-md p-6">
            <p class="mb-4">Bienvenido al panel de administración.</p>
            <button id="logout-btn" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                Cerrar sesión
            </button>
        </div>
    </div>

    <script>
        document.getElementById('logout-btn').addEventListener('click', async () => {
            try {
                await window.axios.post('/api/logout');
                window.location.href = '/login';
            } catch (error) {
                console.error('Error al cerrar sesión:', error);
            }
        });
    </script>
</body>
</html> 