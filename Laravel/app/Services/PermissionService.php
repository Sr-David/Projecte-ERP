<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PermissionService
{
    /**
     * Verificar si el usuario actual tiene el permiso requerido para un módulo
     *
     * @param string $modulo Módulo a verificar (clientes, productos, ventas, etc.)
     * @param string $permiso Permiso requerido (ver, crear, editar, borrar)
     * @return bool
     */
    public function hasPermission($modulo, $permiso = 'ver')
    {
        // Si es un administrador, tiene todos los permisos
        if (session('user_type') === 'admin') {
            return true;
        }

        $userId = session('user_id');
        if (!$userId) {
            return false;
        }

        // Obtener los permisos del usuario
        $user = DB::table('Users')->where('idUser', $userId)->first();
        if (!$user) {
            return false;
        }

        // Si no tiene permisos definidos, usar valores predeterminados
        if (empty($user->Permissions)) {
            // Por defecto, solo permitir "ver"
            return $permiso === 'ver';
        }

        $permisos = json_decode($user->Permissions, true);
        
        // Verificar si el módulo y el permiso existen y están habilitados
        return isset($permisos[$modulo][$permiso]) && $permisos[$modulo][$permiso] === true;
    }
} 