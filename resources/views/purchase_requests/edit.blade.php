<x-app-layout>

<x-slot name="header">
<div class="flex items-center gap-4">

    <a href="{{ route('dashboard') }}"
       class="p-3 bg-white/5 border border-white/10 rounded-2xl text-white hover:bg-white/10 transition shadow-lg backdrop-blur-md group">
        <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1"
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2.5"
                  d="M15 19l-7-7 7-7" />
        </svg>
    </a>

    <div>
        <h2 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight">
            Editar Requisición
        </h2>

        <div class="flex items-center gap-2 mt-2 text-sm text-slate-300 font-semibold">
            <span>Solicitud</span>
            <svg class="w-4 h-4 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="text-white font-bold">
                #{{ $purchaseRequest->num_requisicion ?? $purchaseRequest->id }}
            </span>
        </div>
    </div>

</div>
</x-slot>

<div class="py-10 min-h-screen font-semibold text-slate-800">
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

<form method="POST" action="{{ route('purchase-requests.update',$purchaseRequest->id) }}">
@csrf
@method('PUT')

<div class="space-y-8">

{{-- ================= DATOS PROYECTO ================= --}}
<div class="bg-white border border-slate-200 shadow-sm rounded-3xl p-8">
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

<div>
<label class="label">Pozo / Ubicación</label>
<input type="text" name="pozo"
value="{{ old('pozo',$purchaseRequest->pozo) }}"
class="input">
</div>

<div>
<label class="label">Solicitud de Trabajo</label>
<input type="text" name="solicitud_trabajo"
value="{{ old('solicitud_trabajo',$purchaseRequest->solicitud_trabajo) }}"
class="input">
</div>

<div>
<label class="label">Proyecto</label>
<select name="project_id" class="input select-custom">
@foreach($projects as $project)
<option value="{{ $project->id }}"
{{ old('project_id',$purchaseRequest->project_id) == $project->id ? 'selected' : '' }}>
{{ $project->nombre }}
</option>
@endforeach
</select>
</div>



<div>
<label class="label">Fecha Requisición</label>
<input type="date" name="fecha_requisicion"
value="{{ old('fecha_requisicion',$purchaseRequest->fecha_requisicion) }}"
class="input" required>
</div>

<div>
<label class="label">Fecha Requerida</label>
<input type="date" name="fecha_requerida"
value="{{ old('fecha_requerida',$purchaseRequest->fecha_requerida) }}"
class="input" required>
</div>

<div>
<label class="label">Solicitante</label>
<input type="text" name="solicitante"
value="{{ old('solicitante',$purchaseRequest->solicitante) }}"
class="input" required>
</div>

</div>
</div>

{{-- ================= PROVEEDOR ================= --}}
<div class="bg-white border border-slate-200 shadow-sm rounded-3xl p-8">
<div class="grid grid-cols-1 md:grid-cols-4 gap-6">

<div class="md:col-span-2">
<label class="label">Proveedor</label>
<select name="supplier_id" id="supplier_select" class="input select-custom">
<option value="">Seleccione proveedor</option>
@foreach($suppliers as $supplier)
<option value="{{ $supplier->id }}"
data-rfc="{{ $supplier->rfc }}"
data-direccion="{{ $supplier->direccion }}"
data-contacto="{{ $supplier->contacto }}"
{{ old('supplier_id',$purchaseRequest->supplier_id) == $supplier->id ? 'selected' : '' }}>
{{ $supplier->nombre }}
</option>
@endforeach
</select>
</div>

<div>
<label class="label">RFC</label>
<input type="text" name="rfc" id="rfc"
value="{{ old('rfc',$purchaseRequest->rfc) }}"
class="input bg-slate-50 font-mono text-xs uppercase" readonly>
</div>

<div>
<label class="label">Contacto</label>
<input type="text" name="contacto" id="contacto"
value="{{ old('contacto',$purchaseRequest->contacto) }}"
class="input">
</div>

<div>
<label class="label">Dirección Fiscal</label>
<input type="text" name="direccion" id="direccion"
value="{{ old('direccion',$purchaseRequest->direccion) }}"
class="input bg-slate-50 text-xs" readonly>
</div>


<div>
    <label class="label">Moneda</label>
    <select name="moneda" class="input select-custom">
        <option value="nacional"
            {{ old('moneda',$purchaseRequest->moneda) == 'nacional' ? 'selected' : '' }}>
            MXN
        </option>

        <option value="dolares"
            {{ old('moneda',$purchaseRequest->moneda) == 'dolares' ? 'selected' : '' }}>
            USD
        </option>
    </select>
</div>

<div>
    <label class="label">Número de Cotización</label>
    <input type="text"
        name="cotizacion"
        value="{{ old('cotizacion',$purchaseRequest->cotizacion) }}"
        class="input font-bold text-sky-700"
        placeholder="Ej. 1982">
