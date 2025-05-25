<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        // Verificar autenticación básica
        if (!$request->session()->has('auth_token') || !$request->session()->has('user_id')) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'No autenticado'], 401);
            }
            return redirect('/login');
        }
        
        $userId = $request->session()->get('user_id');
        $userType = $request->session()->get('user_type', 'user');
        
        if ($userType === 'admin') {
            // Verificar si es un administrador (UserAdministration)
            $admin = DB::table('UserAdministration')->where('idEmpresa', $userId)->first();
            
            if (!$admin) {
                $request->session()->forget(['auth_token', 'user_id', 'user_name', 'user_type', 'empresa_id']);
                
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['success' => false, 'message' => 'No autenticado'], 401);
                }
                return redirect('/login');
            }
            
            // Convertir el objeto a array antes de agregarlo al request
            $request->merge(['admin_user' => (array)$admin]);
            
            // Para administradores, la empresa es ellos mismos
            $userName = isset($admin->Name) ? $admin->Name : 'Administrador';
            $companyName = $userName;
            
            // Hacer disponible el nombre del usuario y de la empresa para todas las vistas
            view()->share('userName', $userName);
            view()->share('companyName', $companyName);
            view()->share('isAdmin', true);
        } else {
            // Verificar si es un usuario regular (Users)
            $user = DB::table('Users')->where('idUser', $userId)->first();
            
            if (!$user) {
                $request->session()->forget(['auth_token', 'user_id', 'user_name', 'user_type', 'empresa_id']);
                
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['success' => false, 'message' => 'No autenticado'], 401);
                }
                return redirect('/login');
            }
            
            // Convertir el objeto a array antes de agregarlo al request
            $request->merge(['admin_user' => (array)$user]);
            
            // Verificar que el usuario tiene un idEmpresa antes de buscar la empresa
            if (!isset($user->idEmpresa)) {
                // Log del error
                \Illuminate\Support\Facades\Log::warning("Usuario sin idEmpresa asignada: " . $userId);
                // Valores por defecto
                $userName = isset($user->Name) ? $user->Name : 'Usuario';
                $companyName = 'Empresa';
            } else {
                // Obtener el nombre de la empresa
                $company = DB::table('UserAdministration')
                    ->where('idEmpresa', $user->idEmpresa)
                    ->first();
                
                $userName = isset($user->Name) ? $user->Name : 'Usuario';
                $companyName = ($company && isset($company->Name)) ? $company->Name : 'Empresa';
            }
            
            // Hacer disponible el nombre del usuario y de la empresa para todas las vistas
            view()->share('userName', $userName);
            view()->share('companyName', $companyName);
            view()->share('isAdmin', false);
        }

        return $next($request);
    }
} 