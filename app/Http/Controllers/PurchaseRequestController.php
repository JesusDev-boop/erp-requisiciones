<?php

namespace App\Http\Controllers;

use App\Services\PurchaseRequestService;
use App\Http\Requests\StorePurchaseRequestRequest;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\PurchaseRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;

use ZipArchive;
use Illuminate\Support\Facades\Storage;


class PurchaseRequestController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        protected PurchaseRequestService $service
    ) {}

    /*
    |--------------------------------------------------------------------------
    | CREAR
    |--------------------------------------------------------------------------
    */


public function create()
{
    $this->authorize('create', PurchaseRequest::class);

    $user = auth()->user();

    // 🔥 Si es compras o administrador → ve todos los proveedores
    if (in_array($user->role, ['compras', 'administrador'])) {

        $suppliers = \App\Models\Supplier::where('activo', 1)->get();

    } else {
        // 🔥 Si es coordinador → solo proveedores de su área
        $suppliers = \App\Models\Supplier::where('activo', 1)
            ->whereHas('areas', function ($query) use ($user) {
                $query->where('areas.id', $user->area_id);
            })
            ->get();
    }

    return view('purchase_requests.create', [
        'areas' => \App\Models\Area::all(),
        'projects' => \App\Models\Project::all(),
        'suppliers' => $suppliers,
        'units' => \App\Models\Unit::all(),
    ]);
}

private function numeroALetra($numero)
{
    $formatter = new \NumberFormatter("es", \NumberFormatter::SPELLOUT);

    $entero = floor($numero);
    $decimales = round(($numero - $entero) * 100);

    return strtoupper(
        $formatter->format($entero)
        . " PESOS "
        . str_pad($decimales, 2, '0', STR_PAD_LEFT)
        . "/100 M.N."
    );
}

public function index()
{
    $purchaseRequests = \App\Models\PurchaseRequest::where('estatus', '!=', 'cancelada')
        ->latest()
        ->get();

    return view('purchase_requests.index', compact('purchaseRequests'));
}

   public function store(Request $request)
{
    $request->validate([
    'fecha_requisicion' => 'required|date',
    'fecha_requerida' => 'required|date',
    'area_id' => 'required',
    'project_id' => 'required',
    'supplier_id' => 'required',
    'cotizacion' => 'nullable|string|max:255',
    'items' => 'required|array',
    'items.*.cantidad' => 'required|numeric|min:0',
    'items.*.precio_unitario' => 'required|numeric|min:0'
]);

    // 🔥 CREAR REQUISICIÓN
    $purchaseRequest = \App\Models\PurchaseRequest::create([
        'fecha_requisicion' => $request->fecha_requisicion,
        'fecha_requerida'   => $request->fecha_requerida,
        'solicitante'   => $request->solicitante,
        'cotizacion' => $request->cotizacion,
        'pozo'              => $request->pozo,
    'solicitud_trabajo' => $request->solicitud_trabajo,
        'area_id'           => $request->area_id,
        'project_id'        => $request->project_id,
        'supplier_id'       => $request->supplier_id,
        'moneda'            => $request->moneda,
        'condicion_pago'    => $request->condicion_pago,
        'estatus'           => 'en_revision', // 🔥 IMPORTANTE
        'user_id'           => auth()->id(),  // 🔥 IMPORTANTE
        'subtotal'          => 0,
        'descuento'         => 0,
        'iva'               => 0,
        'retencion_iva'     => 0,
        'retencion_isr'     => 0,
        'total'             => 0,
    ]);

    $subtotal = 0;

   foreach ($request->items as $index => $item) {

    $cantidad = $item['cantidad'] ?? 0;
    $precio   = $item['precio_unitario'] ?? 0;

    $totalItem = $cantidad * $precio;

    $subtotal += $totalItem;

    \App\Models\PurchaseRequestItem::create([
        'purchase_request_id' => $purchaseRequest->id,
        'item' => $index + 1,
        'cantidad' => $cantidad,
        'unit_id' => $item['unit_id'],
        'descripcion' => $item['descripcion'] ?? '',
        'precio_unitario' => $precio,
        'total' => $totalItem,
    ]);
}
   // 🔥 ACTUALIZAR TOTALES CORRECTAMENTE

$descuento = $request->descuento ?? 0;
$retencionIva = $request->retencion_iva ?? 0;
$retencionIsr = $request->retencion_isr ?? 0;

$iva = $subtotal * 0.16;

$total = $subtotal + $iva - $descuento - $retencionIva - $retencionIsr;

$purchaseRequest->update([
    'subtotal' => $subtotal,
    'descuento' => $descuento,
    'iva' => $iva,
    'retencion_iva' => $retencionIva,
    'retencion_isr' => $retencionIsr,
    'total' => $total,
    'total_letra' => $this->numeroALetra($total)
]);

    return redirect()
        ->route('purchase-requests.show', $purchaseRequest->id)
        ->with('success', 'Solicitud enviada correctamente');
}

    /*
    |--------------------------------------------------------------------------
    | MOSTRAR
    |--------------------------------------------------------------------------
    */
    public function show(PurchaseRequest $purchaseRequest)
    {
        $purchaseRequest->load([
            'supplier',
            'items.unit',
            'area',
            'project',
            'user'
        ]);

        return view('purchase_requests.show', compact('purchaseRequest'));
    }

    /*
    |--------------------------------------------------------------------------
    | CAMBIAR ESTATUS
    |--------------------------------------------------------------------------
    */
 public function changeStatus(
    Request $request,
    PurchaseRequest $purchaseRequest
) {

    $this->authorize('changeStatus', $purchaseRequest);

    $request->validate([
        'newStatus' => 'required|string',
        'num_requisicion' => 'nullable|string'
    ]);

    $this->service->changeStatus(
        $purchaseRequest,
        $request->input('newStatus'),
        $request->input('num_requisicion')
    );

    return redirect()
        ->route('purchase-requests.show', $purchaseRequest)
        ->with('success', 'Estatus actualizado correctamente');
}
public function pendientesCompras()
{
    $requisiciones = \App\Models\PurchaseRequest::with(['supplier','area','project','user'])
        ->where('estatus', 'en_revision')
        ->latest()
        ->get();

    return view('compras.pendientes', compact('requisiciones'));
}

    /*
    |--------------------------------------------------------------------------
    | PDF
    |--------------------------------------------------------------------------
    */
    public function pdf(PurchaseRequest $purchaseRequest)
    {
        if ($purchaseRequest->estatus === 'borrador') {
            abort(403, 'No se puede generar PDF en borrador.');
        }

        $purchaseRequest->load([
            'supplier',
            'items.unit',
            'area',
            'project',
            'user'
        ]);

        $pdf = Pdf::loadView(
            'purchase_requests.pdf',
            compact('purchaseRequest')
        );

        return $pdf->stream(
            'Requisicion-' .
            ($purchaseRequest->num_requisicion ?? 'SIN_NUMERO') .
            '.pdf'
        );
    }


    public function numeradas()
{
    $requisiciones = \App\Models\PurchaseRequest::where('estatus','numerada')
        ->orderBy('created_at','desc')
        ->get();

    return view('purchase_requests.numeradas', compact('requisiciones'));
}

