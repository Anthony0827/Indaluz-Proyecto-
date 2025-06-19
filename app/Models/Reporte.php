<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Reporte extends Model
{
    protected $table = 'reportes';
    protected $primaryKey = 'id_reporte';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario_reporta',
        'id_producto',
        'id_pedido',
        'tipo_usuario', // 'cliente' o 'agricultor'
        'razon',
        'descripcion',
        'estado',
        'token_acceso',
        'fecha_reporte'
    ];

    /**
     * Cast de atributos para manejar fechas correctamente
     */
    protected $casts = [
        'fecha_reporte' => 'datetime'
    ];

    /**
     * Relación con el usuario que reporta
     */
    public function usuarioReporta()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_reporta', 'id_usuario');
    }

    /**
     * Relación con el producto reportado
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto', 'id_producto');
    }

    /**
     * Relación con el pedido
     */
    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'id_pedido', 'id_pedido');
    }

    /**
     * Scope para reportes pendientes
     */
    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    /**
     * Scope para reportes resueltos
     */
    public function scopeResueltos($query)
    {
        return $query->where('estado', 'resuelto');
    }

    /**
     * Accessor para asegurar que fecha_reporte siempre sea Carbon
     */
    public function getFechaReporteAttribute($value)
    {
        if (is_string($value)) {
            return Carbon::parse($value);
        }
        return $value;
    }
}