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
            'password' => 'required|string'
        ]);

        $user = DB::table('Users')
            ->where('Username', $request->username)
            ->first();

        // Si no se encuentra el usuario, responder con error
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Credenciales inválidas'
            ], 401);
        }

        // En vez de usar Hash::check, comparamos directamente las contraseñas
        // ya que las contraseñas no están usando Bcrypt
        if ($request->password === $user->Password) {
            // Contraseña correcta
            $token = bin2hex(random_bytes(32));
            session(['auth_token' => $token, 'user_id' => $user->idUser]);

            return response()->json([
                'success' => true,
                'user' => [
                    'id' => $user->idUser,
                    'username' => $user->Username
                ]
            ]);
        }
        
        // Contraseña incorrecta
        return response()->json([
            'success' => false,
            'message' => 'Credenciales inválidas'
        ], 401);
    }

    public function logout(Request $request)
    {
        $request->session()->forget(['auth_token', 'user_id']);
        
        return response()->json([
            'success' => true,
            'message' => 'Sesión cerrada correctamente'
        ]);
    }

    public function check(Request $request)
    {
        if ($request->session()->has('auth_token') && $request->session()->has('user_id')) {
            $userId = $request->session()->get('user_id');
            
            $user = DB::table('Users')
                ->where('idUser', $userId)
                ->first();
                
            if ($user) {
                return response()->json([
                    'success' => true,
                    'user' => [
                        'id' => $user->idUser,
                        'username' => $user->Username
                    ]
                ]);
            }
        }
        
        return response()->json([
            'success' => false,
            'message' => 'No autenticado'
        ], 401);
    }
} 