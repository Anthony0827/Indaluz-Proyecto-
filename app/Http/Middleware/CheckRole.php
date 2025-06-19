<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Maneja la petición entrante.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        // Verificar que el usuario esté autenticado
        if (!Auth::check()) {
            // Limpiar cualquier sesión corrupta
            $request->session()->flush();
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para acceder.');
        }

        $user = Auth::user();
        
        // Verificar que el usuario esté verificado
        if (!$user->verificado) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->with('error', 'Debes verificar tu cuenta antes de acceder.');
        }

        // Verificar que el usuario tenga el rol correcto
        if ($user->rol !== $role) {
            // Evitar bucles de redirección - verificar si ya estamos en la ruta correcta
            $currentRoute = $request->route()->getName();
            
            switch ($user->rol) {
                case 'administrador':
                    if ($currentRoute !== 'admin.dashboard') {
                        return redirect()->route('admin.dashboard')
                            ->with('warning', 'Has sido redirigido a tu área correspondiente.');
                    }
                    break;
                    
                case 'agricultor':
                    if ($currentRoute !== 'agricultor.dashboard') {
                        return redirect()->route('agricultor.dashboard')
                            ->with('warning', 'Has sido redirigido a tu área correspondiente.');
                    }
                    break;
                    
                case 'cliente':
                    if (!in_array($currentRoute, ['cliente.home', 'cliente.catalogo'])) {
                        return redirect()->route('cliente.home')
                            ->with('warning', 'Has sido redirigido a tu área correspondiente.');
                    }
                    break;
                    
                default:
                    // Si no tiene rol válido, cerrar sesión y limpiar
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                    return redirect()->route('login')
                        ->with('error', 'Tu cuenta no tiene permisos válidos.');
            }
            
            // Si llegamos aquí, significa que estamos en un bucle, así que abortamos
            abort(403, 'Acceso denegado');
        }

        return $next($request);
    }
} 