{{-- resources/views/emails/contacto.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Consulta - Indaluz</title>
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
            padding: 20px;
            border-radius: 8px 8px 0 0;
            text-align: center;
        }
        .content {
            background: white;
            padding: 30px;
            border-radius: 0 0 8px 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin: 20px 0;
        }
        .info-item {
            background-color: #f9fafb;
            padding: 12px;
            border-radius: 6px;
            border-left: 4px solid #16a34a;
        }
        .info-label {
            font-weight: bold;
            color: #16a34a;
            font-size: 12px;
            text-transform: uppercase;
            margin-bottom: 4px;
        }
        .info-value {
            color: #374151;
        }
        .mensaje-box {
            background-color: #f3f4f6;
            border: 1px solid #d1d5db;
            padding: 20px;
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
        .urgente {
            background-color: #fef2f2;
            border-color: #ef4444;
            color: #dc2626;
            padding: 15px;
            border-radius: 6px;
            margin: 15px 0;
            border-left: 4px solid #ef4444;
        }
        @media (max-width: 600px) {
            .info-grid {
                grid-template-columns: 1fr;
            }
            body {
                padding: 10px;
            }
            .content {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1 style="margin: 0; font-size: 24px;">📧 Nueva Consulta desde Indaluz</h1>
        <p style="margin: 10px 0 0 0; font-size: 16px; opacity: 0.9;">
            {{ $asunto }} - {{ $fecha }}
        </p>
    </div>

    <div class="content">
        @if(in_array($asunto, ['Problemas con Pedido', 'Soporte Técnico']))
            <div class="urgente">
                <strong>⚠️ Consulta Prioritaria:</strong> Esta consulta podría requerir atención inmediata.
            </div>
        @endif

        <h2 style="color: #16a34a; margin-top: 0;">Información del Cliente</h2>

        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Nombre Completo</div>
                <div class="info-value">{{ $nombre }}</div>
            </div>
            
            <div class="info-item">
                <div class="info-label">Correo Electrónico</div>
                <div class="info-value">
                    <a href="mailto:{{ $email }}" style="color: #16a34a; text-decoration: none;">
                        {{ $email }}
                    </a>
                </div>
            </div>
            
            <div class="info-item">
                <div class="info-label">Teléfono</div>
                <div class="info-value">
                    @if($telefono !== 'No proporcionado')
                        <a href="tel:{{ $telefono }}" style="color: #16a34a; text-decoration: none;">
                            {{ $telefono }}
                        </a>
                    @else
                        {{ $telefono }}
                    @endif
                </div>
            </div>
            
            <div class="info-item">
                <div class="info-label">Tipo de Usuario</div>
                <div class="info-value">{{ $tipo_usuario }}</div>
            </div>
        </div>

        <h3 style="color: #374151; margin-bottom: 10px;">Consulta:</h3>
        <div class="info-item" style="margin-bottom: 15px;">
            <div class="info-label">Asunto</div>
            <div class="info-value"><strong>{{ $asunto }}</strong></div>
        </div>

        <h3 style="color: #374151; margin-bottom: 10px;">Mensaje:</h3>
        <div class="mensaje-box">
            {{ $mensaje }}
        </div>

        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Newsletter</div>
                <div class="info-value">
                    @if($newsletter)
                        ✅ Sí, quiere recibir novedades
                    @else
                        ❌ No quiere recibir novedades
                    @endif
                </div>
            </div>
            
            <div class="info-item">
                <div class="info-label">Fecha de Envío</div>
                <div class="info-value">{{ $fecha }}</div>
            </div>
        </div>

        <div style="background-color: #f0fdf4; border: 1px solid #22c55e; padding: 15px; border-radius: 6px; margin-top: 20px;">
            <strong style="color: #16a34a;">📋 Pasos a seguir:</strong>
            <ul style="margin: 10px 0; padding-left: 20px; color: #15803d;">
                <li>Responder al cliente en menos de 24 horas</li>
                <li>Usar el botón "Responder" para mantener el hilo de conversación</li>
                @if($newsletter)
                    <li>Considerar agregar al cliente a la lista de newsletter</li>
                @endif
                <li>Registrar la consulta en el sistema si es necesario</li>
            </ul>
        </div>

        <div style="text-align: center; margin: 30px 0;">
            <a href="mailto:{{ $email }}?subject=Re: {{ $asunto }} - Indaluz&body=Hola {{ $nombre }},%0D%0A%0D%0AGracias por contactar con Indaluz.%0D%0A%0D%0A" 
               style="display: inline-block; background: linear-gradient(135deg, #16a34a, #22c55e); color: white; text-decoration: none; padding: 15px 30px; border-radius: 6px; font-weight: bold;">
                📧 Responder al Cliente
            </a>
        </div>
    </div>

    <div class="footer">
        <p><strong>Indaluz - Sistema de Contacto</strong></p>
        <p>Este correo fue generado automáticamente desde el formulario de contacto.</p>
        <p style="font-size: 12px; margin-top: 10px;">
            Para responder, usa el botón de arriba o responde directamente a este correo.
        </p>
    </div>
</body>
</html>