</div>

</div>
</div>

{{-- ================= PARTIDAS ================= --}}
<div class="bg-white border border-slate-200 shadow-xl rounded-3xl overflow-hidden font-semibold">


<div class="flex justify-between items-center p-6 border-b border-slate-200 bg-slate-50">
    <h3 class="font-bold text-slate-700">Partidas</h3>

    <button type="button"
        onclick="agregarFila()"
        class="bg-sky-600 hover:bg-sky-700 text-white px-4 py-2 rounded-xl text-xs font-bold shadow-md transition">
        + Agregar Producto
    </button>
</div>



<div class="overflow-x-auto">
<table class="w-full text-sm" id="items-table">
<thead class="bg-slate-900 text-white uppercase text-[10px] tracking-widest">
<tr>
<th class="p-4 text-center">#</th>
<th class="p-4 text-center w-24">Cant.</th>
<th class="p-4 text-center w-32">Unidad</th>
<th class="p-4 text-left">Descripción</th>
<th class="p-4 text-right w-40">Precio Unit.</th>
<th class="p-4 text-right w-40">Importe</th>
</tr>
</thead>

<tbody id="items-body">

@foreach($purchaseRequest->items as $index => $item)
<tr>
<td class="p-4 text-center item-number font-bold text-slate-400">
{{ $index+1 }}
</td>

<td class="p-2">
<input type="number" step="0.01"
name="items[{{ $index }}][cantidad]"
value="{{ rtrim(rtrim(number_format($item->cantidad,4,'.',''),'0'),'.') }}"
class="input-table text-center">
</td>

<td class="p-2">
<select name="items[{{ $index }}][unit_id]" class="input-table">
@foreach($units as $unit)
<option value="{{ $unit->id }}"
{{ $item->unit_id == $unit->id ? 'selected' : '' }}>
{{ $unit->nombre }}
</option>
@endforeach
</select>
</td>

<td class="p-2">
<input type="text"
name="items[{{ $index }}][descripcion]"
value="{{ $item->descripcion }}"
class="input-table">
</td>

<td class="p-2">
<input type="number" step="0.01"
name="items[{{ $index }}][precio_unitario]"
value="{{ rtrim(rtrim(number_format($item->precio_unitario,4,'.',''),'0'),'.') }}"
class="input-table text-right price">
</td>

<td class="p-4 total text-right font-bold font-mono text-slate-700">
${{ number_format($item->cantidad * $item->precio_unitario,2) }}
</td>



</tr>
@endforeach

</tbody>
</table>
</div>

{{-- PANEL TOTALES --}}
<div class="bg-slate-50 p-8 flex justify-end">
<div class="w-full md:w-80 space-y-3">

<div class="flex justify-between">
<span>Subtotal</span>
<span id="subtotal_display" class="font-bold">$0.00</span>
</div>

<div class="flex justify-between items-center">
<span class="text-xs uppercase">Descuento</span>
<input type="number" step="0.01"
name="descuento"
id="descuento"
value="{{ $purchaseRequest->descuento ?? 0 }}"
class="w-24 border rounded p-1 text-right">
</div>

<div class="flex justify-between items-center border-b pb-2">
<span>IVA (%)</span>
<input type="number"
step="0.01"
name="iva_porcentaje"
id="iva_porcentaje"
value="{{ $purchaseRequest->iva_porcentaje ?? 16 }}"
class="w-20 border-b text-right">
</div>

<div class="flex justify-between">
<span>IVA</span>
<span id="iva_display" class="font-bold">$0</span>
</div>

<div class="flex justify-between items-center text-xs italic">
<span>Retención IVA</span>
<input type="number" step="0.01"
name="retencion_iva"
id="retencion_iva"
value="{{ $purchaseRequest->retencion_iva ?? 0 }}"
class="w-20 border-b text-right">
</div>

<div class="flex justify-between items-center text-xs italic">
<span>Retención ISR</span>
<input type="number" step="0.01"
name="retencion_isr"
id="retencion_isr"
value="{{ $purchaseRequest->retencion_isr ?? 0 }}"
class="w-20 border-b text-right">
</div>

<div class="flex justify-between pt-4">
<span class="font-black uppercase">Total Final</span>
<span id="total_display" class="text-xl font-black text-sky-600">$0.00</span>
</div>

</div>
</div>

</div>

<div class="flex justify-end pt-10">
<button type="submit"
class="bg-slate-900 hover:bg-slate-800 text-white px-12 py-4 rounded-2xl font-bold shadow-2xl transition-all">
Actualizar Requisición
</button>
</div>

</div>
</form>
</div>
</div>

<script>

