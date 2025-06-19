<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Reporte;
use App\Models\Producto;
use App\Models\Usuario;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ReporteController extends Controller
{
    /**
     * Mostrar formulario de reporte para cliente
     */
    public function showFormCliente($id_pedido)
    {
        // Verificar que el pedido pertenece al cliente
        $pedido = Pedido::with(['detalles.producto.agricultor'])
            ->where('id_pedido', $id_pedido)
            ->where('id_cliente', Auth::id())
            ->firstOrFail();

        return view('cliente.reportes.create', compact('pedido'));
    }

    /**
     * Mostrar formulario de reporte para agricultor
     */
    public function showFormAgricultor($id_pedido)
    {
        $idAgricultor = Auth::id();
        
        // Obtener el pedido y verificar que contiene productos del agricultor
        $pedido = Pedido::with(['cliente', 'detalles.producto'])
            ->where('id_pedido', $id_pedido)
            ->firstOrFail();
        
        // Verificar que el pedido contenga productos del agricultor
        $productosDelAgricultor = $pedido->detalles->filter(function($detalle) use ($idAgricultor) {
            return $detalle->producto->id_agricultor == $idAgricultor;
        });
        
        if ($productosDelAgricultor->isEmpty()) {
            abort(403, 'No tienes acceso a este pedido');
        }

        return view('agricultor.reportes.create', compact('pedido', 'productosDelAgricultor'));
    }

    /**
     * Procesar reporte enviado por cliente
     */
    public function storeCliente(Request $request, $id_pedido)
    {
        $validated = $request->validate([
            'id_producto' => 'required|integer|exists:productos,id_producto',
            'razon' => 'required|string|max:100',
            'descripcion' => 'required|string|max:500'
        ], [
            'id_producto.required' => 'Debes seleccionar un producto.',
            'id_producto.exists' => 'El producto seleccionado no existe.',
            'razon.required' => 'Debes seleccionar un motivo.',
            'razon.max' => 'El motivo no puede exceder 100 caracteres.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.max' => 'La descripción no puede exceder 500 caracteres.'
        ]);

        try {
            // Verificar que el pedido pertenece al cliente
            $pedido = Pedido::where('id_pedido', $id_pedido)
                ->where('id_cliente', Auth::id())
                ->firstOrFail();

            // Verificar que el producto está en el pedido
            $producto = Producto::findOrFail($validated['id_producto']);
            $pedidoContieneProducto = $pedido->detalles()
                ->where('id_producto', $validated['id_producto'])
                ->exists();

            if (!$pedidoContieneProducto) {
                return redirect()->route('cliente.pedidos.index')
                    ->with('error', 'El producto seleccionado no pertenece a este pedido.');
            }

            // Crear reporte
            $reporte = $this->crearReporte($validated, $id_pedido, 'cliente');

            // Enviar correo al administrador
            $this->enviarCorreoAdministrador($reporte);

            return redirect()->route('cliente.pedidos')
                ->with('success', '✅ Tu reporte ha sido enviado correctamente. El administrador revisará tu caso pronto.');

        } catch (\Exception $e) {
            return redirect()->route('cliente.pedidos')
                ->with('error', 'Error al enviar el reporte. Por favor, inténtalo de nuevo.');
        }
    }

    /**
     * Procesar reporte enviado por agricultor
     */
    public function storeAgricultor(Request $request, $id_pedido)
    {
        $validated = $request->validate([
            'id_producto' => 'required|integer|exists:productos,id_producto',
            'razon' => 'required|string|max:100',
            'descripcion' => 'required|string|max:500'
        ], [
            'id_producto.required' => 'Debes seleccionar un producto.',
            'id_producto.exists' => 'El producto seleccionado no existe.',
            'razon.required' => 'Debes seleccionar un motivo.',
            'razon.max' => 'El motivo no puede exceder 100 caracteres.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.max' => 'La descripción no puede exceder 500 caracteres.'
        ]);

        try {
            $idAgricultor = Auth::id();
            
            // Verificar que el producto pertenece al agricultor
            $producto = Producto::where('id_producto', $validated['id_producto'])
                ->where('id_agricultor', $idAgricultor)
                ->firstOrFail();

            // Verificar que el pedido existe
            $pedido = Pedido::findOrFail($id_pedido);

            // Crear reporte
            $reporte = $this->crearReporte($validated, $id_pedido, 'agricultor');

            // Enviar correo al administrador
            $this->enviarCorreoAdministrador($reporte);

            return redirect()->route('agricultor.pedidos.index')
                ->with('success', '✅ Tu reporte ha sido enviado correctamente. El administrador revisará tu caso pronto.');

        } catch (\Exception $e) {
            return redirect()->route('agricultor.pedidos.index')
                ->with('error', 'Error al enviar el reporte. Por favor, inténtalo de nuevo.');
        }
    }

    /**
     * Crear reporte en la base de datos
     */
    private function crearReporte($validated, $id_pedido, $tipo_usuario)
    {
        return Reporte::create([
            'id_usuario_reporta' => Auth::id(),
            'id_producto' => $validated['id_producto'],
            'id_pedido' => $id_pedido,
            'tipo_usuario' => $tipo_usuario,
            'razon' => $validated['razon'],
            'descripcion' => $validated['descripcion'],
            'estado' => 'pendiente',
            'token_acceso' => Str::random(60),
            'fecha_reporte' => now()
        ]);
    }

    /**
     * Enviar correo al administrador
     */
    private function enviarCorreoAdministrador($reporte)
    {
        try {
            $datos = [
                'reporte' => $reporte,
                'url_admin' => route('admin.direct-review', $reporte->token_acceso)
            ];

            Mail::send('emails.reporte-admin', $datos, function($message) use ($reporte) {
                $message->to('anthonyramoss0827@gmail.com')
                        ->subject('Nuevo Reporte en Indaluz - Caso #' . $reporte->id_reporte);
            });

        } catch (\Exception $e) {
            // Log del error pero no interrumpir el proceso
            \Log::error('Error enviando correo de reporte: ' . $e->getMessage());
        }
    }
}