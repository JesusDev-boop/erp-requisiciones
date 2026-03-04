<x-app-layout>
<x-slot name="header">

<div class="flex items-center justify-between gap-6">

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
d="M15 19l-7-7 7-7"/>

</svg>

</a>

<div>

<nav class="flex mb-2 text-[10px] uppercase tracking-widest font-bold text-slate-500">

<span>Admin</span>
<span class="mx-2">/</span>
<span>Reportes</span>
<span class="mx-2">/</span>
<span class="text-emerald-400">Análisis Financiero</span>

</nav>

<h2 class="text-3xl font-extrabold text-white tracking-tight">
Intelligence
<span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-cyan-400">
Dashboard
</span>
</h2>

<p class="text-sm text-slate-400 mt-1">
Monitoreo financiero de órdenes de compra
</p>

</div>

</div>


{{-- Botón Exportar --}}
<div class="flex items-center gap-3">

<a href="{{ route('orders.reportes.excel') }}"
class="flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-500 
text-white text-xs font-bold rounded-lg shadow-lg transition">

Exportar Excel

</a>

</div>

</div>

</x-slot>


<div class="py-8 bg-[#0b1120] min-h-screen">

<div class="max-w-7xl mx-auto px-4 space-y-8">

<form method="GET">

<div class="bg-slate-900 border border-slate-800 p-4 rounded-2xl flex flex-wrap items-center gap-4">

<input type="date"
name="fecha_inicio"
value="{{ request('fecha_inicio') }}"
class="bg-slate-800 text-white text-xs rounded-lg px-3 py-2">

<input type="date"
name="fecha_fin"
value="{{ request('fecha_fin') }}"
class="bg-slate-800 text-white text-xs rounded-lg px-3 py-2">


<button
class="bg-emerald-500 hover:bg-emerald-400 text-black text-xs font-bold px-4 py-2 rounded-lg">

Filtrar

</button>

</div>

</form>

{{-- KPI --}}
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">


<div class="bg-slate-900 border border-slate-800 p-7 rounded-3xl">

<p class="text-xs uppercase text-slate-500 font-bold">
Inversión Total
</p>

<h3 class="text-4xl font-black text-emerald-400 mt-3">
$ {{ number_format($total_inversion,2) }}
</h3>

<p class="text-xs text-slate-500 mt-2">
Total invertido en órdenes emitidas
</p>

</div>



<div class="bg-slate-900 border border-slate-800 p-7 rounded-3xl">

<p class="text-xs uppercase text-slate-500 font-bold">
Órdenes Emitidas
</p>

<h3 class="text-4xl font-black text-blue-400 mt-3">
{{ number_format($total_ordenes) }}
</h3>

<p class="text-xs text-slate-500 mt-2">
Total de órdenes generadas
</p>

</div>



<div class="bg-slate-900 border border-slate-800 p-7 rounded-3xl">

<p class="text-xs uppercase text-slate-500 font-bold">
Ticket Promedio
</p>

<h3 class="text-4xl font-black text-purple-400 mt-3">
$ {{ number_format($promedio_ticket,2) }}
</h3>

<p class="text-xs text-slate-500 mt-2">
Costo promedio por orden
</p>

</div>


</div>

<div class="bg-slate-900 border border-slate-800 p-6 rounded-2xl mt-8">

<h3 class="text-white font-bold mb-4">
Crecimiento Mensual (%)
</h3>

<canvas id="graficaCrecimiento"></canvas>

</div>