public function aceptadas(Request $request)
{
    $query = \App\Models\PurchaseRequest::with('area')
        ->where('estatus', 'aprobada');

    // 🔎 Buscar por número
    if ($request->filled('numero')) {
        $query->where('num_requisicion', 'like', '%' . $request->numero . '%');
    }

    // 📅 Filtro fecha inicio
    if ($request->filled('fecha_inicio')) {
        $query->whereDate('fecha_requisicion', '>=', $request->fecha_inicio);
    }

    // 📅 Filtro fecha fin
    if ($request->filled('fecha_fin')) {
        $query->whereDate('fecha_requisicion', '<=', $request->fecha_fin);
    }

    $requisiciones = $query->latest()->get();

    return view('purchase_requests.aceptadas', compact('requisiciones'));
}

public function rechazadas()
{
    $requisiciones = \App\Models\PurchaseRequest::where('estatus','rechazada')
        ->latest()
        ->get();

    return view('purchase_requests.rechazadas', compact('requisiciones'));
}

public function devueltas()
{
    $requisiciones = \App\Models\PurchaseRequest::where('estatus','devuelta')
        ->where('user_id', auth()->id())
        ->latest()
        ->get();

    return view('purchase_requests.devueltas', compact('requisiciones'));
}

public function edit(PurchaseRequest $purchaseRequest)
{
    if (!in_array($purchaseRequest->estatus, ['devuelta','borrador'])) {
        abort(403);
    }

    $projects = \App\Models\Project::all();
    $suppliers = \App\Models\Supplier::all();
    $units = \App\Models\Unit::all();

    // Cargar partidas
    $purchaseRequest->load('items');

    return view('purchase_requests.edit', compact(
        'purchaseRequest',
        'projects',
        'suppliers',
        'units'
    ));
}
    

