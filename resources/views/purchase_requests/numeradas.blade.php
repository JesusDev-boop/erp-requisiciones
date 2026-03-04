<x-app-layout>
   <x-slot name="header">
       <div class="flex items-center gap-4">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">

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
                    <h2 class="text-3xl font-black text-white tracking-tight">
                        Requisiciones Numeradas
                    </h2>
                    <p class="text-sm text-slate-300 mt-2 font-semibold">
                        Panel de aprobación final y gestión de estatus
                    </p>
                </div>
            </div>

            <div>
                <span class="bg-blue-500/20 text-blue-300 text-xs font-black px-4 py-2 rounded-xl uppercase tracking-widest border border-blue-400/30 shadow-lg">
                    {{ $requisiciones->count() }} Pendientes de Firma
                </span>
            </div>

        </div>
    </div>
</x-slot>

    <div class="py-10 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white border border-slate-200 shadow-2xl rounded-[2.5rem] overflow-hidden">
                
                @if($requisiciones->count() == 0)
                    <div class="text-center py-24">
                        <div class="bg-slate-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-800">Todo al día</h3>
                        <p class="text-slate-500 text-sm mt-1">No hay requisiciones numeradas esperando aprobación.</p>
                    </div>
                @else

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                               <tr class="bg-white/5 border-b border-white/10">
                                    <th class="p-5 text-center font-bold text-slate-700 uppercase text-[10px] tracking-[0.2em]">ID</th>
                                    <th class="p-5 text-left font-bold text-slate-700 uppercase text-[10px] tracking-[0.2em]">Folio Asignado</th>
                                    <th class="p-5 text-left font-bold text-slate-700 uppercase text-[10px] tracking-[0.2em]">Solicitante</th>
                                    <th class="p-5 text-right font-bold text-slate-700 uppercase text-[10px] tracking-[0.2em]">Monto Total</th>
                                    <th class="p-5 text-center font-bold text-slate-700 uppercase text-[10px] tracking-[0.2em]">Acciones de Control</th>
                                </tr>
                            </thead>

                             <tbody class="divide-y divide-slate-500">
                                @foreach($requisiciones as $req)
                                    <tr class="hover:bg-white/5 transition-all group">
                                        {{-- ID --}}
                                        <td class="p-5 text-center">
                                            <span class="text-xs font-bold text-slate-400">#{{ $req->id }}</span>
                                        </td>
                                        
                                        {{-- Folio Numerado --}}
                                        <td class="p-5">
                                            <span class="bg-blue-50 text-blue-700 px-3 py-1.5 rounded-lg font-black text-xs border border-blue-100 tracking-wider">
                                                {{ $req->num_requisicion }}
                                            </span>
                                        </td>

                                        {{-- Solicitante --}}
                                        <td class="p-5">
                                            <div class="flex flex-col">
                                                <span class="font-bold text-slate-800 uppercase text-xs">{{ $req->solicitante }}</span>
                                                <span class="text-[10px] text-slate-400 font-medium">Revisión pendiente</span>
                                            </div>
                                        </td>

                                        {{-- Total --}}
                                        <td class="p-5 text-right">
                                            <span class="font-black text-slate-900 text-base font-mono">
                                                ${{ number_format($req->total, 2) }}
                                            </span>
                                        </td>

                                        {{-- Botonera de Acciones --}}
                                        <td class="p-5 text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                
                                                {{-- VER (Pestaña Nueva) --}}
                                                <a href="{{ route('purchase-requests.show', $req->id) }}"
                                                   target="_blank" 
                                                   rel="noopener noreferrer"
                                                   class="p-2 text-sky-600 hover:bg-sky-50 rounded-xl transition-all shadow-sm border border-sky-100 group/btn"
                                                   title="Ver detalles">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                </a>

                                                <div class="h-6 w-px bg-slate-200 mx-1"></div>

                                                {{-- ACEPTAR --}}
                                                <form action="{{ route('purchase-requests.change-status', $req->id) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="newStatus" value="aprobada">
                                                    <button type="submit" 
                                                            onclick="return confirm('¿Confirmar aprobación de esta requisición?')"
                                                            class="flex items-center gap-1.5 bg-emerald-50 text-emerald-700 px-3 py-1.5 rounded-xl text-[11px] font-black uppercase tracking-tighter hover:bg-emerald-600 hover:text-white transition-all shadow-sm border border-emerald-100">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                                        Aceptar
                                                    </button>
                                                </form>

                                                {{-- DEVOLVER --}}
                                                <form action="{{ route('purchase-requests.change-status', $req->id) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="newStatus" value="devuelta">
                                                    <button type="submit" 
                                                            onclick="return confirm('¿Devolver a revisión?')"
                                                            class="flex items-center gap-1.5 bg-amber-50 text-amber-700 px-3 py-1.5 rounded-xl text-[11px] font-black uppercase tracking-tighter hover:bg-amber-500 hover:text-white transition-all shadow-sm border border-amber-100">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                                                        Devolver
                                                    </button>
                                                </form>

                                                {{-- RECHAZAR --}}
                                                <form action="{{ route('purchase-requests.change-status', $req->id) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="newStatus" value="rechazada">
                                                    <button type="submit" 
                                                            onclick="return confirm('¿Rechazar definitivamente?') "
                                                            class="flex items-center gap-1.5 bg-rose-50 text-rose-700 px-3 py-1.5 rounded-xl text-[11px] font-black uppercase tracking-tighter hover:bg-rose-600 hover:text-white transition-all shadow-sm border border-rose-100">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                        Rechazar
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