function calcularTotales(){

    let subtotal = 0;

    document.querySelectorAll('#items-body tr').forEach(row => {

        let cantidad = parseFloat(
            row.querySelector('input[name*="[cantidad]"]')?.value
        ) || 0;

        let precio = parseFloat(
            row.querySelector('input[name*="[precio_unitario]"]')?.value
        ) || 0;

        let totalFila = cantidad * precio;

        let totalCell = row.querySelector('.total');
        if(totalCell){
            totalCell.innerText = '$' + totalFila.toLocaleString('es-MX',{
                minimumFractionDigits:0,
                maximumFractionDigits:2
            });
        }

        subtotal += totalFila;

    });

    let descuento = parseFloat(document.getElementById('descuento')?.value) || 0;
    let retencionIva = parseFloat(document.getElementById('retencion_iva')?.value) || 0;
    let retencionIsr = parseFloat(document.getElementById('retencion_isr')?.value) || 0;
    let ivaPorcentaje = parseFloat(document.getElementById('iva_porcentaje')?.value) || 0;

    let iva = subtotal * (ivaPorcentaje / 100);

    let totalFinal = subtotal + iva - descuento - retencionIva - retencionIsr;

    document.getElementById('subtotal_display').innerText =
        '$' + subtotal.toLocaleString('es-MX',{minimumFractionDigits:0, maximumFractionDigits:2});

    document.getElementById('iva_display').innerText =
        '$' + iva.toLocaleString('es-MX',{minimumFractionDigits:0, maximumFractionDigits:2});

    document.getElementById('total_display').innerText =
        '$' + totalFinal.toLocaleString('es-MX',{minimumFractionDigits:0, maximumFractionDigits:2});
}


function agregarFila(){

    const tbody = document.getElementById('items-body');

    const rowCount = tbody.querySelectorAll('tr').length;

    const nuevaFila = document.createElement('tr');

    nuevaFila.innerHTML = `
        <td class="p-4 text-center item-number font-bold text-slate-400">
            ${rowCount + 1}
        </td>

        <td class="p-2">
            <input type="number" step="0.01"
                name="items[${rowCount}][cantidad]"
                class="input-table text-center">
        </td>

        <td class="p-2">
            <select name="items[${rowCount}][unit_id]" class="input-table">
                @foreach($units as $unit)
                    <option value="{{ $unit->id }}">{{ $unit->nombre }}</option>
                @endforeach
            </select>
        </td>

        <td class="p-2">
            <input type="text"
                name="items[${rowCount}][descripcion]"
                class="input-table">
        </td>

        <td class="p-2">
            <input type="number" step="0.01"
                name="items[${rowCount}][precio_unitario]"
                class="input-table text-right price">
        </td>

        <td class="p-4 total text-right font-bold font-mono text-slate-700">
            $0
        </td>
    `;

    tbody.appendChild(nuevaFila);

}


document.addEventListener('input',function(e){
if(
    e.target.name?.includes('[cantidad]') ||
    e.target.name?.includes('[precio_unitario]') ||
    e.target.id === 'descuento' ||
    e.target.id === 'retencion_iva' ||
    e.target.id === 'retencion_isr' ||
    e.target.id === 'iva_porcentaje'   // 🔥 ESTA LÍNEA FALTABA
){
    calcularTotales();
}});

window.addEventListener('DOMContentLoaded', function(){
    calcularTotales();

    let select = document.getElementById('supplier_select');
    if(select){
        let selected = select.options[select.selectedIndex];

        document.getElementById('rfc').value =
            selected.getAttribute('data-rfc') || '';

        document.getElementById('direccion').value =
            selected.getAttribute('data-direccion') || '';

        document.getElementById('contacto').value =
            selected.getAttribute('data-contacto') || '';
    }


    document.addEventListener('blur',function(e){
    if(e.target.name?.includes('[precio_unitario]')){
        let val = parseFloat(e.target.value) || 0;
        e.target.value = val.toFixed(2).replace(/\.?0+$/,'');
    }
},true);

document.addEventListener('blur', function(e){

    if(e.target.name?.includes('[precio_unitario]') ||
       e.target.name?.includes('[cantidad]')){

        let val = parseFloat(e.target.value);

        if(!isNaN(val)){
            e.target.value = val
                .toFixed(4)
                .replace(/\.?0+$/,'');
        }

    }

}, true);


document.addEventListener('change', function(e){

    if(e.target && e.target.id === 'supplier_select'){

        let selected = e.target.options[e.target.selectedIndex];

        document.getElementById('rfc').value =
            selected.getAttribute('data-rfc') || '';

        document.getElementById('direccion').value =
            selected.getAttribute('data-direccion') || '';

        document.getElementById('contacto').value =
            selected.getAttribute('data-contacto') || '';
    }

});

});
</script>

<style>
.bg-white,.bg-white *{color:#1e293b!important}
thead.bg-slate-900,thead.bg-slate-900 *{color:white!important}
.input,.input-table{color:#000!important;background:#fff!important}
</style>

</x-app-layout>