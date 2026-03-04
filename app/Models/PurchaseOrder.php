<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{

protected $fillable = [

'purchase_request_id',

'numero_oc',
'numero_requisicion',

'proveedor_nombre',
'proveedor_contacto',
'proveedor_rfc',
'proveedor_direccion',

'pozo',
'area',
'proyecto',
'solicitud_trabajo',

'solicitante',
'fecha',

'condiciones_pago',
'moneda',
'cotizacion',

'subtotal',
'descuento',
'iva',
'retencion_iva',
'retencion_isr',
'total',

'total_letra',

'estatus',
'fecha_emision',
'emitido_por'
];


// 👇 ESTADO POR DEFECTO
protected $attributes = [
'estatus' => 'borrador'
];


public function items()
{
return $this->hasMany(PurchaseOrderItem::class);
}

public function purchaseRequest()
{
return $this->belongsTo(PurchaseRequest::class);
}

}
