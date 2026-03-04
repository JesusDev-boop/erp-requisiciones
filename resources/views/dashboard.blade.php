<x-app-layout>
    <x-slot name="header">
    <div class="flex items-center justify-between">

        <div>
            <h2 class="text-3xl font-black text-white tracking-tight">
                Panel de Control
            </h2>
            <p class="text-sm text-slate-400 mt-1 font-medium">
                Vista general del sistema
            </p>
        </div>

         <div class="hidden md:block mr-80">
        <span class="px-6 py-2 bg-white/5 backdrop-blur-xl 
                     rounded-full border border-white/30 
                     text-xs font-bold text-slate-300 
                     uppercase tracking-widest shadow">
            Sesión: {{ auth()->user()->role }}
        </span>
    </div>

    </div>
</x-slot>

    <div class="py-12 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-16">

            {{-- ================= SECCIÓN: COORDINADOR ================= --}}
            @if(auth()->user()->role === 'coordinador')
            <div>
                <div class="flex items-center gap-3 mb-8">
                    <div class="p-2 bg-sky-500 rounded-lg shadow-lg shadow-sky-500/20">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white tracking-tight">
                        Panel Coordinador
                    </h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                    <a href="{{ route('purchase-requests.create') }}"
                       class="group p-8 rounded-[2rem] bg-white/5 backdrop-blur-xl border border-white/10 shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">

                        <div class="w-12 h-12 bg-sky-500/20 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-sky-500 transition-all">
                            <svg class="w-6 h-6 text-sky-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </div>

                        <h4 class="text-lg font-bold text-white">Nueva Requisición</h4>
                        <p class="text-sm text-slate-400 mt-1">Crear solicitud de compra</p>

                        <div class="mt-6 text-sky-400 font-bold flex items-center gap-1 group-hover:gap-3 transition-all">
                            Crear <small>→</small>
                        </div>
                    </a>

                    <a href="{{ route('suppliers.index') }}"
                       class="group p-8 rounded-[2rem] bg-white/5 backdrop-blur-xl border border-white/10 shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">

                        <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-sky-500 transition-all">
                            <svg class="w-6 h-6 text-slate-300 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16"/>
                            </svg>
                        </div>

                        <h4 class="text-lg font-bold text-white">Proveedores</h4>
                        <p class="text-sm text-slate-400 mt-1">Directorio de aliados</p>

                        <div class="mt-6 text-sky-400 font-bold flex items-center gap-1 group-hover:gap-3 transition-all">
                            Administrar <small>→</small>
                        </div>
                    </a>

                    <a href="{{ route('purchase-requests.index') }}"
                       class="group p-8 rounded-[2rem] bg-white/5 backdrop-blur-xl border border-white/10 shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">

                        <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-sky-500 transition-all">
                            <svg class="w-6 h-6 text-slate-300 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7"/>
                            </svg>
                        </div>

                        <h4 class="text-lg font-bold text-white">Mis Requisiciones</h4>
                        <p class="text-sm text-slate-400 mt-1">Seguimiento de estatus</p>

                        <div class="mt-6 text-sky-400 font-bold flex items-center gap-1 group-hover:gap-3 transition-all">
                            Ver listado <small>→</small>
                        </div>
                    </a>


                    <a href="{{ route('purchase-requests.devueltas') }}"
   class="group p-8 rounded-[2rem] bg-amber-500/10 backdrop-blur-xl border border-amber-400/20 shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">

    <div class="w-12 h-12 bg-amber-500/20 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-amber-500 transition-all">
        <svg class="w-6 h-6 text-amber-400 group-hover:text-white"
             fill="none"
             stroke="currentColor"
             viewBox="0 0 24 24">
            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M3 10h11M9 21V3m12 7a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
    </div>

    <h4 class="text-lg font-bold text-white">Devueltas</h4>
    <p class="text-sm text-slate-400 mt-1">
        Requisiciones para corregir
    </p>

    <div class="mt-6 text-amber-400 font-bold flex items-center gap-1 group-hover:gap-3 transition-all">
        Revisar <small>→</small>
    </div>

    {{-- Contador --}}
  <div class="mt-6 text-4xl font-black text-amber-400">
    {{ $stats['devueltas'] }}
