<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\PurchaseRequest;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use ZipArchive;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrdersReportExport;



class PurchaseOrderController extends Controller
{
   public function store(PurchaseRequest $purchaseRequest)
{
    abort_unless(auth()->user()->role === 'compras', 403);

    if ($purchaseRequest->estatus !== 'aprobada') {
        abort(403, 'Solo requisiciones aprobadas pueden generar OC.');
    }

    if ($purchaseRequest->order) {
        abort(403, 'Esta requisición ya tiene una Orden de Compra generada.');
    }

    DB::transaction(function () use ($purchaseRequest) {

        $order = PurchaseOrder::create([

            'purchase_request_id' => $purchaseRequest->id,

            'numero_oc' => null,

            // ⚠️ ajusta según nombre real del campo
            'numero_requisicion' => $purchaseRequest->num_requisicion,

            'proveedor_nombre' => $purchaseRequest->supplier->nombre ?? '',
            'proveedor_contacto' => $purchaseRequest->supplier->contacto ?? '',
            'proveedor_rfc' => $purchaseRequest->supplier->rfc ?? '',
            'proveedor_direccion' => $purchaseRequest->supplier->direccion ?? '',

            'pozo' => $purchaseRequest->pozo ?? '',
            'area' => $purchaseRequest->area->nombre ?? '',
            'proyecto' => $purchaseRequest->project->nombre ?? '',
            'solicitud_trabajo' => $purchaseRequest->solicitud_trabajo ?? '',

            // ✅ CORRECTO
            'solicitante' => $purchaseRequest->solicitante ?? '',

            'fecha' => now()->format('Y-m-d'),

            'condiciones_pago' => $purchaseRequest->condicion_pago ?? '',
            'moneda' => $purchaseRequest->moneda ?? '',

            'cotizacion' => $purchaseRequest->cotizacion ?? '',

            'subtotal' => $purchaseRequest->subtotal,
            'descuento' => $purchaseRequest->descuento ?? 0,
            'iva' => $purchaseRequest->iva,
            'retencion_iva' => $purchaseRequest->retencion_iva ?? 0,
            'retencion_isr' => $purchaseRequest->retencion_isr ?? 0,
            'total' => $purchaseRequest->total,
            'total_letra' => $purchaseRequest->total_letra,
        ]);

        foreach ($purchaseRequest->items as $item) {
            $order->items()->create([
                'cantidad' => $item->cantidad,
                'unidad' => $item->unit->nombre ?? 'PIEZA',
                'descripcion' => $item->descripcion,
                'precio_unitario' => $item->precio_unitario,
                'total' => $item->total
            ]);
        }
    });

    return back()->with('success', 'Orden de Compra generada correctamente.');
}


public function pdf(PurchaseOrder $order)
{
    $order->load('items');

    $pdf = Pdf::loadView('purchase_orders.pdf', compact('order'));

    return $pdf->stream(
        'OC-' . $order->numero_oc . '.pdf'
    );
}


public function edit(PurchaseOrder $order)
{
    $order->load('items');

    return view('purchase_orders.edit', compact('order'));
}

public function update(Request $request, PurchaseOrder $order)
{$order->update($request->only([
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
    'total_letra'
]));
    foreach ($request->items as $itemId => $data) {

        $orderItem = $order->items()->find($itemId);

        if ($orderItem) {
            $orderItem->update([
                'cantidad' => $data['cantidad'],
                'unidad' => $data['unidad'],
                'descripcion' => $data['descripcion'],
                'precio_unitario' => $data['precio_unitario'],
                'total' => $data['cantidad'] * $data['precio_unitario'],
            ]);
        }
    }

    return back()->with('success','Orden actualizada correctamente.');
}



public function updateNumero(Request $request, PurchaseOrder $order)
{
    $request->validate([
        'numero_oc' => 'required|string|max:255|unique:purchase_orders,numero_oc'
    ]);

    $order->update([
        'numero_oc' => $request->numero_oc
    ]);

    return back()->with('success','Número de OC asignado correctamente.');
}

public function borradores()
{
    $orders = PurchaseOrder::with('purchaseRequest')
        ->where('estatus','borrador')
        ->latest()
        ->paginate(15);

    return view('purchase_orders.borradores', compact('orders'));
}




public function emitidas(Request $request)
{
$query = PurchaseOrder::where('estatus','emitida');

if($request->numero_oc){
    $query->where('numero_oc','like','%'.$request->numero_oc.'%');
}

if($request->fecha_inicio){
    $query->whereDate('created_at','>=',$request->fecha_inicio);
}

if($request->fecha_fin){
    $query->whereDate('created_at','<=',$request->fecha_fin);
}

$orders = $query->latest()->paginate(15);

return view('purchase_orders.emitidas',compact('orders'));
}

public function index()
{
    $orders = PurchaseOrder::with('purchaseRequest')
        ->where('estatus','emitida')
        ->latest()
        ->paginate(15);

    return view('purchase_orders.index', compact('orders'));
}

public function numeradas()
{
    $orders = PurchaseOrder::with('purchaseRequest')
        ->whereNotNull('numero_oc')
        ->latest()
        ->paginate(15);

    return view('borradores', compact('orders'));
}


public function todas()
{
    $orders = PurchaseOrder::with('purchaseRequest')
        ->latest()
        ->paginate(15);

    return view('orders.index', compact('orders'));
}


public function downloadZip(Request $request)
{

    $query = \App\Models\PurchaseOrder::where('estatus','emitida');

    if ($request->numero_oc) {
        $query->where('numero_oc','like','%'.$request->numero_oc.'%');
    }

    if ($request->fecha_inicio) {
        $query->whereDate('created_at','>=',$request->fecha_inicio);
    }

    if ($request->fecha_fin) {
        $query->whereDate('created_at','<=',$request->fecha_fin);
    }

    $orders = $query->get();

    $zipFileName = 'ordenes_compra_'.date('Ymd_His').'.zip';
    $zipPath = storage_path('app/'.$zipFileName);

    $zip = new ZipArchive;

    if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {

        foreach ($orders as $order) {

            $pdf = Pdf::loadView('purchase_orders.pdf',[
                'order'=>$order
            ]);

            $zip->addFromString($order->numero_oc.'.pdf', $pdf->output());
        }

        $zip->close();
    }

    return response()->download($zipPath)->deleteFileAfterSend(true);
}



public function montoTotal()
{

$total_inversion = PurchaseOrder::where('estatus','emitida')
    ->sum('total');

$total_ordenes = PurchaseOrder::where('estatus','emitida')
    ->count();

$promedio_ticket = $total_ordenes > 0
    ? $total_inversion / $total_ordenes
    : 0;

$mes_actual = PurchaseOrder::whereMonth('created_at',now()->month)
    ->where('estatus','emitida')
    ->sum('total');

$mes_anterior = PurchaseOrder::whereMonth('created_at',now()->subMonth()->month)
    ->where('estatus','emitida')
    ->sum('total');

$variacion = $mes_anterior > 0
    ? (($mes_actual - $mes_anterior) / $mes_anterior) * 100
    : 0;


/* GASTO POR MES */

$ordenes_mes = PurchaseOrder::select(
    DB::raw('MONTH(created_at) as label'),
    DB::raw('SUM(total) as total')
)
->where('estatus','emitida')
->groupBy('label')
->orderBy('label')
->get();


/* MONTO POR PROVEEDOR */

$proveedores = PurchaseOrder::select(
'proveedor_nombre as label',
DB::raw('SUM(total) as total')
)
->where('estatus','emitida')
->groupBy('proveedor_nombre')
->orderByDesc('total')
->get();

/* CRECIMIENTO MENSUAL */

$crecimiento = [];

$meses = $ordenes_mes->pluck('total')->values();

for($i = 1; $i < count($meses); $i++){

    $prev = $meses[$i-1];
    $actual = $meses[$i];

    $crecimiento[] = $prev > 0
        ? (($actual - $prev) / $prev) * 100
        : 0;
}

/* MONTO POR PROYECTO */

$proyectos = PurchaseOrder::select(
'proyecto as label',
DB::raw('SUM(total) as total')
)
->where('estatus','emitida')
->groupBy('proyecto')
->orderByDesc('total')
->get();


/* MONTO POR AREA */

$areas = PurchaseOrder::select(
'area as label',
DB::raw('SUM(total) as total')
)
->where('estatus','emitida')
->groupBy('area')
->orderByDesc('total')
->get();


/* ULTIMAS ORDENES */

$ultimas_ordenes = PurchaseOrder::where('estatus','emitida')
    ->latest()
    ->take(10)
    ->get();


return view('purchase_orders.monto_total',[
'total_inversion'=>$total_inversion,
'total_ordenes'=>$total_ordenes,
'promedio_ticket'=>$promedio_ticket,
'variacion'=>$variacion,
'ordenes_mes'=>$ordenes_mes,
'proveedores'=>$proveedores,
'proyectos'=>$proyectos,
'areas'=>$areas,
'ultimas_ordenes'=>$ultimas_ordenes,
'crecimiento'=>$crecimiento
]);

}

/*
|--------------------------------------------------------------------------
| EMITIR ORDEN DE COMPRA
|--------------------------------------------------------------------------
*/

public function emitir(PurchaseOrder $order)
{

if(!$order->numero_oc){
return back()->with('error','Debes asignar un número de OC antes de emitir.');
}

$order->update([
'estatus'=>'emitida',
'fecha_emision'=>now(),
'emitido_por'=>auth()->id()
]);

return redirect()
->route('purchase_orders.emitidas')
->with('success','Orden de compra emitida correctamente');

}

public function exportarExcel()
{
    return Excel::download(new OrdersReportExport,'reporte_oc.xlsx');
}

public function reportes(Request $request)
{

$query = PurchaseOrder::where('estatus','emitida');


/* FILTRO FECHAS */

if($request->fecha_inicio){
    $query->whereDate('created_at','>=',$request->fecha_inicio);
}

if($request->fecha_fin){
    $query->whereDate('created_at','<=',$request->fecha_fin);
}


/* TOTAL INVERSION */

$total_inversion = (clone $query)->sum('total');


/* TOTAL ORDENES */

$total_ordenes = (clone $query)->count();


/* PROMEDIO */

$promedio_ticket = $total_ordenes > 0
    ? $total_inversion / $total_ordenes
    : 0;


/* GASTO POR MES */

$ordenes_mes = (clone $query)
->select(
    DB::raw('MONTH(created_at) as label'),
    DB::raw('SUM(total) as total')
)
->groupBy('label')
->orderBy('label')
->get();


/* CRECIMIENTO MENSUAL */

$crecimiento = [];

$meses = $ordenes_mes->pluck('total')->values();

for($i=1;$i<count($meses);$i++){

$prev = $meses[$i-1];
$actual = $meses[$i];

$crecimiento[] = $prev > 0
? (($actual - $prev) / $prev) * 100
: 0;

}


/* PROVEEDORES */

$proveedores = (clone $query)
->select(
'proveedor_nombre as label',
DB::raw('SUM(total) as total')
)
->groupBy('proveedor_nombre')
->orderByDesc('total')
->get();


/* PROYECTOS */

$proyectos = (clone $query)
->select(
'proyecto as label',
DB::raw('SUM(total) as total')
)
->groupBy('proyecto')
->orderByDesc('total')
->get();


/* AREAS */

$areas = (clone $query)
->select(
'area as label',
DB::raw('SUM(total) as total')
)
->groupBy('area')
->orderByDesc('total')
->get();


/* ULTIMAS ORDENES */

$ultimas_ordenes = (clone $query)
->latest()
->take(10)
->get();


return view('purchase_orders.reportes',compact(

'total_inversion',
'total_ordenes',
'promedio_ticket',
'ordenes_mes',
'proveedores',
'proyectos',
'areas',
'ultimas_ordenes',
'crecimiento'

));

}

public function reportePdf()
{

$ordenes = PurchaseOrder::where('estatus','emitida')
            ->latest()
            ->get();

$pdf = Pdf::loadView('purchase_orders.reportes_pdf',[
    'ordenes'=>$ordenes
]);

return $pdf->download('reporte_ordenes.pdf');

}

}