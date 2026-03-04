<x-app-layout>

<x-slot name="header">
    <div class="flex items-center gap-4">

        {{-- Botón Regresar --}}
        <a href="{{ route('dashboard') }}"
           class="p-3 bg-white/5 border border-white/10 rounded-2xl 
                  text-white hover:bg-white/10 hover:border-white/20 
                  transition-all shadow-lg backdrop-blur-md group">

            <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2.5"
                      d="M15 19l-7-7 7-7" />

            </svg>

        </a>

        <div>
            <h2 class="text-3xl font-black text-yellow-400 tracking-tight">
                Órdenes Generadas
            </h2>

            <p class="text-sm text-slate-300 mt-1 font-semibold">
                Órdenes pendientes de asignación y emisión
            </p>
        </div>

    </div>
</x-slot>

<div class="py-12 min-h-screen">
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

<div class="bg-white shadow-2xl rounded-[2.5rem] overflow-hidden border border-slate-200">

{{-- ================= RESUMEN ================= --}}
<div class="p-10 bg-gradient-to-r from-yellow-50 to-yellow-100 border-b border-yellow-200">

    <div class="flex items-center justify-between">

        <div>
            <h3 class="text-xs uppercase tracking-widest text-yellow-600 font-black">
                Total de Órdenes en Borrador
            </h3>

            <p class="text-6xl font-black text-yellow-700 leading-none mt-3">
                {{ $orders->count() }}
            </p>
        </div>

        <div class="text-right">
            <span class="px-6 py-3 rounded-full 
                         bg-yellow-500 text-white 
                         text-xs font-bold uppercase tracking-widest shadow-lg">
                EDITABLES
            </span>
        </div>

    </div>

</div>

{{-- ================= TABLA ================= --}}
@if($orders->isEmpty())

<div class="text-center py-24">
    <h3 class="text-xl font-bold text-slate-800">
        No hay órdenes en borrador
    </h3>
    <p class="text-slate-500 mt-2">
        Cuando existan aparecerán aquí.
    </p>
</div>

@else

<div class="overflow-x-auto">
<table class="w-full text-sm">

<thead class="bg-slate-900 text-white uppercase text-[11px] tracking-widest">
<tr>
<th class="p-6 text-left">Número OC</th>
<th class="p-6 text-left">Proveedor</th>
<th class="p-6 text-left">Proyecto</th>
<th class="p-6 text-right">Total</th>
<th class="p-6 text-center">Acciones</th>
</tr>
</thead>

<tbody class="divide-y divide-slate-100">

@foreach($orders as $order)

<tr class="hover:bg-yellow-50 transition-all duration-200">

<td class="p-6 font-bold text-yellow-600">
    {{ $order->numero_oc ?? 'SIN ASIGNAR' }}
</td>

<td class="p-6 text-slate-700 font-semibold">
    {{ $order->proveedor_nombre }}
</td>

<td class="p-6 text-slate-500">
    {{ $order->proyecto }}
</td>

<td class="p-6 text-right font-black text-emerald-600 font-mono">
    ${{ number_format($order->total,2) }}
</td>

<td class="p-6 text-center">
    <div class="flex items-center justify-center gap-3 flex-wrap">

        {{-- EDITAR --}}
        <a href="{{ route('orders.edit',$order->id) }}"
           class="px-4 py-2 bg-purple-600 hover:bg-purple-700
                  text-white rounded-xl text-xs font-bold 
                  uppercase tracking-wider shadow-md transition-all">
            Editar
        </a>

        {{-- PDF --}}
        <a href="{{ route('orders.pdf',$order->id) }}"
           target="_blank"
           class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700
                  text-white rounded-xl text-xs font-bold 
                  uppercase tracking-wider shadow-md transition-all">
            PDF
        </a>

      {{-- BOTON EMITIR --}}
<button type="button"
onclick="confirmEmit({{ $order->id }}, '{{ $order->numero_oc }}', this)"
class="emit-btn px-4 py-2 bg-indigo-600 hover:bg-indigo-700
text-white rounded-xl text-xs font-bold uppercase
tracking-wider shadow-md transition-all flex items-center gap-2">

<span class="emit-text">Emitir</span>

<svg class="emit-loader hidden animate-spin h-4 w-4 text-white"
xmlns="http://www.w3.org/2000/svg"
fill="none"
viewBox="0 0 24 24">

<circle class="opacity-25"
cx="12"
cy="12"
r="10"
stroke="currentColor"
stroke-width="4">
</circle>

<path class="opacity-75"
fill="currentColor"
d="M4 12a8 8 0 018-8v4l3-3-3-3v4A8 8 0 004 12z">
</path>

</svg>

</button>

<form id="emitForm{{ $order->id }}"
action="{{ route('orders.emitir',$order->id) }}"
method="POST"
class="hidden">

@csrf
@method('PATCH')

</form>

</div>
</td>

</tr>

@endforeach
</tbody>
</table>
</div>

@endif

</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

function confirmEmit(id, numero_oc, button){

// 🔴 VALIDAR NUMERO OC
if(!numero_oc){

Swal.fire({
icon:'error',
title:'Número de OC faltante',
text:'Debes asignar un número de OC antes de emitir la orden.',
confirmButtonColor:'#ef4444'
})

return

}

Swal.fire({

title: 'Emitir Orden de Compra',
text: "La orden pasará a estado EMITIDA",
icon: 'warning',
showCancelButton: true,
confirmButtonColor: '#6366f1',
cancelButtonColor: '#64748b',
confirmButtonText: 'Sí, emitir',
cancelButtonText: 'Cancelar',
showLoaderOnConfirm: true,

preConfirm: () => {

return new Promise((resolve) => {

button.disabled = true

const text = button.querySelector('.emit-text')
if(text){
text.innerText = "Procesando..."
}

const loader = button.querySelector('.emit-loader')
if(loader){
loader.classList.remove('hidden')
}

setTimeout(() => {

document.getElementById('emitForm'+id).submit()

},800)

})

}

})

}

</script>
</x-app-layout>