</div>
</a>

                    <div class="p-8 rounded-[2rem] bg-slate-900 text-white shadow-2xl relative overflow-hidden flex flex-col justify-between border border-white/10">
                        <div class="relative z-10">
                            <h4 class="text-slate-400 font-bold text-xs uppercase tracking-widest mb-1">En Revisión</h4>
                            <p class="text-5xl font-black text-sky-400">
                                {{ $stats['en_revision'] }}
                            </p>
                        </div>
                        <p class="text-[10px] text-slate-500 mt-4 relative z-10 font-mono tracking-tighter">
                            PENDIENTES DE VALIDACIÓN
                        </p>
                        <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-sky-500/10 rounded-full blur-2xl"></div>
                    </div>

                </div>
            </div>
            @endif

           {{-- ================= SECCIÓN COMPRAS ================= --}}
@if(auth()->user()->role === 'compras')
<div>
    <div class="flex items-center gap-3 mb-8">
        <div class="p-2 bg-emerald-500 rounded-lg shadow-lg shadow-emerald-500/20">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 3h2l.4 2M7 13h10l4-8H5.4"/>
            </svg>
        </div>
        <h3 class="text-xl font-bold text-white tracking-tight">
            Panel Compras
        </h3>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

        {{-- PENDIENTES --}}
        <a href="{{ route('compras.pendientes') }}"
           class="group p-10 rounded-[2.5rem] bg-white/5 backdrop-blur-xl border border-white/10 shadow-xl hover:shadow-2xl transition-all">

            <h4 class="text-slate-400 font-bold text-xs uppercase tracking-widest mb-4">
                Requisiciones Pendientes
            </h4>

            <div class="flex items-baseline gap-4">
                <span class="text-6xl font-black text-white">
                   {{ $stats['en_revision'] }}
                </span>
                <span class="text-emerald-400 font-bold italic">
                    Nuevas solicitudes
                </span>
            </div>

            <p class="mt-6 text-sm text-slate-400 leading-relaxed">
                Acción: Revisar y numerar solicitudes entrantes.
            </p>
        </a>

        {{-- NUMERADAS --}}
        <a href="{{ route('purchase-requests.numeradas') }}"
           class="p-10 rounded-[2.5rem] bg-white/5 backdrop-blur-xl border border-white/10 shadow-xl hover:shadow-2xl transition-all">

            <h4 class="text-slate-400 font-bold text-xs uppercase tracking-widest mb-4">
                Numeradas
            </h4>

            <p class="text-6xl font-black text-white leading-none">
                {{ $stats['numeradas'] }}
            </p>

            <p class="mt-4 text-xs font-bold text-slate-400 uppercase tracking-tighter italic">
                Listas para orden de compra
            </p>
        </a>

        {{-- ACEPTADAS --}}
        <a href="{{ route('purchase-requests.aceptadas') }}"
           class="p-10 rounded-[2.5rem] bg-emerald-500/20 backdrop-blur-xl border border-emerald-400/20 shadow-xl hover:shadow-2xl transition-all">

            <h4 class="text-emerald-300 font-bold text-xs uppercase tracking-widest mb-4">
                Aceptadas
            </h4>

            <p class="text-6xl font-black text-white leading-none">
                {{ $stats['aprobadas'] }}
            </p>

            <p class="mt-4 text-xs font-bold text-emerald-200 uppercase tracking-tighter italic">
                Requisiciones aprobadas
            </p>
        </a>

        {{-- RECHAZADAS --}}
        <a href="{{ route('purchase-requests.rechazadas') }}"
           class="p-10 rounded-[2.5rem] bg-rose-500/20 backdrop-blur-xl border border-rose-400/20 shadow-xl hover:shadow-2xl transition-all">

            <h4 class="text-rose-300 font-bold text-xs uppercase tracking-widest mb-4">
                Rechazadas
            </h4>

            <p class="text-6xl font-black text-white leading-none">
               {{ $stats['rechazadas'] }}
            </p>

            <p class="mt-4 text-xs font-bold text-rose-200 uppercase tracking-tighter italic">
                Solicitudes rechazadas
            </p>
        </a>

 {{-- Historial AUt --}}

        <a href="{{ route('audit.index') }}"
   class="p-10 rounded-[2.5rem] bg-amber-500/20 backdrop-blur-xl border border-amber-400/20 shadow-xl hover:shadow-2xl transition-all">

    <h4 class="text-amber-300 font-bold text-xs uppercase tracking-widest mb-4">
        Auditoría
    </h4>

    <p class="text-6xl font-black text-white leading-none">
     {{ $stats['logs_total'] }}
    </p>

    <p class="mt-4 text-xs font-bold text-amber-200 uppercase tracking-tighter italic">
        Historial completo del sistema
    </p>
