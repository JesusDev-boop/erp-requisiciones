<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseRequestLog extends Model
{
    protected $fillable = [
        'purchase_request_id',
        'from_status',
        'to_status',
        'changed_by',
        'reason'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELACIÓN: Usuario que hizo el cambio
    |--------------------------------------------------------------------------
    */
    public function user()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }

    /*
    |--------------------------------------------------------------------------
    | RELACIÓN: Requisición asociada
    |--------------------------------------------------------------------------
    */
    public function purchaseRequest()
    {
        return $this->belongsTo(PurchaseRequest::class, 'purchase_request_id');
    }
}