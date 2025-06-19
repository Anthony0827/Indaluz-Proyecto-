{{-- resources/views/emails/reporte-admin.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Reporte - Indaluz</title>
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
        .alert {
            background-color: #fef3c7;
            border: 1px solid #f59e0b;
            color: #92400e;
            padding: 15px;
            border-radius: 6px;
            margin: 20px 0;
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
        .description-box {
            background-color: #f3f4f6;
            border: 1px solid #d1d5db;
            padding: 15px;
            border-radius: 6px;
            margin: 15px 0;
            font-style: italic;
        }
        .action-button {
            display: inline-block;
            background: linear-gradient(135deg, #16a34a, #22c55e);
            color: white !important;
            text-decoration: none;
            padding: 15px 30px;
            border-radius: 6px;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
            box-shadow: 0 2px 5px rgba(22, 163, 74, 0.3);
        }
        .action-button:hover {
            background: linear-gradient(135deg, #15803d, #16a34a);
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 14px;
        }
        .priority-high {
            background-color: #fef2f2;
            border-color: #ef4444;
            color: #dc2626;
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
        <h1 style="margin: 0; font-size: 24px;">🚨 Nuevo Reporte en Indaluz</h1>
        <p style="margin: 10px 0 0 0; font-size: 16px; opacity: 0.9;">
            Caso #{{ $reporte->id_reporte }} requiere tu atención
        </p>
    </div>

    <div class="content">
        <div class="alert {{ in_array($reporte->razon, ['Cliente abusivo', 'Contenido inapropiado', 'Reseña falsa']) ? 'priority-high' : '' }}">
            <strong>⚠️ Acción requerida:</strong> Un nuevo reporte ha sido enviado y necesita revisión administrativa.
        </div>

        <h2 style="color: #16a34a; margin-top: 0;">Detalles del Reporte</h2>

        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Fecha del Reporte</div>
                <div class="info-value">{{ $reporte->fecha_reporte->format('d/m/Y \a \l\a\s H:i') }}</div>
            </div>
            
            <div class="info-item">
                <div class="info-label">Tipo de Usuario</div>
                <div class="info-value">{{ ucfirst($reporte->tipo_usuario) }}</div>
            </div>
            
            <div class="info-item">
                <div class="info-label">Motivo del Reporte</div>
                <div class="info-value"><strong>{{ $reporte->razon }}</strong></div>
            </div>
            
            <div class="info-item">
                <div class="info-label">Pedido Relacionado</div>
                <div class="info-value">#{{ $reporte->id_pedido }}</div>
            </div>
        </div>

        <h3 style="color: #374151; margin-bottom: 10px;">Reportado por:</h3>
        <div class="info-item">
            <div class="info-value">
                <strong>{{ $reporte->usuarioReporta->nombre }} {{ $reporte->usuarioReporta->apellido }}</strong><br>
                📧 {{ $reporte->usuarioReporta->correo }}<br>
                📱 {{ $reporte->usuarioReporta->telefono ?? 'No disponible' }}
            </div>
        </div>

        <h3 style="color: #374151; margin-bottom: 10px;">Producto reportado:</h3>
        <div class="info-item">
            <div class="info-value">
                <strong>{{ $reporte->producto->nombre }}</strong><br>
                💰 €{{ number_format($reporte->producto->precio, 2) }} por {{ $reporte->producto->unidad_medida }}<br>
                👨‍🌾 {{ $reporte->producto->agricultor->nombre }} {{ $reporte->producto->agricultor->apellido }}
            </div>
        </div>

        <h3 style="color: #374151; margin-bottom: 10px;">Descripción del problema:</h3>
        <div class="description-box">
            "{{ $reporte->descripcion }}"
        </div>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ $url_admin }}" class="action-button">
                🔍 Revisar Caso Ahora
            </a>
        </div>

        <div class="alert">
            <strong>Importante:</strong> Este enlace te llevará directamente al panel de administración donde podrás:
            <ul style="margin: 10px 0; padding-left: 20px;">
                <li>Ver todos los detalles del caso</li>
                <li>Revisar el producto y las reseñas relacionadas</li>
                <li>Tomar acciones administrativas (eliminar, bloquear, etc.)</li>
                <li>Marcar el caso como resuelto</li>
            </ul>
        </div>

        <div style="background-color: #f0fdf4; border: 1px solid #22c55e; padding: 15px; border-radius: 6px; margin-top: 20px;">
            <strong style="color: #16a34a;">💡 Recordatorio de seguridad:</strong>
            <ul style="margin: 10px 0; padding-left: 20px; color: #15803d;">
                <li>Todas las acciones administrativas quedan registradas</li>
                <li>Evalúa cuidadosamente antes de tomar medidas permanentes</li>
                <li>Contacta al equipo técnico si tienes dudas</li>
            </ul>
        </div>
    </div>

    <div class="footer">
        <p><strong>Indaluz - Sistema de Administración</strong></p>
        <p>Este correo fue generado automáticamente. No responder.</p>
        <p style="font-size: 12px; margin-top: 10px;">
            Sistema de reportes v1.0 - {{ now()->format('Y') }}
        </p>
    </div>
</body>
</html>