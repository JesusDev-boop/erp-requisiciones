<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
    'nombre',
    'razon_social',
    'rfc',
    'contacto',
    'direccion',
    'activo'
];

public function areas()
{
    return $this->belongsToMany(
        \App\Models\Area::class,
        'area_supplier',
        'supplier_id',
        'area_id'
    );
}
}
