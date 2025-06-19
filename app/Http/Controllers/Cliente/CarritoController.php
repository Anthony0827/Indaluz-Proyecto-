<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CarritoController extends Controller
{
    /**
     * Muestra la vista del carrito
     */
    public function index()
    {
        return view('cliente.carrito');
    }

    /**
     * Valida los productos del carrito (AJAX)
     * Verifica stock disponible y precios actuales
     */
    public function validar(Request $request)
    {
        try {
            // Log para debugging en producción
            Log::info('Validando carrito', ['items' => $request->input('items', [])]);
            
            $items = $request->input('items', []);
            $productosValidados = [];
            $errores = [];
            
            // Verificar que items sea un array válido
            if (!is_array($items) || empty($items)) {
                return response()->json([
                    'success' => true,
                    'productos' => [],
                    'errores' => []
                ]);
            }
            
            foreach ($items as $item) {
                // Validar estructura del item
                if (!isset($item['id']) || !isset($item['cantidad']) || !isset($item['nombre'])) {
                    Log::warning('Item del carrito con estructura inválida', ['item' => $item]);
                    continue;
                }
                
                $producto = Producto::with('agricultor')->find($item['id']);
                
                if (!$producto) {
                    $errores[] = "El producto '{$item['nombre']}' ya no está disponible";
                    Log::warning('Producto no encontrado', ['id' => $item['id']]);
                    continue;
                }
                
                if ($producto->estado !== 'activo') {
                    $errores[] = "El producto '{$producto->nombre}' ya no está activo";
                    continue;
                }
                
                // Validar stock
                $cantidadSolicitada = (int) $item['cantidad'];
                $stockDisponible = (int) $producto->cantidad_inventario;
                
                if ($stockDisponible < $cantidadSolicitada) {
                    $errores[] = "Stock insuficiente para '{$producto->nombre}'. Disponible: {$stockDisponible}";
                    $cantidadSolicitada = max(0, $stockDisponible);
                }
                
                // Solo agregar si hay stock disponible
                if ($cantidadSolicitada > 0) {
                    $productosValidados[] = [
                        'id' => $producto->id_producto,
                        'nombre' => $producto->nombre,
                        'precio' => (float) $producto->precio,
                        'precio_original' => isset($item['precio']) ? (float) $item['precio'] : (float) $producto->precio,
                        'cantidad' => $cantidadSolicitada,
                        'max' => $stockDisponible,
                        'unidad' => $this->getUnidadMedida($producto),
                        'agricultor' => $this->getNombreAgricultor($producto),
                        'imagen' => $this->getImagenUrl($producto),
                        'precio_cambio' => abs((float) $producto->precio - (isset($item['precio']) ? (float) $item['precio'] : (float) $producto->precio)) > 0.01
                    ];
                }
            }
            
            // Guardar en sesión solo si no hay errores críticos
            if (count($productosValidados) > 0) {
                session(['carrito' => $productosValidados]);
            }
            
            $response = [
                'success' => count($errores) === 0,
                'productos' => $productosValidados,
                'errores' => $errores
            ];
            
            Log::info('Respuesta de validación', $response);
            
            return response()->json($response);
            
        } catch (\Exception $e) {
            Log::error('Error en validación del carrito', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'items' => $request->input('items', [])
            ]);
            
            return response()->json([
                'success' => false,
                'productos' => [],
                'errores' => ['Error interno del servidor. Por favor, recarga la página.']
            ], 500);
        }
    }

    /**
     * Agregar producto al carrito
     */
    public function agregar(Request $request)
    {
        try {
            $validated = $request->validate([
                'id' => 'required|exists:productos,id_producto',
                'cantidad' => 'required|integer|min:1'
            ]);

            $producto = Producto::with('agricultor')->find($validated['id']);
            
            if (!$producto || $producto->estado !== 'activo') {
                return response()->json([
                    'success' => false,
                    'message' => 'Producto no disponible'
                ], 400);
            }

            $carrito = session('carrito', []);
            
            // Buscar si el producto ya está en el carrito
            $encontrado = false;
            foreach ($carrito as &$item) {
                if ($item['id'] == $producto->id_producto) {
                    $nuevaCantidad = $item['cantidad'] + $validated['cantidad'];
                    
                    if ($nuevaCantidad > $producto->cantidad_inventario) {
                        return response()->json([
                            'success' => false,
                            'message' => 'No hay suficiente stock disponible'
                        ], 400);
                    }
                    
                    $item['cantidad'] = $nuevaCantidad;
                    $encontrado = true;
                    break;
                }
            }

            if (!$encontrado) {
                $carrito[] = [
                    'id' => $producto->id_producto,
                    'nombre' => $producto->nombre,
                    'precio' => (float) $producto->precio,
                    'cantidad' => $validated['cantidad'],
                    'max' => $producto->cantidad_inventario,
                    'unidad' => $this->getUnidadMedida($producto),
                    'agricultor' => $this->getNombreAgricultor($producto),
                    'imagen' => $this->getImagenUrl($producto),
                ];
            }

            session(['carrito' => $carrito]);

            return response()->json([
                'success' => true,
                'message' => 'Producto agregado al carrito',
                'carrito' => $carrito
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error agregando al carrito', ['error' => $e->getMessage()]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor'
            ], 500);
        }
    }

    /**
     * Actualizar cantidad de un producto
     */
    public function actualizar(Request $request)
    {
        try {
            $validated = $request->validate([
                'id' => 'required|exists:productos,id_producto',
                'cantidad' => 'required|integer|min:0'
            ]);

            $carrito = session('carrito', []);
            
            if ($validated['cantidad'] == 0) {
                // Eliminar producto si la cantidad es 0
                $carrito = array_filter($carrito, function($item) use ($validated) {
                    return $item['id'] != $validated['id'];
                });
                $carrito = array_values($carrito); // Reindexar
            } else {
                // Actualizar cantidad
                foreach ($carrito as &$item) {
                    if ($item['id'] == $validated['id']) {
                        $producto = Producto::find($validated['id']);
                        
                        if (!$producto || $validated['cantidad'] > $producto->cantidad_inventario) {
                            return response()->json([
                                'success' => false,
                                'message' => 'No hay suficiente stock disponible'
                            ], 400);
                        }
                        
                        $item['cantidad'] = $validated['cantidad'];
                        break;
                    }
                }
            }

            session(['carrito' => $carrito]);

            return response()->json([
                'success' => true,
                'carrito' => $carrito
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error actualizando carrito', ['error' => $e->getMessage()]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor'
            ], 500);
        }
    }

    /**
     * Eliminar producto del carrito
     */
    public function eliminar(Request $request)
    {
        try {
            $validated = $request->validate([
                'id' => 'required'
            ]);

            $carrito = session('carrito', []);
            
            $carrito = array_filter($carrito, function($item) use ($validated) {
                return $item['id'] != $validated['id'];
            });
            
            $carrito = array_values($carrito); // Reindexar
            
            session(['carrito' => $carrito]);

            return response()->json([
                'success' => true,
                'message' => 'Producto eliminado del carrito',
                'carrito' => $carrito
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error eliminando del carrito', ['error' => $e->getMessage()]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor'
            ], 500);
        }
    }

    /**
     * Procesa el pedido (checkout)
     */
    public function checkout(Request $request)
    {
        return redirect()->route('cliente.checkout');
    }

    // ========== MÉTODOS HELPER ==========

    /**
     * Obtener unidad de medida del producto
     */
    private function getUnidadMedida($producto)
    {
        // Mapear unidades de medida si existe una relación
        $unidades = [
            'kg' => 'kg',
            'g' => 'gramos',
            'unidad' => 'unidad',
            'litro' => 'litro',
            'ml' => 'ml'
        ];
        
        return $unidades[$producto->unidad_medida ?? 'unidad'] ?? 'unidad';
    }

    /**
     * Obtener nombre del agricultor
     */
    private function getNombreAgricultor($producto)
    {
        if ($producto->agricultor) {
            return $producto->agricultor->nombre_empresa ?? $producto->agricultor->nombre ?? 'Agricultor';
        }
        return 'Agricultor';
    }

    /**
     * Obtener URL de la imagen
     */
    private function getImagenUrl($producto)
    {
        if ($producto->imagen) {
            return asset('storage/' . $producto->imagen);
        }
        return null;
    }
}