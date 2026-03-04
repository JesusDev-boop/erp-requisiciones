<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Policies\PurchaseRequestPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;

#[UsePolicy(PurchaseRequestPolicy::class)]
class PurchaseRequest extends Model
{
    protected $fillable = [
    'num_requisicion',
    'solicitud_trabajo',
    'solicitante',
    'pozo',
    'fecha_requisicion',
    'fecha_requerida',
    'estatus',
    'user_id',
    'solicitante',
    'area_id',
    'project_id',
    'supplier_id',
    'contacto',
    'direccion',
    'rfc',
    'moneda',
    'condicion_pago',
    'subtotal',
    'descuento',
    'iva',
    'retencion_iva',
    'retencion_isr',
    'cotizacion',
    'total',
    'total_letra',
    'created_by',
];

public function items()
{
    return $this->hasMany(PurchaseRequestItem::class);
}

public function supplier()
{
    return $this->belongsTo(\App\Models\Supplier::class);
}

public function area()
{
    return $this->belongsTo(\App\Models\Area::class);
}

public function project()
{
    return $this->belongsTo(\App\Models\Project::class);
}

public function user()
{
    return $this->belongsTo(\App\Models\User::class);
}

protected static function booted()
{
    static::addGlobalScope('not_cancelled', function ($query) {
        $query->where('estatus', '!=', 'cancelada');
    });
}


public function logs()
{
    return $this->hasMany(PurchaseRequestLog::class)
                ->latest();
}


public function order()
{
    return $this->hasOne(PurchaseOrder::class);
}

}
