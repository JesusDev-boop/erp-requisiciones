<?php

namespace App\Services;

use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestItem;
use Illuminate\Support\Facades\DB;
use Exception;

class PurchaseRequestService
{
    public function __construct(
        protected FinancialCalculationService $financialService
    ) {}

    /*
    |--------------------------------------------------------------------------
    | CREAR REQUISICIÓN
    |--------------------------------------------------------------------------
    */
    public function store(array $data): PurchaseRequest
    {
        return DB::transaction(function () use ($data) {

            $calculation = $this->financialService->calculate(
                $data['items'],
                $data['descuento'] ?? 0,
                $data['iva'] ?? 0,
                $data['retencion_iva'] ?? 0,
                $data['retencion_isr'] ?? 0
            );

            $purchaseRequest = PurchaseRequest::create([
                'fecha_requisicion' => $data['fecha_requisicion'],
                'fecha_requerida' => $data['fecha_requerida'],
                'estatus' => 'borrador',
                'user_id' => $data['user_id'],
                'area_id' => $data['area_id'],
                'project_id' => $data['project_id'],
                'supplier_id' => $data['supplier_id'],
                'moneda' => $data['moneda'],
                'condicion_pago' => $data['condicion_pago'],
                'descuento' => $data['descuento'] ?? 0,
                'iva' => $data['iva'] ?? 0,
                'retencion_iva' => $data['retencion_iva'] ?? 0,
                'retencion_isr' => $data['retencion_isr'] ?? 0,
                'subtotal' => $calculation['subtotal'],
                'total' => $calculation['total'],
                'total_letra' => $calculation['total_letra'],
                 'cotizacion' => $data['cotizacion'] ?? null,
                'created_by' => auth()->id()
            ]);

            foreach ($data['items'] as $index => $item) {
                PurchaseRequestItem::create([
                    'purchase_request_id' => $purchaseRequest->id,
                    'item' => $index + 1,
                    'cantidad' => $item['cantidad'],
                    'unit_id' => $item['unit_id'],
                    'descripcion' => $item['descripcion'],
                    'precio_unitario' => $item['precio_unitario'],
                    'total' => $item['cantidad'] * $item['precio_unitario'],
                ]);
            }

            return $purchaseRequest;
        });
    }


    /*
    |--------------------------------------------------------------------------
    | CAMBIAR ESTATUS (FLUJO EMPRESARIAL)
    |--------------------------------------------------------------------------
    */
 public function changeStatus(
    PurchaseRequest $request,
    string $newStatus,
    ?string $numRequisicion = null
): PurchaseRequest
{
    return DB::transaction(function () use ($request, $newStatus, $numRequisicion) {

        $current = $request->estatus;
        $role = auth()->user()->role;

        /*
        |--------------------------------------------------------------
        | BLOQUEO DE APROBADAS (solo restringe a otros roles)
        |--------------------------------------------------------------
        */
        if ($current === 'aprobada' &&
            !in_array($role, ['administrador','compras','coordinador'])) {

            throw new Exception('Requisición aprobada no puede modificarse.');
        }

        /*
        |--------------------------------------------------------------
        | FUNCIÓN INTERNA PARA LOG
        |--------------------------------------------------------------
        */
        $log = function($from, $to) use ($request) {
            \App\Models\PurchaseRequestLog::create([
                'purchase_request_id' => $request->id,
                'from_status' => $from,
                'to_status' => $to,
                'changed_by' => auth()->id(),
                'reason' => request('motivo_devolucion')
            ]);
        };

        /*
        |--------------------------------------------------------------
        | COORDINADOR
        |--------------------------------------------------------------
        */
        if ($role === 'coordinador') {

            // borrador → en_revision
            if ($current === 'borrador' && $newStatus === 'en_revision') {

                $request->update(['estatus' => 'en_revision']);
                $log($current, 'en_revision');

                return $request;
            }

            // devuelta → en_revision
            if ($current === 'devuelta' && $newStatus === 'en_revision') {

                $request->update([
                    'estatus' => 'en_revision',
                    'motivo_devolucion' => null,
                    'fecha_devolucion' => null,
                    'devuelto_por' => null
                ]);

                $log($current, 'en_revision');

                return $request;
            }

            // devuelta → cancelada
            if ($current === 'devuelta' && $newStatus === 'cancelada') {

                $request->update(['estatus' => 'cancelada']);
                $log($current, 'cancelada');

                return $request;
            }
        }

        /*
        |--------------------------------------------------------------
        | COMPRAS
        |--------------------------------------------------------------
        */
        if ($role === 'compras') {

            // NUMERAR
            if ($current === 'en_revision' && $newStatus === 'numerada') {

                if (!$numRequisicion) {
                    throw new Exception('Debe ingresar número de requisición.');
                }

                $exists = PurchaseRequest::where('num_requisicion', $numRequisicion)
                    ->where('id', '!=', $request->id)
                    ->exists();

                if ($exists) {
                    throw new Exception('El número de requisición ya existe.');
                }

                $request->update([
                    'estatus' => 'numerada',
                    'num_requisicion' => $numRequisicion
                ]);

                $log($current, 'numerada');

                return $request;
            }

            // DEVOLVER (incluye aprobada)
            if (in_array($current, ['en_revision','numerada','aprobada'])
                && $newStatus === 'devuelta') {

                $request->update([
                    'estatus' => 'devuelta',
                    'motivo_devolucion' => request('motivo_devolucion'),
                    'fecha_devolucion' => now(),
                    'devuelto_por' => auth()->id()
                ]);

                $log($current, 'devuelta');

                return $request;
            }

            // APROBAR
            if ($current === 'numerada' && $newStatus === 'aprobada') {

                $request->update(['estatus' => 'aprobada']);
                $log($current, 'aprobada');

                return $request;
            }

            // RECHAZAR
            if (in_array($current, ['en_revision','numerada'])
                && $newStatus === 'rechazada') {

                $request->update(['estatus' => 'rechazada']);
                $log($current, 'rechazada');

                return $request;
            }
        }

        /*
        |--------------------------------------------------------------
        | ADMINISTRADOR
        |--------------------------------------------------------------
        */
        if ($role === 'administrador') {

            $request->update(['estatus' => $newStatus]);
            $log($current, $newStatus);

            return $request;
        }

        throw new Exception('Cambio de estado no permitido.');
    });
}
}