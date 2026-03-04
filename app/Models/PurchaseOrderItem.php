<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItem extends Model
{
    /*
    |--------------------------------------------------------------------------
    | Configuración de tabla (opcional si usas nombre estándar)
    |--------------------------------------------------------------------------
    */
    protected $table = 'purchase_order_items';

    /*
    |--------------------------------------------------------------------------
    | Campos permitidos para asignación masiva
    |--------------------------------------------------------------------------
    */
    protected $fillable = [
        'purchase_order_id',
        'cantidad',
        'unidad',
        'descripcion',
        'precio_unitario',
        'total',
    ];

    /*
    |--------------------------------------------------------------------------
    | Casts (tipado automático)
    |--------------------------------------------------------------------------
    */
    protected $casts = [
        'cantidad' => 'decimal:2',
        'precio_unitario' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    /**
     * La partida pertenece a una Orden de Compra
     */
    public function order()
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors útiles (opcional pero profesional)
    |--------------------------------------------------------------------------
    */

    /**
     * Total formateado
     */
    public function getTotalFormateadoAttribute()
    {
        return number_format($this->total, 2);
    }

    /**
     * Precio unitario formateado
     */
    public function getPrecioFormateadoAttribute()
    {
        return number_format($this->precio_unitario, 2);
    }
}