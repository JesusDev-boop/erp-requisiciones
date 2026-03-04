<x-app-layout>

<x-slot name="header">
<div class="flex items-center justify-between">

<h2 class="text-3xl font-black text-white">
Reporte Financiero OC
</h2>

<a href="{{ route('orders.reportes.excel') }}"
class="px-4 py-2 bg-emerald-600 text-white rounded-xl text-xs font-bold">

Exportar Excel
</a>

</div>
</x-slot>


<div class="py-12">
<div class="max-w-7xl mx-auto space-y-10">


{{-- MONTO TOTAL --}}
<div class="p-10 bg-slate-900 rounded-3xl text-center">

<h4 class="text-xs uppercase text-slate-400 font-bold">
Monto Total Órdenes Emitidas
</h4>

<p class="text-5xl font-black text-emerald-400 mt-3">
$ {{ number_format($monto_total,2) }}
</p>

</div>


<div class="grid md:grid-cols-2 gap-8">

{{-- GASTO POR MES --}}
<div class="p-8 bg-white/5 rounded-3xl">

<h3 class="text-white font-bold mb-4">
Gasto por Mes
</h3>

<canvas id="gastoMes"></canvas>

</div>


{{-- GASTO POR PROVEEDOR --}}
<div class="p-8 bg-white/5 rounded-3xl">

<h3 class="text-white font-bold mb-4">
Monto por Proveedor
</h3>

<canvas id="proveedores"></canvas>

</div>

</div>


<div class="p-8 bg-white/5 rounded-3xl">

<h3 class="text-white font-bold mb-4">
Monto por Proyecto
</h3>

<canvas id="proyectos"></canvas>

</div>

</div>
</div>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const gastoMes = new Chart(
document.getElementById('gastoMes'),
{
type:'bar',
data:{
labels: @json($ordenes_mes->pluck('mes')),
datasets:[{
label:'Gasto',
data:@json($ordenes_mes->pluck('total'))
}]
}
});


const proveedores = new Chart(
document.getElementById('proveedores'),
{
type:'pie',
data:{
labels:@json($proveedores->pluck('proveedor_nombre')),
datasets:[{
data:@json($proveedores->pluck('total'))
}]
}
});


const proyectos = new Chart(
document.getElementById('proyectos'),
{
type:'doughnut',
data:{
labels:@json($proyectos->pluck('proyecto')),
datasets:[{
data:@json($proyectos->pluck('total'))
}]
}
});

</script>


</x-app-layout>