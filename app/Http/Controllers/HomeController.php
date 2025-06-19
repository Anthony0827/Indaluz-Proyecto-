<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Mostrar la página de inicio principal
     */
    public function index() 
    {
        return view('home');
    }

    /**
     * Mostrar la página "Nosotros"
     */
    public function nosotros()
    {
        return view('nosotros');
    }

    /**
     * Mostrar la página "Sostenibilidad"
     */
    public function sostenibilidad()
    {
        return view('sostenibilidad');
    }

    /**
     * Mostrar la página "Para Agricultores"
     */
    public function agricultores()
    {
        return view('agricultores');
    }

    /**
     * Mostrar la página "Contacto"
     */
    public function contacto()
    {
        return view('contacto');
    }

    /**
 * Procesar formulario de contacto
 */
public function enviarContacto(Request $request)
{
    $validated = $request->validate([
        'nombre' => 'required|string|max:100',
        'email' => 'required|email|max:100',
        'telefono' => 'nullable|string|max:20',
        'tipo_usuario' => 'required|in:consumidor,agricultor,empresa,otro',
        'asunto' => 'required|in:soporte_tecnico,info_productos,registro_agricultor,problemas_pedido,sugerencias,colaboraciones,otro',
        'mensaje' => 'required|string|max:1000',
        'rgpd' => 'required|accepted',
        'newsletter' => 'nullable|boolean'
    ], [
        'nombre.required' => 'El nombre es obligatorio.',
        'nombre.max' => 'El nombre no puede exceder 100 caracteres.',
        'email.required' => 'El correo electrónico es obligatorio.',
        'email.email' => 'Debe ser un correo electrónico válido.',
        'tipo_usuario.required' => 'Debes seleccionar un tipo de usuario.',
        'tipo_usuario.in' => 'El tipo de usuario seleccionado no es válido.',
        'asunto.required' => 'Debes seleccionar un asunto.',
        'asunto.in' => 'El asunto seleccionado no es válido.',
        'mensaje.required' => 'El mensaje es obligatorio.',
        'mensaje.max' => 'El mensaje no puede exceder 1000 caracteres.',
        'rgpd.required' => 'Debes aceptar la política de privacidad.',
        'rgpd.accepted' => 'Debes aceptar la política de privacidad.'
    ]);

    try {
        // Preparar datos para el correo
        $datos = [
            'nombre' => $validated['nombre'],
            'email' => $validated['email'],
            'telefono' => $validated['telefono'] ?? 'No proporcionado',
            'tipo_usuario' => $this->getTipoUsuarioTexto($validated['tipo_usuario']),
            'asunto' => $this->getAsuntoTexto($validated['asunto']),
            'mensaje' => $validated['mensaje'],
            'newsletter' => isset($validated['newsletter']),
            'fecha' => now()->format('d/m/Y H:i:s')
        ];

        // Enviar correo al administrador
        \Mail::send('emails.contacto', $datos, function($message) use ($validated) {
            $message->to('anthonyramoss0827@gmail.com')
                    ->subject('Nueva Consulta desde Indaluz - ' . $this->getAsuntoTexto($validated['asunto']))
                    ->replyTo($validated['email'], $validated['nombre']);
        });

        return redirect()->route('contacto')
            ->with('success', '¡Mensaje enviado correctamente! Te responderemos en menos de 24 horas.');

    } catch (\Exception $e) {
        return back()
            ->withInput()
            ->with('error', 'Error al enviar el mensaje. Por favor, inténtalo de nuevo o contacta directamente por teléfono.');
    }
}

/**
 * Convertir tipo de usuario a texto legible
 */
private function getTipoUsuarioTexto($tipo)
{
    $tipos = [
        'consumidor' => 'Consumidor',
        'agricultor' => 'Agricultor',
        'empresa' => 'Empresa/Restaurante',
        'otro' => 'Otro'
    ];
    
    return $tipos[$tipo] ?? $tipo;
}

/**
 * Convertir asunto a texto legible
 */
private function getAsuntoTexto($asunto)
{
    $asuntos = [
        'soporte_tecnico' => 'Soporte Técnico',
        'info_productos' => 'Información sobre Productos',
        'registro_agricultor' => 'Registro como Agricultor',
        'problemas_pedido' => 'Problemas con Pedido',
        'sugerencias' => 'Sugerencias y Mejoras',
        'colaboraciones' => 'Colaboraciones Empresariales',
        'otro' => 'Otro'
    ];
    
    return $asuntos[$asunto] ?? $asunto;
}

public function catalogo(Request $request)
{
    $query = \App\Models\Producto::with('agricultor')
        ->where('estado', 'activo');

    // Filtro por búsqueda
    if ($request->filled('buscar')) {
        $buscar = $request->get('buscar');
        $query->where(function($q) use ($buscar) {
            $q->where('nombre', 'LIKE', "%{$buscar}%")
              ->orWhere('descripcion', 'LIKE', "%{$buscar}%");
        });
    }

    // Filtro por categoría
    if ($request->filled('categoria')) {
        $query->where('categoria', $request->get('categoria'));
    }

    // Ordenar por nombre
    $productos = $query->orderBy('nombre', 'asc')->paginate(20);
    
    // Mantener parámetros de búsqueda en la paginación
    $productos->appends($request->all());

    return view('productos.catalogo', compact('productos'));
}

}