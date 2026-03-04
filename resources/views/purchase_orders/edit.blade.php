<x-app-layout>

<x-slot name="header">
    <h2 class="text-2xl font-bold text-slate-800">
        Editar Orden de Compra {{ $order->numero_oc }}
    </h2>
</x-slot>

<div class="max-w-6xl mx-auto bg-white text-black p-8 shadow rounded-2xl">
<div class="max-w-6xl mx-auto bg-white p-8 shadow rounded-2xl">

<form method="POST" action="{{ route('orders.update', $order->id) }}">
@csrf
@method('PUT')

{{-- ================= DATOS PROVEEDOR ================= --}}
<h3 class="text-lg font-bold mb-4">Datos del Proveedor</h3>

<div class="grid grid-cols-2 gap-6 mb-6">

<div>
<label class="block text-sm font-bold">Proveedor</label>
<input type="text" name="proveedor_nombre"
value="{{ $order->proveedor_nombre }}"
class="w-full border rounded-lg p-2">
</div>

<div>
<label class="block text-sm font-bold">Contacto</label>
<input type="text" name="proveedor_contacto"
value="{{ $order->proveedor_contacto }}"
class="w-full border rounded-lg p-2">
</div>

<div>
<label class="block text-sm font-bold">RFC</label>
<input type="text" name="proveedor_rfc"
value="{{ $order->proveedor_rfc }}"
class="w-full border rounded-lg p-2">
</div>

<div>
<label class="block text-sm font-bold">Dirección</label>
<input type="text" name="proveedor_direccion"
value="{{ $order->proveedor_direccion }}"
class="w-full border rounded-lg p-2">
</div>

</div>

<hr class="my-6">

{{-- ================= DATOS GENERALES ================= --}}
<h3 class="text-lg font-bold mb-4">Datos Generales</h3>

<div class="grid grid-cols-3 gap-6 mb-6">


<div>
<label class="text-sm font-bold">Número OC</label>

<input type="text"
name="numero_oc"
value="{{ $order->numero_oc }}"
placeholder="Ejemplo: CHS-2026-001"
class="w-full border rounded-lg p-2 font-bold text-indigo-600">

</div>

<div>
<label class="text-sm font-bold">No. Requisición</label>
<input type="text" name="numero_requisicion"
value="{{ $order->numero_requisicion }}"
class="w-full border rounded-lg p-2">
</div>

<div>
<label class="text-sm font-bold">Pozo</label>
<input type="text" name="pozo"
value="{{ $order->pozo }}"
class="w-full border rounded-lg p-2">
</div>

<div>
<label class="text-sm font-bold">Área</label>
<input type="text" name="area"
value="{{ $order->area }}"
class="w-full border rounded-lg p-2">
</div>

<div>
<label class="text-sm font-bold">Proyecto</label>
<input type="text" name="proyecto"
value="{{ $order->proyecto }}"
class="w-full border rounded-lg p-2">
</div>

<div>
<label class="text-sm font-bold">Solicitud de Trabajo</label>
<input type="text" name="solicitud_trabajo"
value="{{ $order->solicitud_trabajo }}"
class="w-full border rounded-lg p-2">
</div>

<div>
<label class="text-sm font-bold">Fecha</label>
<input type="date" name="fecha"
value="{{ $order->fecha }}"
class="w-full border rounded-lg p-2">
</div>

<div>
<label class="text-sm font-bold">Solicitante</label>
<input type="text" name="solicitante"
value="{{ $order->solicitante }}"
class="w-full border rounded-lg p-2">
</div>

<div>
<label class="text-sm font-bold">Condiciones de Pago</label>
<input type="text" name="condiciones_pago"
value="{{ $order->condiciones_pago }}"
class="w-full border rounded-lg p-2">
</div>