</a>

        {{-- TOTAL SISTEMA --}}
        <div class="p-10 rounded-[2.5rem] bg-slate-900 text-white shadow-2xl flex flex-col justify-center text-center border border-white/10">

            <h4 class="text-slate-400 font-bold text-xs uppercase tracking-widest mb-2">
                Total Sistema
            </h4>

            <p class="text-6xl font-black leading-none">
               {{ $stats['total_requisiciones'] }}
            </p>

            <div class="mt-4 h-1 bg-emerald-500 rounded-full"></div>
        </div>

    </div>
</div>

{{-- ================= MÓDULO ÓRDENES DE COMPRA ================= --}}
<div class="mt-16">

{{-- ================= BOTONES ACCIÓN OC ================= --}}
<div class="flex justify-end gap-4 mb-8">

</div>

    <div class="flex items-center gap-3 mb-8">
        <div class="p-2 bg-indigo-600 rounded-lg shadow-lg shadow-indigo-500/20">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7"/>
            </svg>
        </div>
        <h3 class="text-xl font-bold text-white tracking-tight">
            Órdenes de Compra
        </h3>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

        {{-- TOTAL OC --}}
        <a href="{{ route('orders.index') }}"
           class="p-10 rounded-[2.5rem] bg-indigo-500/20 backdrop-blur-xl border border-indigo-400/20 shadow-xl hover:shadow-2xl transition-all">

            <h4 class="text-indigo-300 font-bold text-xs uppercase tracking-widest mb-4">
                OC GENERADAS
            </h4>

            <p class="text-6xl font-black text-white leading-none">
             {{ $stats['total_oc'] }}
            </p>

            <p class="mt-4 text-xs font-bold text-indigo-200 uppercase tracking-tighter italic">
                Generadas en el sistema
            </p>
        </a>

        {{-- BORRADORES --}}
       <a href="{{ route('purchase_orders.borradores') }}"
           class="p-10 rounded-[2.5rem] bg-yellow-500/20 backdrop-blur-xl border border-yellow-400/20 shadow-xl hover:shadow-2xl transition-all">

            <h4 class="text-yellow-300 font-bold text-xs uppercase tracking-widest mb-4">
               CON NUMERO DE OC
            </h4>

            <p class="text-6xl font-black text-white leading-none">
               {{ $stats['oc_borradores'] }}
            </p>

            <p class="mt-4 text-xs font-bold text-yellow-200 uppercase tracking-tighter italic">
                Editables
            </p>
        </a>

        {{-- EMITIDAS --}}
        <a href="{{ route('purchase_orders.emitidas',['estatus'=>'emitida']) }}"
           class="p-10 rounded-[2.5rem] bg-emerald-500/20 backdrop-blur-xl border border-emerald-400/20 shadow-xl hover:shadow-2xl transition-all">

            <h4 class="text-emerald-300 font-bold text-xs uppercase tracking-widest mb-4">
                Emitidas
            </h4>

            <p class="text-6xl font-black text-white leading-none">
                {{ $stats['oc_emitidas'] }}
            </p>

            <p class="mt-4 text-xs font-bold text-emerald-200 uppercase tracking-tighter italic">
                Oficiales
            </p>
        </a>

        
        {{-- MONTO TOTAL --}}
<a href="{{ route('orders.monto_total') }}"
class="p-10 rounded-[2.5rem] bg-slate-900 text-white shadow-2xl flex flex-col items-center justify-center text-center border border-white/10 hover:scale-105 transition">

<h4 class="text-slate-400 font-bold text-xs uppercase tracking-widest mb-2">
Monto Total OCs
</h4>

<p class="text-3xl md:text-2xl font-black leading-none text-emerald-400">
CONCENTRADO
</p>

<p class="text-[11px] text-slate-500 mt-2 font-medium">
Ver análisis financiero
</p>

