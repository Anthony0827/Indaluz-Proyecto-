<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reporte;
use App\Models\Producto;
use App\Models\Usuario;
use App\Models\Resena;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Mostrar formulario de login del administrador
     */
    public function showLogin()
    {
        return view('admin.login');
    }

    /**
     * Procesar login del administrador
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'correo' => 'required|email',
            'password' => 'required'
        ]);

        // Buscar usuario administrador
        $admin = Usuario::where('correo', $credentials['correo'])
                       ->where('rol', 'administrador')
                       ->first();

        if ($admin && Hash::check($credentials['password'], $admin->contraseña)) {
            // Login manual del administrador
            Auth::login($admin);
            
            // Redirigir según si viene de un token específico
            if ($request->has('token')) {
                return redirect()->route('admin.reporte.review', $request->token);
            }
            
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'correo' => 'Las credenciales proporcionadas no coinciden con nuestros registros.'
        ]);
    }

    /**
     * Dashboard principal del administrador
     */
    public function dashboard()
    {
        $reportesPendientes = Reporte::pendientes()
            ->with(['usuarioReporta', 'producto', 'pedido'])
            ->orderBy('fecha_reporte', 'desc')
            ->get();

        $estadisticas = [
            'total_reportes' => Reporte::count(),
            'reportes_pendientes' => Reporte::pendientes()->count(),
            'reportes_resueltos' => Reporte::resueltos()->count(),
            'usuarios_bloqueados' => Usuario::where('verificado', 0)->count()
        ];

        return view('admin.dashboard', compact('reportesPendientes', 'estadisticas'));
    }

    /**
     * Revisar reporte específico usando token
     */
    public function reviewReporte($token)
    {
        $reporte = Reporte::where('token_acceso', $token)
            ->with([
                'usuarioReporta',
                'producto.agricultor',
                'producto.resenas.cliente',
                'pedido.cliente'
            ])
            ->firstOrFail();

        // Marcar como en revisión si está pendiente
        if ($reporte->estado === 'pendiente') {
            $reporte->update(['estado' => 'en_revision']);
        }

        return view('admin.reporte.review', compact('reporte'));
    }

    /**
     * Eliminar producto reportado
     */
    public function deleteProducto(Request $request, $token)
    {
        $reporte = Reporte::where('token_acceso', $token)->firstOrFail();
        $producto = $reporte->producto;

        // Eliminar imagen si existe
        if ($producto->imagen) {
            Storage::disk('public')->delete($producto->imagen);
        }

        // Eliminar producto
        $producto->delete();

        // Marcar reporte como resuelto
        $reporte->update(['estado' => 'resuelto']);

        return redirect()->route('admin.reporte.review', $token)
            ->with('success', 'Producto eliminado correctamente.');
    }

    /**
     * Eliminar reseñas de un producto
     */
    public function deleteResenas(Request $request, $token)
    {
        $reporte = Reporte::where('token_acceso', $token)->firstOrFail();
        $producto = $reporte->producto;

        // Eliminar todas las reseñas del producto
        Resena::where('id_agricultor', $producto->id_agricultor)->delete();

        return redirect()->route('admin.reporte.review', $token)
            ->with('success', 'Reseñas eliminadas correctamente.');
    }

    /**
     * Eliminar reseña específica
     */
    public function deleteResena(Request $request, $token, $id_resena)
    {
        $reporte = Reporte::where('token_acceso', $token)->firstOrFail();
        
        $resena = Resena::where('id_reseña', $id_resena)->firstOrFail();
        $resena->delete();

        return redirect()->route('admin.reporte.review', $token)
            ->with('success', 'Reseña eliminada correctamente.');
    }

    /**
     * Bloquear usuario (cliente o agricultor)
     */
    public function blockUser(Request $request, $token)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer|exists:usuarios,id_usuario',
            'user_type' => 'required|in:cliente,agricultor'
        ]);

        $reporte = Reporte::where('token_acceso', $token)->firstOrFail();
        
        $usuario = Usuario::findOrFail($validated['user_id']);
        
        // Verificar que el usuario no sea administrador
        if ($usuario->rol === 'administrador') {
            return back()->with('error', 'No se puede bloquear a un administrador.');
        }

        // "Bloquear" marcando como no verificado
        $usuario->update(['verificado' => 0]);

        return redirect()->route('admin.reporte.review', $token)
            ->with('success', 'Usuario bloqueado correctamente.');
    }

    /**
     * Eliminar imagen de producto
     */
    public function deleteProductImage(Request $request, $token)
    {
        $reporte = Reporte::where('token_acceso', $token)->firstOrFail();
        $producto = $reporte->producto;

        if ($producto->imagen) {
            // Eliminar archivo de imagen
            Storage::disk('public')->delete($producto->imagen);
            
            // Actualizar base de datos
            $producto->update(['imagen' => null]);
        }

        return redirect()->route('admin.reporte.review', $token)
            ->with('success', 'Imagen del producto eliminada correctamente.');
    }

    /**
     * Marcar reporte como resuelto sin acción
     */
    public function resolveReporte(Request $request, $token)
    {
        $reporte = Reporte::where('token_acceso', $token)->firstOrFail();
        $reporte->update(['estado' => 'resuelto']);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Reporte marcado como resuelto.');
    }

    /**
     * Logout del administrador
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login')
            ->with('success', 'Sesión cerrada correctamente.');
    }
}