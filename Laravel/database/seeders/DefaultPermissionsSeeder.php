<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DefaultPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Define default permissions for modules
        $defaultPermissions = [
            'dashboard' => ['ver'],
            'clientes' => ['ver', 'crear', 'editar', 'borrar'],
            'leads' => ['ver', 'crear', 'editar', 'borrar', 'convertir'],
            'productos' => ['ver', 'crear', 'editar', 'borrar'],
            'ventas' => ['ver', 'crear', 'editar', 'borrar', 'confirmar'],
            'proyectos' => ['ver', 'crear', 'editar', 'borrar'],
            'facturacion' => ['ver', 'crear', 'editar', 'borrar', 'generar'],
            'reportes' => ['ver'],
            'usuarios' => ['ver', 'crear', 'editar', 'borrar'],
            'notas' => ['ver', 'crear', 'editar', 'borrar'],
        ];

        // ... existing code ...
    }
} 