{{-- ANALYTICS --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">


<div class="lg:col-span-2 bg-slate-900 border border-slate-800 p-8 rounded-3xl">

<div class="flex items-center justify-between mb-6">

<h3 class="text-lg font-bold text-white">
Visualización de Datos
</h3>

<select id="tipoGrafica"
class="bg-slate-800 text-white text-xs px-3 py-2 rounded-lg">

<option value="mes">Gasto Mensual</option>
<option value="proveedor">Top Proveedores</option>
<option value="proyecto">Monto por Proyecto</option>
<option value="area">Monto por Área</option>

</select>

</div>

<div class="h-[380px]">
<canvas id="graficaPrincipal"></canvas>
</div>

</div>



{{-- ULTIMAS ORDENES --}}
<div class="bg-slate-900 border border-slate-800 rounded-3xl overflow-hidden">

<div class="p-6 border-b border-slate-800">

<h3 class="text-white font-bold">
Últimas Órdenes
</h3>

</div>


<div class="p-4 space-y-3 max-h-[420px] overflow-y-auto">

@foreach($ultimas_ordenes as $orden)

<div class="flex items-center justify-between bg-slate-800 p-3 rounded-lg">

<div>

<p class="text-sm font-bold text-white">
{{ $orden->numero_oc }}
</p>

<p class="text-xs text-slate-400">
{{ $orden->proveedor_nombre }}
</p>

</div>

<div class="text-right">

<p class="text-sm font-bold text-white">
$ {{ number_format($orden->total,2) }}
</p>

<span class="text-[10px] text-emerald-400">
{{ ucfirst($orden->estatus) }}
</span>

</div>

</div>

@endforeach

</div>

</div>


</div>

</div>

</div>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

Chart.defaults.color = '#94a3b8';

let chart;

const ctx = document.getElementById('graficaPrincipal').getContext('2d');

const meses=[
'',
'Enero','Febrero','Marzo','Abril','Mayo','Junio',
'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'
];


const store={

mes:{
labels:@json($ordenes_mes->pluck('label')).map(m=>meses[m]),
data:@json($ordenes_mes->pluck('total'))
},

prov:{
labels:@json($proveedores->pluck('label')),
data:@json($proveedores->pluck('total'))
},

proy:{
labels:@json($proyectos->pluck('label')),
data:@json($proyectos->pluck('total'))
},

area:{
labels:@json($areas->pluck('label')),
data:@json($areas->pluck('total'))
}

};


function renderChart(type){

if(chart) chart.destroy();

let config={

options:{

responsive:true,

animation:{
duration:900,
easing:'easeOutQuart'
},

plugins:{

legend:{display:false},

tooltip:{
callbacks:{
label:function(context){
return '$ '+context.raw.toLocaleString('es-MX',{minimumFractionDigits:2})+' MXN';
}
}
}

}

}

};


switch(type){

case 'mes':

config.type='line';

config.data={

labels:store.mes.labels,

datasets:[{

data:store.mes.data,

borderColor:'#10b981',

backgroundColor:'rgba(16,185,129,0.15)',

fill:true,

tension:0.4

}]

};

break;



case 'proveedor':

config.type='doughnut';

config.data={

labels:store.prov.labels.slice(0,5),

datasets:[{

data:store.prov.data.slice(0,5),

backgroundColor:['#10b981','#3b82f6','#8b5cf6','#f59e0b','#ef4444']

}]

};

break;



case 'proyecto':

config.type='bar';

config.data={

labels:store.proy.labels,

datasets:[{

data:store.proy.data,

backgroundColor:'#3b82f6'

}]

};

break;



case 'area':

config.type='bar';

config.data={

labels:store.area.labels,

datasets:[{

data:store.area.data,

backgroundColor:'#8b5cf6'

}]

};

break;

}


chart=new Chart(ctx,config);

}


renderChart('mes');

document.getElementById('tipoGrafica').addEventListener('change',e=>{
renderChart(e.target.value);
});










const crecimiento = @json($crecimiento);

new Chart(document.getElementById('graficaCrecimiento'),{

type:'line',

data:{
labels:store.mes.labels.slice(1),

datasets:[{

label:'Crecimiento %',

data:crecimiento,

borderColor:'#f59e0b',

backgroundColor:'rgba(245,158,11,0.15)',

fill:true,

tension:0.4

}]

},

options:{

plugins:{
legend:{display:false}
},

scales:{
y:{
ticks:{
callback:(value)=> value + '%'
}
}
}

}

});

</script>



</x-app-layout>