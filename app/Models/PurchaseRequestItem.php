<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseRequestItem extends Model
{

protected $fillable = [
    'purchase_request_id',
    'item',
    'cantidad',
    'unit_id',
    'descripcion',
    'precio_unitario',
    'total',
];
public function purchaseRequest()
{
    return $this->belongsTo(\App\Models\PurchaseRequest::class);
}

public function unit()
{
    return $this->belongsTo(\App\Models\Unit::class);
}
}
