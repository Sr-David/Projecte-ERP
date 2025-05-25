<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckUserPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $modulo  Módulo al que se intenta acceder
     * @param  string  $permiso  Tipo de permiso requerido (ver, crear, editar, borrar)
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $modulo = null, $permiso = 'ver'): mixed
    {
        // Log para depuración
        Log::debug('CheckUserPermissions: Middleware invocado', [
            'modulo' => $modulo,
            'permiso' => $permiso,
            'user_type' => $request->session()->get('user_type')
        ]);
        
        // Si es un administrador, permitir acceso completo
        if ($request->session()->get('user_type') === 'admin') {
            return $next($request);
        }

        // Obtener el ID del usuario y verificar que existe
        $userId = $request->session()->get('user_id');
        if (!$userId) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'No autorizado'], 403);
            }
            return redirect('/dashboard')->with('error', 'Debe iniciar sesión para acceder a esta sección');
        }

        // Si no se especificó ningún módulo, permitir acceso
        if (!$modulo) {
            Log::warning('CheckUserPermissions: No se especificó ningún módulo');
            return $next($request);
        }

        // Obtener los permisos del usuario desde la base de datos
        $user = DB::table('Users')->where('idUser', $userId)->first();
        if (!$user) {
            Log::warning("CheckUserPermissions: Usuario no encontrado: {$userId}");
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Usuario no encontrado'], 403);
            }
            return redirect('/dashboard')->with('error', 'Usuario no encontrado');
        }

        // Decodificar los permisos del usuario con manejo de errores
        $permisosJson = $user->Permissions ?? '{}';
        $permisos = [];
        
        try {
            $permisos = json_decode($permisosJson, true);
            // Verificar si json_decode falló
            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('Error decodificando permisos: ' . json_last_error_msg(), [
                    'userId' => $userId,
                    'permisosJson' => $permisosJson
                ]);
                $permisos = [];
            }
        } catch (\Exception $e) {
            Log::error('Excepción decodificando permisos: ' . $e->getMessage(), [
                'userId' => $userId,
                'permisosJson' => $permisosJson
            ]);
            $permisos = [];
        }

        // Si $permisos no es un array, convertirlo a uno vacío
        if (!is_array($permisos)) {
            Log::warning('CheckUserPermissions: Los permisos no son un array', [
                'userId' => $userId,
                'permisos' => $permisos
            ]);
            $permisos = [];
        }

        // Log para depuración
        Log::debug('CheckUserPermissions: Verificando permisos', [
            'userId' => $userId,
            'modulo' => $modulo,
            'permiso' => $permiso,
            'permisos' => $permisos
        ]);

        // Verificar si tiene permiso para la acción solicitada
        if (isset($permisos[$modulo]) && 
            isset($permisos[$modulo][$permiso]) && 
            $permisos[$modulo][$permiso] === true) {
            return $next($request);
        }

        // Si no tiene permiso, devolver error
        Log::warning("CheckUserPermissions: Permiso denegado para {$modulo}.{$permiso}", [
            'userId' => $userId
        ]);
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => false, 
                'message' => 'No tienes permiso para realizar esta acción'
            ], 403);
        }

        // Redirigir al dashboard con un mensaje de error
        return redirect('/dashboard')->with('error', 'No tienes permiso para acceder a esta sección');
    }
} 