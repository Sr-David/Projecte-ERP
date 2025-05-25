<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    /**
     * Mostrar la página de configuración del sistema
     */
    public function sistema(Request $request)
    {
        // Verificar que sea un administrador
        if ($request->session()->get('user_type') !== 'admin') {
            return redirect('/dashboard')->with('error', 'No tienes permisos para acceder a esta sección');
        }

        $adminId = $request->session()->get('user_id');
        
        // Obtener todos los usuarios asociados a este administrador
        $users = DB::table('Users')
            ->where('idEmpresa', $adminId)
            ->get();
        
        return view('admin.sistema', [
            'users' => $users,
            'adminId' => $adminId
        ]);
    }

    /**
     * Guardar un nuevo usuario o actualizar uno existente
     */
    public function saveUser(Request $request)
    {
        // Verificar que sea un administrador
        if ($request->session()->get('user_type') !== 'admin') {
            return response()->json(['success' => false, 'message' => 'No tienes permisos para realizar esta acción'], 403);
        }

        $validator = Validator::make($request->all(), [
            'id' => 'nullable|integer',
            'name' => 'required|string|max:100',
            'username' => 'required|string|max:100',
            'password' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $adminId = $request->session()->get('user_id');
        
        $userData = [
            'Name' => $request->name,
            'Username' => $request->username,
            'Password' => $request->password,
            'idEmpresa' => $adminId
        ];

        if (!empty($request->id)) {
            // Actualizar usuario existente
            DB::table('Users')
                ->where('idUser', $request->id)
                ->where('idEmpresa', $adminId) // Seguridad adicional
                ->update($userData);
            
            return response()->json(['success' => true, 'message' => 'Usuario actualizado correctamente']);
        } else {
            // Crear nuevo usuario
            $userId = DB::table('Users')->insertGetId($userData);
            
            return response()->json([
                'success' => true, 
                'message' => 'Usuario creado correctamente',
                'userId' => $userId
            ]);
        }
    }

    /**
     * Eliminar un usuario
     */
    public function deleteUser(Request $request, $id)
    {
        // Verificar que sea un administrador
        if ($request->session()->get('user_type') !== 'admin') {
            return response()->json(['success' => false, 'message' => 'No tienes permisos para realizar esta acción'], 403);
        }

        $adminId = $request->session()->get('user_id');
        
        // Eliminar el usuario (asegurando que pertenezca a este administrador)
        DB::table('Users')
            ->where('idUser', $id)
            ->where('idEmpresa', $adminId)
            ->delete();
        
        return response()->json(['success' => true, 'message' => 'Usuario eliminado correctamente']);
    }

    /**
     * Mostrar la página de permisos de usuarios
     */
    public function permisos(Request $request)
    {
        // Verificar que sea un administrador
        if ($request->session()->get('user_type') !== 'admin') {
            return redirect('/dashboard')->with('error', 'No tienes permisos para acceder a esta sección');
        }

        $adminId = $request->session()->get('user_id');
        
        // Obtener todos los usuarios asociados a este administrador
        $users = DB::table('Users')
            ->where('idEmpresa', $adminId)
            ->get();
        
        // Definir los módulos disponibles en el sistema
        $modulos = [
            'clientes' => 'Clientes',
            'productos' => 'Productos',
            'ventas' => 'Ventas',
            'reportes' => 'Reportes',
            'leads' => 'Leads',
            'proyectos' => 'Proyectos',
            'facturacion' => 'Facturación'
        ];
        
        // Obtener permisos existentes (o crear estructura si no existen)
        foreach ($users as $user) {
            if (!empty($user->Permissions)) {
                $user->permisos = json_decode($user->Permissions, true);
            } else {
                // Estructura de permisos por defecto
                $user->permisos = [];
                foreach ($modulos as $key => $nombre) {
                    $user->permisos[$key] = [
                        'ver' => true,
                        'crear' => false,
                        'editar' => false,
                        'borrar' => false
                    ];
                }
            }
        }
        
        return view('admin.permisos', [
            'users' => $users,
            'modulos' => $modulos,
            'adminId' => $adminId
        ]);
    }

    /**
     * Guardar los permisos de un usuario
     */
    public function savePermisos(Request $request)
    {
        // Verificar que sea un administrador
        if ($request->session()->get('user_type') !== 'admin') {
            return response()->json(['success' => false, 'message' => 'No tienes permisos para realizar esta acción'], 403);
        }

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'permisos' => 'required|array'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $adminId = $request->session()->get('user_id');
        
        // Actualizar permisos del usuario
        DB::table('Users')
            ->where('idUser', $request->user_id)
            ->where('idEmpresa', $adminId) // Seguridad adicional
            ->update([
                'Permissions' => json_encode($request->permisos)
            ]);
        
        return response()->json(['success' => true, 'message' => 'Permisos actualizados correctamente']);
    }
} 