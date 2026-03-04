<x-app-layout>

<x-slot name="header">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-black text-white tracking-tight">
                Órdenes de Compra
            </h2>
            <p class="text-sm text-slate-400 mt-1 font-medium">
                Administración general de órdenes generadas
            </p>
        </div>
    </div>
</x-slot>

<div class="py-12 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white/5 backdrop-blur-xl 
                    border border-white/10 
                    shadow-2xl rounded-[2.5rem] overflow-hidden">

            {{-- ================= FILTROS ================= --}}
            <div class="p-6 border-b border-white/10">

                <form method="GET" class="grid md:grid-cols-5 gap-4 items-end">

                    {{-- Número --}}
                    <div>
                        <label class="text-xs text-slate-400">Número OC</label>
                        <input type="text"
                               name="numero"
                               value="{{ request('numero') }}"
                               placeholder="Buscar OC..."
                               class="w-full px-4 py-2 rounded-xl bg-white/10 text-white border border-white/20">
                    </div>

                    {{-- Estatus --}}
                    <div>
                        <label class="text-xs text-slate-400">Estatus</label>
                        <select name="estatus"
    class="w-full px-4 py-2 rounded-xl
           bg-slate-800 text-white
           border border-slate-600
           appearance-none
           focus:outline-none focus:ring-2 focus:ring-indigo-500">

    <option value="" class="bg-slate-800 text-white">Todos</option>
    <option value="borrador" class="bg-slate-800 text-white"
        {{ request('estatus')=='borrador'?'selected':'' }}>
        Borrador
    </option>

    <option value="emitida" class="bg-slate-800 text-white"
        {{ request('estatus')=='emitida'?'selected':'' }}>
        Emitida
    </option>

    <option value="cancelada" class="bg-slate-800 text-white"
        {{ request('estatus')=='cancelada'?'selected':'' }}>
        Cancelada
    </option>

</select>
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

                    {{-- Buscar --}}
                    <div>
                        <button type="submit"
                                class="w-full px-4 py-2 bg-indigo-600 hover:bg-indigo-700
                                       text-white rounded-xl text-xs font-bold transition-all shadow-lg">
                            Filtrar
                        </button>
                    </div>

                </form>

            </div>

            {{-- ================= TABLA ================= --}}
            @if($orders->isEmpty())

                <div class="text-center py-24">
                    <h3 class="text-xl font-bold text-white">
                        No hay órdenes registradas
                    </h3>
                    <p class="text-slate-400 mt-2">
                        Cuando se generen órdenes aparecerán aquí.
                    </p>
                </div>

            @else

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-slate-300">

                        <thead class="bg-white/5 border-b border-white/10 uppercase text-[11px] tracking-widest">
                            <tr>
                                <th class="p-5 text-left">OC</th>
                                <th class="p-5 text-left">Proveedor</th>
                                <th class="p-5 text-left">Área</th>
                                <th class="p-5 text-left">Proyecto</th>
                                <th class="p-5 text-right">Total</th>
                                <th class="p-5 text-center">Estatus</th>
                                <th class="p-5 text-center">Acciones</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-white/5">
                            @foreach($orders as $order)
                                <tr class="hover:bg-white/5 transition-all">

                                <td class="p-5">
    <div class="font-semibold text-indigo-400 text-sm">
        {{ $order->purchaseRequest?->num_requisicion }}
    </div>

          @if($order->numero_oc)

    <div class="text-xs text-slate-400 mt-1">
        OC: {{ $order->numero_oc }}
    </div>

@elseif($order->estatus == 'borrador')

    <form method="POST" action="{{ route('orders.updateNumero',$order->id) }}" class="mt-2 flex gap-2">
        @csrf
        @method('PUT')

        <input type="text"
               name="numero_oc"
               placeholder="Asignar OC..."
               class="px-2 py-1 text-xs rounded-lg bg-white/10 text-white border border-white/20 w-28">

        <button class="px-2 py-1 text-xs bg-indigo-600 hover:bg-indigo-700 rounded-lg text-white">
            ✔
        </button>
    </form>

@else

    <div class="text-xs text-slate-500 mt-1 italic">
        Sin número OC
    </div>

@endif
</td>

                                    <td class="p-5 text-white font-semibold">
                                        {{ $order->proveedor_nombre }}
                                    </td>

                                    <td class="p-5">
                                        {{ $order->area }}
                                    </td>

                                    <td class="p-5">
                                        {{ $order->proyecto }}
                                    </td>

                                    <td class="p-5 text-right font-black text-emerald-400">
                                        ${{ number_format($order->total,2) }}
                                    </td>

                                    <td class="p-5 text-center">
                                        <span class="px-3 py-1 rounded-full text-xs font-bold
                                            @if($order->estatus=='borrador') bg-yellow-500/20 text-yellow-300
                                            @elseif($order->estatus=='emitida') bg-emerald-500/20 text-emerald-300
                                            @elseif($order->estatus=='cancelada') bg-rose-500/20 text-rose-300
                                            @endif">
                                            {{ strtoupper($order->estatus) }}
                                        </span>
                                    </td>

                                    <td class="p-5 text-center">
                                        <div class="flex items-center justify-center gap-3">

                                            {{-- PDF --}}
                                            <a href="{{ route('orders.pdf',$order->id) }}"
                                               target="_blank"
                                               class="px-3 py-2 bg-emerald-600 hover:bg-emerald-700
                                                      text-white rounded-xl text-xs font-bold transition-all">
                                                PDF
                                            </a>

                                            {{-- Editar solo si borrador --}}
                                            @if($order->estatus == 'borrador')
                                                <a href="{{ route('orders.edit',$order->id) }}"
                                                   class="px-3 py-2 bg-purple-600 hover:bg-purple-700
                                                          text-white rounded-xl text-xs font-bold transition-all">
                                                    Editar
                                                </a>
                                            @endif

                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

                {{-- PAGINACIÓN --}}
                <div class="p-6 border-t border-white/10">
                    {{ $orders->withQueryString()->links() }}
                </div>

            @endif

        </div>

    </div>
</div>

</x-app-layout>