<div>
<label class="text-sm font-bold">Moneda</label>
<select name="moneda" class="w-full border rounded-lg p-2">
<option value="nacional" {{ $order->moneda=='nacional'?'selected':'' }}>NACIONAL</option>
<option value="dolares" {{ $order->moneda=='dolares'?'selected':'' }}>DOLARES</option>
</select>
</div>

<div>
<label class="text-sm font-bold">Cotización</label>
<input type="text" name="cotizacion"
value="{{ $order->cotizacion }}"
class="w-full border rounded-lg p-2">
</div>

</div>

<hr class="my-6">

{{-- ================= IMPORTES ================= --}}
<h3 class="text-lg font-bold mb-4">Importes</h3>

<div class="grid grid-cols-3 gap-6 mb-6">

<div>
<label class="text-sm font-bold">Subtotal</label>
<input type="number" step="0.01" name="subtotal"
value="{{ $order->subtotal }}"
class="w-full border rounded-lg p-2">
</div>

<div>
<label class="text-sm font-bold">Descuento</label>
<input type="number" step="0.01" name="descuento"
value="{{ $order->descuento }}"
class="w-full border rounded-lg p-2">
</div>

<div>
<label class="text-sm font-bold">IVA</label>
<input type="number" step="0.01" name="iva"
value="{{ $order->iva }}"
class="w-full border rounded-lg p-2">
</div>

<div>
<label class="text-sm font-bold">Retención IVA</label>
<input type="number" step="0.01" name="retencion_iva"
value="{{ $order->retencion_iva }}"
class="w-full border rounded-lg p-2">
</div>

<div>
<label class="text-sm font-bold">Retención ISR</label>
<input type="number" step="0.01" name="retencion_isr"
value="{{ $order->retencion_isr }}"
class="w-full border rounded-lg p-2">
</div>

<div>
<label class="text-sm font-bold">Total</label>
<input type="number" step="0.01" name="total"
value="{{ $order->total }}"
class="w-full border rounded-lg p-2">
</div>

</div>

<div class="mb-6">
<label class="text-sm font-bold">Importe en Letra</label>
<textarea name="total_letra"
class="w-full border rounded-lg p-2"
rows="2">{{ $order->total_letra }}</textarea>
</div>

<div class="mb-6">
<label class="text-sm font-bold">Autorizado Por</label>
<input type="text" name="autorizador_nombre"
value="{{ $order->autorizador_nombre }}"
class="w-full border rounded-lg p-2">
</div>

<hr class="my-6">

{{-- ================= PARTIDAS ================= --}}
<h3 class="text-lg font-bold mb-4">Partidas</h3>

@foreach($order->items as $item)
<div class="grid grid-cols-5 gap-4 mb-4 border p-4 rounded-lg">

<input type="hidden" name="items[{{ $item->id }}][id]" value="{{ $item->id }}">

<div>
<label class="text-xs">Cantidad</label>
<input type="number" step="0.01"
name="items[{{ $item->id }}][cantidad]"
value="{{ $item->cantidad }}"
class="w-full border rounded p-1">
</div>

<div>
<label class="text-xs">Unidad</label>
<input type="text"
name="items[{{ $item->id }}][unidad]"
value="{{ $item->unidad }}"
class="w-full border rounded p-1">
</div>

<div class="col-span-2">
<label class="text-xs">Descripción</label>
<input type="text"
name="items[{{ $item->id }}][descripcion]"
value="{{ $item->descripcion }}"
class="w-full border rounded p-1">
</div>

<div>
<label class="text-xs">Precio Unitario</label>
<input type="number" step="0.01"
name="items[{{ $item->id }}][precio_unitario]"
value="{{ $item->precio_unitario }}"
class="w-full border rounded p-1">
</div>

</div>
@endforeach

<div class="flex justify-end mt-6">
<button class="px-6 py-2 bg-purple-600 text-white rounded-xl font-bold">
Guardar Cambios
</button>
</div>

</form>
</div>
</div>

</x-app-layout>