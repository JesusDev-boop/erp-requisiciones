<?php
namespace App\Exports;

use App\Models\PurchaseOrder;
use Maatwebsite\Excel\Concerns\FromCollection;

class OrdersReportExport implements FromCollection
{
    public function collection()
    {
        return PurchaseOrder::where('estatus','emitida')
            ->select('numero_oc','proveedor_nombre','proyecto','total','created_at')
            ->get();
    }
}