public function update(Request $request, PurchaseRequest $purchaseRequest)
{
    // 🔒 Solo permitir editar si está devuelta o borrador
    if (!in_array($purchaseRequest->estatus, ['devuelta','borrador'])) {
        abort(403);
    }

    $request->validate([
        'fecha_requisicion' => 'required|date',
        'fecha_requerida' => 'required|date',
        'solicitante' => 'required',
        'items' => 'required|array',
        'items.*.cantidad' => 'required|numeric|min:0',
        'items.*.precio_unitario' => 'required|numeric|min:0'
    ]);

    DB::transaction(function () use ($request, $purchaseRequest) {

        $purchaseRequest->update([
    'fecha_requisicion' => $request->fecha_requisicion,
    'fecha_requerida'   => $request->fecha_requerida,
    'solicitante'       => $request->solicitante,
    'pozo'              => $request->pozo,
    'solicitud_trabajo' => $request->solicitud_trabajo,
    'project_id'        => $request->project_id,
    'supplier_id'       => $request->supplier_id,
    'moneda'            => $request->moneda,          // 🔥 FALTABA
    'cotizacion'        => $request->cotizacion,      // 🔥 FALTABA
    'contacto'          => $request->contacto,
    'direccion'         => $request->direccion,
    'rfc'               => $request->rfc,
    'estatus'           => 'en_revision',
    'motivo_devolucion' => null,
    'fecha_devolucion'  => null,
    'devuelto_por'      => null,
]);

        // 🔥 BORRAR PARTIDAS ANTERIORES
        $purchaseRequest->items()->delete();

        $subtotal = 0;

        // 🔥 RECREAR PARTIDAS
        foreach ($request->items as $index => $item) {

            $cantidad = $item['cantidad'];
            $precio   = $item['precio_unitario'];

            $totalItem = $cantidad * $precio;
            $subtotal += $totalItem;

            \App\Models\PurchaseRequestItem::create([
                'purchase_request_id' => $purchaseRequest->id,
                'item' => $index + 1,
                'cantidad' => $cantidad,
                'unit_id' => $item['unit_id'] ?? null,
                'descripcion' => $item['descripcion'] ?? '',
                'precio_unitario' => $precio,
                'total' => $totalItem,
            ]);
        }

        // 🔥 CÁLCULOS FINANCIEROS
        $descuento = $request->descuento ?? 0;
        $ivaPorcentaje = $request->iva_porcentaje ?? 0;
        $iva = $subtotal * ($ivaPorcentaje / 100);
        $retencionIva = $request->retencion_iva ?? 0;
        $retencionIsr = $request->retencion_isr ?? 0;

        $total = $subtotal
                - $descuento
                + $iva
                - $retencionIva
                - $retencionIsr;

        $purchaseRequest->update([
            'subtotal' => $subtotal,
            'descuento' => $descuento,
            'iva' => $iva,
            'retencion_iva' => $retencionIva,
            'retencion_isr' => $retencionIsr,
            'total' => $total,
            'total_letra' => $this->numeroALetra($total)
        ]);


        /*
|--------------------------------------------------------------------------
| DEVOLVER (desde en_revision o numerada)
|--------------------------------------------------------------------------
*/

    });

    return redirect()
        ->route('purchase-requests.index')
        ->with('success', 'Requisición modificada y enviada nuevamente a revisión.');
}

public function destroy(PurchaseRequest $purchaseRequest)
{
    $this->authorize('delete', $purchaseRequest);

    DB::transaction(function () use ($purchaseRequest) {

        $purchaseRequest->update([
            'estatus' => 'cancelada'
        ]);

        // Opcional pero MUY recomendable
        \App\Models\PurchaseRequestLog::create([
            'purchase_request_id' => $purchaseRequest->id,
            'from_status' => $purchaseRequest->getOriginal('estatus'),
            'to_status' => 'cancelada',
            'changed_by' => auth()->id(),
            'reason' => 'Cancelada manualmente'
        ]);
    });

    return redirect()
        ->back()
        ->with('success', 'Requisición cancelada correctamente.');
}



public function canceladas()
{
    $requisiciones = PurchaseRequest::where('estatus','cancelada')
        ->where('user_id', auth()->id())
        ->latest()
        ->get();

    return view('purchase_requests.canceladas', compact('requisiciones'));
}


public function descargarTodasAceptadas(Request $request)
{
    $query = \App\Models\PurchaseRequest::where('estatus','aprobada');

    if ($request->filled('numero')) {
        $query->where('num_requisicion', 'like', '%' . $request->numero . '%');
    }

    if ($request->filled('fecha_inicio')) {
        $query->whereDate('fecha_requisicion', '>=', $request->fecha_inicio);
    }

    if ($request->filled('fecha_fin')) {
        $query->whereDate('fecha_requisicion', '<=', $request->fecha_fin);
    }

    $requisiciones = $query->get();

    $zip = new \ZipArchive;
    $fileName = 'requisiciones_aprobadas.zip';
    $tempFile = storage_path($fileName);

    if ($zip->open($tempFile, \ZipArchive::CREATE | \ZipArchive::OVERWRITE)) {

        foreach ($requisiciones as $req) {

            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
                'purchase_requests.pdf',
                ['purchaseRequest' => $req]
            );

            $zip->addFromString(
                'Requisicion-'.$req->num_requisicion.'.pdf',
                $pdf->output()
            );
        }

        $zip->close();
    }

    return response()->download($tempFile)->deleteFileAfterSend(true);
}




}