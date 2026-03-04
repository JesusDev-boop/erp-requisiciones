<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePurchaseRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'fecha_requisicion' => 'required|date',
            'fecha_requerida' => 'required|date|after_or_equal:fecha_requisicion',
            'user_id' => 'required|exists:users,id',
            'area_id' => 'required|exists:areas,id',
            'project_id' => 'required|exists:projects,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'moneda' => 'required|in:nacional,dolares',
            'condicion_pago' => 'required',
            'items' => 'required|array|min:1',
            'items.*.cantidad' => 'required|numeric|min:0.01',
            'items.*.unit_id' => 'required|exists:units,id',
            'items.*.descripcion' => 'required|string',
            'items.*.precio_unitario' => 'required|numeric|min:0.01'
        ];
    }
}