<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
            'user_type' => 'required|string|in:user,admin'
        ]);

        if ($request->user_type === 'admin') {
            $admin = DB::table('UserAdministration')
                ->where('Username', $request->username)
                ->first();

            if (!$admin) {
                return response()->json([
                    'success' => false,
                    'message' => 'Credenciales inválidas'
                ], 401);
            }

            if ($request->password === $admin->Password) {
                $token = bin2hex(random_bytes(32));
                session([
                    'auth_token' => $token, 
                    'user_id' => $admin->idEmpresa, 
                    'user_name' => $admin->Name,
                    'user_type' => 'admin',
                    'empresa_id' => $admin->idEmpresa
                ]);

                return response()->json([
                    'success' => true,
                    'user' => [
                        'id' => $admin->idEmpresa,
                        'username' => $admin->Username,
                        'name' => $admin->Name,
                        'type' => 'admin'
                    ]
                ]);
            }
        } else {
            $user = DB::table('Users')
                ->where('Username', $request->username)
                ->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Credenciales inválidas'
                ], 401);
            }

            if ($request->password === $user->Password) {
                $token = bin2hex(random_bytes(32));
                session([
                    'auth_token' => $token, 
                    'user_id' => $user->idUser, 
                    'user_name' => $user->Name,
                    'user_type' => 'user',
                    'empresa_id' => $user->idEmpresa
                ]);

                return response()->json([
                    'success' => true,
                    'user' => [
                        'id' => $user->idUser,
                        'username' => $user->Username,
                        'name' => $user->Name,
                        'type' => 'user'
                    ]
                ]);
            }
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Credenciales inválidas'
        ], 401);
    }

    public function logout(Request $request)
    {
        $request->session()->forget(['auth_token', 'user_id', 'user_name', 'user_type', 'empresa_id']);
        
        return response()->json([
            'success' => true,
            'message' => 'Sesión cerrada correctamente'
        ]);
    }

    public function check(Request $request)
    {
        if ($request->session()->has('auth_token') && $request->session()->has('user_id')) {
            $userId = $request->session()->get('user_id');
            $userType = $request->session()->get('user_type', 'user');
            
            if ($userType === 'admin') {
                $admin = DB::table('UserAdministration')
                    ->where('idEmpresa', $userId)
                    ->first();
                    
                if ($admin) {
                    return response()->json([
                        'success' => true,
                        'user' => [
                            'id' => $admin->idEmpresa,
                            'username' => $admin->Username,
                            'name' => $admin->Name,
                            'type' => 'admin'
                        ]
                    ]);
                }
            } else {
                $user = DB::table('Users')
                    ->where('idUser', $userId)
                    ->first();
                    
                if ($user) {
                    return response()->json([
                        'success' => true,
                        'user' => [
                            'id' => $user->idUser,
                            'username' => $user->Username,
                            'name' => $user->Name,
                            'type' => 'user'
                        ]
                    ]);
                }
            }
        }
        
        return response()->json([
            'success' => false,
            'message' => 'No autenticado'
        ], 401);
    }
} 