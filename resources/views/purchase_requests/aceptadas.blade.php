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
            <h2 class="text-3xl font-black text-white tracking-tight">
                Requisiciones Aceptadas
            </h2>

            <p class="text-sm text-emerald-400 mt-1 font-semibold">
                Listado oficial de requisiciones aprobadas
            </p>
        </div>

    </div>
</x-slot>

<div class="py-16">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        <div class="bg-white/5 backdrop-blur-xl 
                    border border-white/10 
                    shadow-2xl rounded-[2.5rem] overflow-hidden">

            {{-- 🔎 FILTROS --}}
            <div class="p-6 border-b border-white/10">

                <form method="GET" class="grid md:grid-cols-5 gap-4 items-end">

                    {{-- Número --}}
                    <div>
                        <label class="text-xs text-slate-400">Número</label>
                        <input type="text"
                               name="numero"
                               value="{{ request('numero') }}"
                               placeholder="Buscar número..."
                               class="w-full px-4 py-2 rounded-xl bg-white/10 text-white border border-white/20
                                      focus:outline-none focus:ring-2 focus:ring-sky-500 text-sm">
                    </div>

                    {{-- Fecha inicio --}}
                    <div>
                        <label class="text-xs text-slate-400">Desde</label>
                        <input type="date"
                               name="fecha_inicio"
                               value="{{ request('fecha_inicio') }}"
                               class="w-full px-4 py-2 rounded-xl bg-white/10 text-white border border-white/20">
                    </div>

                    {{-- Fecha fin --}}
                    <div>
                        <label class="text-xs text-slate-400">Hasta</label>
                        <input type="date"
                               name="fecha_fin"
                               value="{{ request('fecha_fin') }}"
                               class="w-full px-4 py-2 rounded-xl bg-white/10 text-white border border-white/20">
                    </div>

                    {{-- Botón buscar --}}
                    <div>
                        <button type="submit"
                                class="w-full px-4 py-2 bg-sky-600 hover:bg-sky-700
                                       text-white rounded-xl text-xs font-bold transition-all shadow-lg">
                            Buscar
                        </button>
                    </div>

                    {{-- Descargar ZIP --}}
                    <div>
                        <a href="{{ route('purchase-requests.aceptadas.descargar', request()->all()) }}"
                           class="block text-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700
                                  text-white rounded-xl text-xs font-bold transition-all shadow-lg">
                            Descargar ZIP
                        </a>
                    </div>

                </form>

            </div>

            @if($requisiciones->isEmpty())

                {{-- Estado vacío --}}
                <div class="text-center py-24">
                    <div class="h-20 w-20 mx-auto mb-6 
                                bg-slate-800/60 rounded-full 
                                flex items-center justify-center">
                        <svg class="w-10 h-10 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>

                    <h3 class="text-xl font-bold text-white">
                        No hay requisiciones aceptadas
                    </h3>
                    <p class="text-slate-400 mt-2">
                        Cuando existan aprobaciones aparecerán aquí.
                    </p>
                </div>

            @else

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-slate-300">

                        <thead class="bg-white/5 border-b border-white/10 uppercase text-[11px] tracking-widest">
                            <tr>
                                <th class="p-5 text-left">ID</th>
                                <th class="p-5 text-left">Número</th>
                                <th class="p-5 text-left">Fecha</th>
                                <th class="p-5 text-left">Solicitante</th>
                                <th class="p-5 text-left">Área</th>
                                <th class="p-5 text-right">Total</th>
                                <th class="p-5 text-center">Acciones</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-white/5">
                            @foreach($requisiciones as $req)
                                <tr class="hover:bg-white/5 transition-all duration-200">

                                    <td class="p-5 font-mono text-slate-400">
                                        #{{ str_pad($req->id, 4, '0', STR_PAD_LEFT) }}
                                    </td>

                                    <td class="p-5">
                                        <span class="bg-sky-500/10 text-sky-300 px-3 py-1 rounded-lg text-xs font-bold border border-sky-400/20">
                                            {{ $req->num_requisicion }}
                                        </span>
                                    </td>

                                    <td class="p-5 text-slate-400">
                                        {{ \Carbon\Carbon::parse($req->fecha_requisicion)->format('d/m/Y') }}
                                    </td>

                                    <td class="p-5 font-semibold text-white">
                                        {{ $req->solicitante }}
                                    </td>

                                    <td class="p-5 text-slate-400">
                                        {{ $req->area->nombre ?? '—' }}
                                    </td>

                                    <td class="p-5 text-right font-black text-white font-mono">
                                        ${{ number_format($req->total, 2) }}
                                    </td>

      <td class="p-5 text-center">
    <div class="flex items-center justify-center gap-3 flex-wrap">

        {{-- Ver --}}
        <a href="{{ route('purchase-requests.show',$req->id) }}"
           class="px-4 py-2 bg-sky-600 hover:bg-sky-700
                  text-white rounded-xl text-xs font-bold transition-all shadow-lg">
            Ver
        </a>

        {{-- PDF --}}
        <a href="{{ route('purchase-requests.pdf',$req->id) }}"
           target="_blank"
           class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700
                  text-white rounded-xl text-xs font-bold transition-all shadow-lg">
            PDF
        </a>

        {{-- GENERAR / EDITAR OC --}}
        @if(!$req->order)

        <form action="{{ route('orders.store', $req->id) }}" method="POST">
            @csrf
            <button type="submit"
                    onclick="return confirm('¿Generar Orden de Compra?')"
                    class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700
                           text-white rounded-xl text-xs font-bold transition-all shadow-lg">
                Generar OC
            </button>
        </form>

    @else

        <span class="px-4 py-2 bg-emerald-500/20 
                     text-emerald-300 rounded-xl 
                     text-xs font-bold border border-emerald-400/30">
            OC Generada
        </span>

    @endif

        {{-- Regresar --}}
        <form action="{{ route('purchase-requests.change-status',$req->id) }}"
              method="POST">
            @csrf
            <input type="hidden" name="newStatus" value="devuelta">

            <button type="submit"
                    onclick="return confirm('¿Regresar esta requisición?')"
                    class="px-4 py-2 bg-amber-600 hover:bg-amber-700
                           text-white rounded-xl text-xs font-bold transition-all shadow-lg">
                Regresar
            </button>
        </form>

        {{-- Eliminar --}}
        <form action="{{ route('purchase-requests.destroy',$req->id) }}"
              method="POST">
            @csrf
            @method('DELETE')

            <button type="submit"
                    onclick="return confirm('⚠️ Eliminación permanente. ¿Continuar?')"
                    class="px-4 py-2 bg-red-600 hover:bg-red-700
                           text-white rounded-xl text-xs font-bold transition-all shadow-lg">
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

            @endif

        </div>

    </div>
</div>

</x-app-layout>