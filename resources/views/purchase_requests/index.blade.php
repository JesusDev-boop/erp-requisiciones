<x-app-layout>
    <x-slot name="header">
   <div class="flex items-center gap-4">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">

            {{-- Lado Izquierdo --}}
            <div class="flex items-center gap-4">

              {{-- Botón Regresar al Dashboard --}}
                <a href="{{ route('dashboard') }}"
                   class="p-3 bg-white/5 border border-white/10 rounded-2xl text-white hover:bg-white/10 hover:border-white/20 transition-all shadow-lg backdrop-blur-md group">
                    
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
                    <h2 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight">
                        Requisiciones
                    </h2>

                    <p class="text-sm text-slate-300 mt-2 font-semibold">
                        Historial completo y seguimiento de órdenes
                    </p>
                </div>
            </div>

            {{-- Botón Nueva --}}
            <a href="{{ route('purchase-requests.create') }}"
               class="inline-flex items-center justify-center gap-2 bg-white text-black hover:bg-slate-200 px-6 py-3 rounded-2xl font-bold shadow-lg transition-all transform hover:-translate-y-1 active:scale-95 text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                          d="M12 4v16m8-8H4"></path>
                </svg>
                Nueva Requisición
            </a>

        </div>
    </div>
</x-slot>

    <div class="py-10 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

           <div class="bg-white border-2 border-slate-300 shadow-xl rounded-3xl overflow-hidden">
                
                {{-- Cabecera interna de la tabla --}}
                <div class="p-8 border-b border-slate-300 flex flex-col md:flex-row md:items-center justify-between gap-4 bg-slate-50/30">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Listado General</h3>
                        <p class="text-xs text-slate-500 uppercase tracking-widest font-semibold mt-1">Filtros y Control</p>
                    </div>
                    
                    {{-- Espacio para posibles filtros en el futuro --}}
                    <div class="flex items-center text-slate-400 text-sm">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                            Mostrando {{ $purchaseRequests->count() }} registros
                        </span>
                    </div>
                </div>

                @if($purchaseRequests->count() == 0)
                    {{-- Estado Vacío --}}
                    <div class="text-center py-24">
                        <div class="h-24 w-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-12 h-12 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800">No hay requisiciones</h3>
                        <p class="text-slate-500 mt-2">Parece que aún no has creado ninguna solicitud.</p>
                    </div>
                @else

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-slate-100 text-slate-700 border-b-2 border-slate-300">
                                <tr>
                                    <th class="p-5 text-center font-bold uppercase text-[10px] tracking-widest">ID</th>
                                    <th class="p-5 text-left font-bold uppercase text-[10px] tracking-widest">Solicitante / Fecha</th>
                                    <th class="p-5 text-left font-bold uppercase text-[10px] tracking-widest">Estatus de Proceso</th>
                                    <th class="p-5 text-right font-bold uppercase text-[10px] tracking-widest">Total</th>
                                    <th class="p-5 text-center font-bold uppercase text-[10px] tracking-widest">Acciones</th>
                                </tr>
                            </thead>

                           <tbody class="divide-y-2 divide-slate-300">
                                @foreach($purchaseRequests as $req)
                                   @php
    $statusStyles = match($req->estatus) {
        'borrador'    => 'bg-slate-100 text-slate-600 border-slate-200',
        'en_revision' => 'bg-amber-50 text-amber-700 border-amber-100',
        'numerada'    => 'bg-blue-50 text-blue-700 border-blue-100',
        'aprobada'    => 'bg-emerald-50 text-emerald-700 border-emerald-100',
        'rechazada'   => 'bg-rose-50 text-rose-700 border-rose-100',
        'cancelada'   => 'bg-gray-200 text-gray-700 border-gray-300 line-through',
        default       => 'bg-slate-50 text-slate-500 border-slate-100',
    };
@endphp
                                    <tr class="hover:bg-slate-50/80 transition-all group">
                                        {{-- ID --}}
                                        <td class="p-5 text-center">
                                            <span class="font-mono text-xs font-bold text-slate-400">
                                                #{{ str_pad($req->id, 4, '0', STR_PAD_LEFT) }}
                                            </span>
                                        </td>

                                        {{-- Solicitante --}}
                                        <td class="p-5">
                                            <div class="flex flex-col">
                                                <span class="text-slate-800 font-bold group-hover:text-sky-600 transition-colors">
                                                    {{ $req->solicitante }}
                                                </span>
                                                <span class="text-[10px] text-slate-400 font-medium">
                                                    {{ \Carbon\Carbon::parse($req->fecha_requisicion)->format('d/m/Y') }}
                                                </span>
                                            </div>
                                        </td>

                                        {{-- Estatus --}}
                                        <td class="p-5">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border {{ $statusStyles }}">
                                                <span class="w-1.5 h-1.5 rounded-full bg-current mr-2 opacity-50"></span>
                                                {{ $req->estatus }}
                                            </span>
                                        </td>

                                        {{-- Total --}}
                                        <td class="p-5 text-right">
                                            <span class="text-slate-900 font-black font-mono text-base">
                                                ${{ number_format($req->total, 2) }}
                                            </span>
                                        </td>

                                        {{-- Botón Ver --}}
                                        <td class="p-5 text-center">
                                            <a href="{{ route('purchase-requests.show', $req->id) }}"
                                               target="_blank" 
                                               rel="noopener noreferrer"
                                               class="inline-flex items-center px-4 py-2 bg-white border border-slate-200 text-slate-600 rounded-xl text-xs font-bold shadow-sm hover:bg-slate-900 hover:text-white hover:border-slate-900 transition-all group/btn">
                                                <svg class="w-4 h-4 mr-2 text-slate-400 group-hover/btn:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                Ver Detalles
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Paginación --}}
                    @if(method_exists($purchaseRequests, 'links'))
                        <div class="p-6 bg-slate-50/50 border-t border-slate-100">
                            {{ $purchaseRequests->links() }}
                        </div>
                    @endif

                @endif
            </div>
        </div>
    </div>
</x-app-layout>