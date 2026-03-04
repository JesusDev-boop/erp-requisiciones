<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $fillable = [
        'nombre'
    ];


    public function suppliers()
{
    return $this->belongsToMany(
        \App\Models\Supplier::class,
        'area_supplier',
        'area_id',
        'supplier_id'
    );
}
}