<div class="mt-4 h-1 bg-emerald-500 rounded-full"></div>

</a>
@endif

    </div>





{{-- ================= SECCIÓN ADMINISTRADOR ================= --}}
@if(auth()->user()->role === 'administrador')

<div>
    <div class="flex items-center gap-3 mb-8">
        <div class="p-2 bg-purple-600 rounded-lg shadow-lg shadow-purple-500/20">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 7h18M3 12h18M3 17h18"/>
            </svg>
        </div>
        <h3 class="text-xl font-bold text-white tracking-tight">
            Panel Administrador
        </h3>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

        <a href="{{ route('users.index') }}"
           class="p-8 rounded-[2rem] bg-purple-500/20 backdrop-blur-xl border border-purple-400/20 shadow-xl hover:shadow-2xl transition-all">
            <h4 class="text-purple-300 font-bold text-xs uppercase tracking-widest mb-4">
                Usuarios
            </h4>
            <p class="text-6xl font-black text-white leading-none">
               {{ $stats['usuarios'] }}
            </p>
        </a>

        <div class="p-8 rounded-[2rem] bg-white/5 backdrop-blur-xl border border-white/10 shadow-xl">
            <h4 class="text-slate-400 font-bold text-xs uppercase tracking-widest mb-4">
                Requisiciones
            </h4>
            <p class="text-6xl font-black text-white leading-none">
               {{ $stats['total_requisiciones'] }}
            </p>
        </div>

        <div class="p-8 rounded-[2rem] bg-indigo-500/20 backdrop-blur-xl border border-indigo-400/20 shadow-xl">
            <h4 class="text-indigo-300 font-bold text-xs uppercase tracking-widest mb-4">
                Órdenes de Compra
            </h4>
            <p class="text-6xl font-black text-white leading-none">
               {{ $stats['total_oc'] }}
            </p>
        </div>

        <a href="{{ route('audit.index') }}"
           class="p-8 rounded-[2rem] bg-amber-500/20 backdrop-blur-xl border border-amber-400/20 shadow-xl hover:shadow-2xl transition-all">
            <h4 class="text-amber-300 font-bold text-xs uppercase tracking-widest mb-4">
                Auditoría
            </h4>
            <p class="text-6xl font-black text-white leading-none">
               {{ $stats['logs_total'] }}
            </p>
        </a>

    </div>
</div>

@endif

{{-- ================= HISTORIAL GLOBAL ================= --}}
@if(in_array(auth()->user()->role, ['compras','administrador']))

<div class="mt-20">

    <div class="flex items-center gap-3 mb-8">
        <div class="p-2 bg-amber-500 rounded-lg shadow-lg shadow-amber-500/20">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <h3 class="text-xl font-bold text-white tracking-tight">
            Historial Global de Cambios
        </h3>
    </div>

    <div class="bg-white/5 backdrop-blur-xl 
                border border-white/10 
                shadow-2xl rounded-[2rem] p-8 text-white">

        @if(isset($logs) && $logs->isEmpty())
            <p class="text-slate-400 text-sm">
                No hay movimientos registrados.
            </p>
        @else

            <div class="space-y-4 max-h-[500px] overflow-y-auto pr-2">

                @foreach($logs as $log)

                    <div class="p-4 bg-white/5 rounded-xl border border-white/10 hover:bg-white/10 transition-all">

                        <div class="flex justify-between items-center">

                            <p class="text-sm">
                                Requisición
                                <span class="font-bold text-white">
                                    {{ $log->purchaseRequest->num_requisicion ?? 'Sin número' }}
                                </span>
                                cambió de
                                <span class="font-semibold text-slate-300">
                                    {{ ucfirst($log->from_status ?? '—') }}
                                </span>
                                →
                                <span class="text-amber-400 font-bold">
                                    {{ ucfirst($log->to_status) }}
                                </span>
                            </p>

                            <span class="text-xs text-slate-500">
                                {{ $log->created_at->format('d/m/Y H:i') }}
                            </span>

                        </div>

                        <p class="text-xs text-slate-400 mt-1">
                            Por: {{ $log->user->name ?? 'Sistema' }}
                        </p>

                    </div>

                @endforeach

            </div>

        @endif

    </div>

</div>

@endif

        </div>
    </div>
</x-app-layout>