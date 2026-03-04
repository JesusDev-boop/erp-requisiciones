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
            <h2 class="text-3xl font-black text-emerald-400 tracking-tight">
                Órdenes Emitidas
            </h2>

            <p class="text-sm text-slate-400 mt-1 font-semibold">
                Órdenes oficiales generadas
            </p>
        </div>

    </div>
</x-slot>


<div class="py-12 min-h-screen">
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

<div class="bg-white/5 backdrop-blur-xl 
border border-emerald-400/20 
shadow-2xl rounded-[2.5rem] overflow-hidden">

{{-- FILTROS --}}
<div class="p-8 border-b border-white/10 bg-white/5">

<form method="GET" class="grid md:grid-cols-4 gap-4 items-end">

<div>
<label class="text-xs text-slate-400 font-bold">Número OC</label>

<input type="text"
name="numero_oc"
value="{{ request('numero_oc') }}"
placeholder="Buscar OC..."
class="w-full px-4 py-2 rounded-xl bg-white/10 text-white border border-white/20 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/30">
</div>


<div>
<label class="text-xs text-slate-400 font-bold">Desde</label>

<input type="date"
name="fecha_inicio"
value="{{ request('fecha_inicio') }}"
class="w-full px-4 py-2 rounded-xl bg-white/10 text-white border border-white/20 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/30">
</div>


<div>
<label class="text-xs text-slate-400 font-bold">Hasta</label>

<input type="date"
name="fecha_fin"
value="{{ request('fecha_fin') }}"
class="w-full px-4 py-2 rounded-xl bg-white/10 text-white border border-white/20 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/30">
</div>


<a href="{{ route('orders.zip', request()->only('fecha_inicio','fecha_fin','numero_oc')) }}"
class="px-4 py-2 bg-purple-600 hover:bg-purple-700
text-white rounded-xl text-xs font-bold shadow-lg transition">

Descargar ZIP Filtrado

</a>

<div>
<button type="submit"
class="w-full px-4 py-2 bg-indigo-600 hover:bg-indigo-700
text-white rounded-xl text-xs font-bold shadow-lg transition">

Filtrar
</button>
</div>

</form>

</div>


{{-- RESUMEN --}}
<div class="p-10 border-b border-white/10 bg-emerald-500/10">

<div class="flex items-center justify-between">

<div>
<h3 class="text-xs uppercase tracking-widest text-emerald-300 font-bold">
TOTAL EMITIDAS
</h3>

<p class="text-4xl font-extrabold text-emerald-300 mt-2 leading-none">
{{ $orders->total() }}
</p>

</div>

</div>

</div>


{{-- TABLA --}}
@if($orders->isEmpty())

<div class="text-center py-24">

<h3 class="text-xl font-bold text-white">
No hay órdenes emitidas
</h3>

<p class="text-slate-400 mt-2">
Cuando se emitan aparecerán aquí.
</p>

</div>

@else

<div class="overflow-x-auto">

<table class="w-full text-sm text-slate-300">

<thead class="bg-emerald-500/10 border-b border-emerald-400/20 uppercase text-[11px] tracking-widest">

<tr>
<th class="p-6 text-left">Número OC</th>
<th class="p-6 text-left">Proveedor</th>
<th class="p-6 text-left">Proyecto</th>
<th class="p-6 text-right">Total</th>
<th class="p-6 text-center">Acciones</th>
</tr>

</thead>

<tbody class="divide-y divide-white/5">

@foreach($orders as $order)

<tr class="hover:bg-emerald-400/10 hover:shadow-lg transition-all duration-200 cursor-pointer">

<td class="p-6">

<div class="flex items-start gap-3">

{{-- ICONO DOCUMENTO --}}
<div class="mt-1 text-emerald-400">
<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
d="M9 12h6m-6 4h6M7 4h7l5 5v11a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z"/>
</svg>
</div>

<div class="flex flex-col">

{{-- NUMERO OC CON COPIAR --}}
<span onclick="copiarOC('{{ $order->numero_oc }}')"
class="font-bold text-emerald-300 cursor-pointer hover:text-emerald-200">

{{ $order->numero_oc }}

</span>

<span class="text-xs text-slate-400 mt-1">
{{ \Carbon\Carbon::parse($order->fecha)->format('d/m/Y') }}
</span>

</div>

</div>

</td>
<td class="p-6 text-white font-semibold">
{{ $order->proveedor_nombre }}
</td>

<td class="p-6 text-slate-400">
{{ $order->proyecto }}
</td>

<td class="p-6 text-right font-black text-emerald-400 font-mono">
${{ number_format($order->total,2) }}
</td>

<td class="p-6 text-center">

<div class="flex items-center justify-center gap-2 flex-wrap">

<a href="{{ route('orders.edit',$order->id) }}"
class="px-3 py-2 bg-indigo-600 hover:bg-indigo-700
text-white rounded-xl text-xs font-bold transition">
Ver
</a>

<a href="{{ route('orders.pdf',$order->id) }}"
target="_blank"
class="px-3 py-2 bg-emerald-600 hover:bg-emerald-700
text-white rounded-xl text-xs font-bold transition">
PDF
</a>

<a href="{{ route('orders.pdf',$order->id) }}?download=1"
class="px-3 py-2 bg-sky-600 hover:bg-sky-700
text-white rounded-xl text-xs font-bold transition">
Descargar
</a>

{{-- ELIMINAR --}}
<form action="{{ route('orders.destroy',$order->id) }}"
method="POST"
onsubmit="return confirm('¿Eliminar esta orden?')">

@csrf
@method('DELETE')

<button
class="px-3 py-2 bg-rose-600 hover:bg-rose-700
text-white rounded-xl text-xs font-bold transition">

Eliminar

</button>

</form>

</div>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>


<div class="p-6 border-t border-white/10">
{{ $orders->withQueryString()->links() }}
</div>

@endif

</div>
</div>
</div>


<script>

function copiarOC(numero){

navigator.clipboard.writeText(numero);

const toast = document.createElement("div");

toast.innerText = "OC copiada: " + numero;

toast.style.position="fixed";
toast.style.bottom="30px";
toast.style.right="30px";
toast.style.background="#059669";
toast.style.color="white";
toast.style.padding="10px 16px";
toast.style.borderRadius="10px";
toast.style.fontSize="12px";
toast.style.boxShadow="0 10px 20px rgba(0,0,0,0.3)";
toast.style.zIndex="9999";

document.body.appendChild(toast);

setTimeout(()=>{
toast.remove();
},2000);

}

</script>

</x-app-layout>