<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PasswordResetController extends Controller
{
    /**
     * Mostrar formulario para solicitar reset de contraseña
     */
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    /**
     * Enviar enlace de reset por email
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'correo' => 'required|email|exists:usuarios,correo'
        ], [
            'correo.required' => 'El correo electrónico es obligatorio.',
            'correo.email' => 'Debe ser un correo electrónico válido.',
            'correo.exists' => 'No existe una cuenta registrada con este correo electrónico.'
        ]);

        try {
            $usuario = Usuario::where('correo', $request->correo)->first();
            
            // Generar token único
            $token = Str::random(60);
            
            // Guardar token en base de datos con expiración de 60 minutos
            \DB::table('password_resets')->updateOrInsert(
                ['correo' => $request->correo],
                [
                    'correo' => $request->correo,
                    'token' => Hash::make($token),
                    'created_at' => Carbon::now()
                ]
            );

            // Datos para el email
            $datos = [
                'usuario' => $usuario,
                'token' => $token,
                'correo' => $request->correo,
                'url_reset' => route('password.reset', ['token' => $token, 'email' => $request->correo]),
                'expiracion' => 60 // minutos
            ];

            // Enviar email
            Mail::send('emails.password-reset', $datos, function($message) use ($request) {
                $message->to($request->correo)
                        ->subject('Recuperación de Contraseña - Indaluz');
            });

            return redirect()->route('password.request')
                ->with('success', '¡Enlace enviado! Revisa tu correo electrónico para restablecer tu contraseña.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error al enviar el correo. Por favor, inténtalo de nuevo.');
        }
    }

    /**
     * Mostrar formulario de reset con token
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with([
            'token' => $token,
            'email' => $request->email
        ]);
    }

    /**
     * Procesar cambio de contraseña
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'correo' => 'required|email|exists:usuarios,correo',
            'password' => 'required|string|min:8|confirmed'
        ], [
            'correo.required' => 'El correo electrónico es obligatorio.',
            'correo.email' => 'Debe ser un correo electrónico válido.',
            'correo.exists' => 'No existe una cuenta registrada con este correo electrónico.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
            'token.required' => 'Token de reset requerido.'
        ]);

        try {
            // Buscar registro de reset de contraseña
            $passwordReset = \DB::table('password_resets')
                ->where('correo', $request->correo)
                ->first();

            if (!$passwordReset) {
                return back()->with('error', 'Token de reset no válido.');
            }

            // Verificar que el token coincida
            if (!Hash::check($request->token, $passwordReset->token)) {
                return back()->with('error', 'Token de reset no válido.');
            }

            // Verificar que no haya expirado (60 minutos)
            if (Carbon::parse($passwordReset->created_at)->addMinutes(60)->isPast()) {
                // Eliminar token expirado
                \DB::table('password_resets')->where('correo', $request->correo)->delete();
                return back()->with('error', 'El enlace de recuperación ha expirado. Solicita uno nuevo.');
            }

            // Actualizar contraseña del usuario
            $usuario = Usuario::where('correo', $request->correo)->first();
            $usuario->update([
                'contraseña' => Hash::make($request->password)
            ]);

            // Eliminar token usado
            \DB::table('password_resets')->where('correo', $request->correo)->delete();

            return redirect()->route('login')
                ->with('success', '¡Contraseña cambiada correctamente! Ya puedes iniciar sesión con tu nueva contraseña.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error al cambiar la contraseña. Por favor, inténtalo de nuevo.');
        }
    }
}