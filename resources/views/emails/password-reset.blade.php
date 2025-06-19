{{-- resources/views/emails/password-reset.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperación de Contraseña - Indaluz</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .header {
            background: linear-gradient(135deg, #16a34a, #22c55e);
            color: white;
            padding: 30px 20px;
            border-radius: 8px 8px 0 0;
            text-align: center;
        }
        .content {
            background: white;
            padding: 30px;
            border-radius: 0 0 8px 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #16a34a, #22c55e);
            color: white !important;
            text-decoration: none;
            padding: 15px 30px;
            border-radius: 8px;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
            box-shadow: 0 4px 6px rgba(22, 163, 74, 0.3);
        }
        .button:hover {
            background: linear-gradient(135deg, #15803d, #16a34a);
        }
        .alert {
            background-color: #fef3c7;
            border: 1px solid #f59e0b;
            color: #92400e;
            padding: 15px;
            border-radius: 6px;
            margin: 20px 0;
        }
        .info-box {
            background-color: #f0fdf4;
            border: 1px solid #22c55e;
            padding: 15px;
            border-radius: 6px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 14px;
        }
        .security-tips {
            background-color: #f3f4f6;
            padding: 15px;
            border-radius: 6px;
            margin: 20px 0;
            font-size: 14px;
        }
        @media (max-width: 600px) {
            body {
                padding: 10px;
            }
            .content {
                padding: 20px;
            }
            .button {
                display: block;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1 style="margin: 0; font-size: 28px;">🔐 Recuperación de Contraseña</h1>
        <p style="margin: 10px 0 0 0; font-size: 16px; opacity: 0.9;">
            Indaluz - Productos Frescos de Almería
        </p>
    </div>

    <div class="content">
        <h2 style="color: #16a34a; margin-top: 0;">Hola {{ $usuario->nombre }},</h2>
        
        <p>
            Hemos recibido una solicitud para restablecer la contraseña de tu cuenta en <strong>Indaluz</strong>.
        </p>

        <p>
            Si fuiste tú quien solicitó el cambio de contraseña, haz clic en el siguiente botón para crear una nueva contraseña:
        </p>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ $url_reset }}" class="button">
                🔑 Cambiar mi Contraseña
            </a>
        </div>

        <div class="alert">
            <strong>⚠️ Importante:</strong> Este enlace expirará en <strong>{{ $expiracion }} minutos</strong> por motivos de seguridad.
        </div>

        <div class="info-box">
            <h3 style="color: #16a34a; margin-top: 0; font-size: 18px;">📋 Información del Reset</h3>
            <ul style="margin: 10px 0; padding-left: 20px; color: #15803d;">
                <li><strong>Cuenta:</strong> {{ $correo }}</li>
                <li><strong>Solicitado:</strong> {{ now()->format('d/m/Y \a \l\a\s H:i') }}</li>
                <li><strong>Expira:</strong> {{ now()->addMinutes($expiracion)->format('d/m/Y \a \l\a\s H:i') }}</li>
            </ul>
        </div>

        <h3 style="color: #374151;">¿No puedes hacer clic en el botón?</h3>
        <p>Copia y pega el siguiente enlace en tu navegador:</p>
        <div style="background-color: #f3f4f6; padding: 10px; border-radius: 4px; word-break: break-all; font-family: monospace; font-size: 12px;">
            {{ $url_reset }}
        </div>

        <div class="security-tips">
            <h4 style="color: #374151; margin-top: 0;">🛡️ Consejos de Seguridad:</h4>
            <ul style="margin: 10px 0; padding-left: 20px; color: #6b7280;">
                <li>Si no solicitaste este cambio, puedes ignorar este correo</li>
                <li>Tu contraseña actual seguirá siendo válida</li>
                <li>Nunca compartas tu contraseña con terceros</li>
                <li>Usa una contraseña única y segura</li>
                <li>Si tienes dudas, contacta con nuestro soporte</li>
            </ul>
        </div>

        <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 30px 0;">

        <p style="color: #6b7280; font-size: 14px;">
            Si no solicitaste este cambio de contraseña, no necesitas hacer nada. Tu cuenta permanece segura.
        </p>

        <div style="text-align: center; margin-top: 30px;">
            <p style="color: #6b7280; font-size: 14px; margin-bottom: 10px;">
                ¿Necesitas ayuda? Contacta con nuestro equipo:
            </p>
            <a href="mailto:contacto@indaluz.com" style="color: #16a34a; text-decoration: none; font-weight: bold;">
                📧 contacto@indaluz.com
            </a>
        </div>
    </div>

    <div class="footer">
        <p><strong>Indaluz - Productos Frescos de Almería</strong></p>
        <p>Este correo fue generado automáticamente. No responder directamente.</p>
        <p style="font-size: 12px; margin-top: 10px;">
            Sistema de Recuperación de Contraseñas v1.0 - {{ now()->format('Y') }}
        </p>
    </div>
</body>
</html>