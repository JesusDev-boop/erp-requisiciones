<x-app-layout>
   <x-slot name="header">
      <div class="flex items-center gap-4">
        
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">

            {{-- Lado izquierdo --}}
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
                        Requisiciones Pendientes
                    </h2>

                    <p class="text-sm text-slate-300 mt-2 font-semibold">
                        Bandeja de revisión y asignación de folios para coordinación
                    </p>
                </div>
            </div>

            {{-- Badge derecho --}}
            <div>
                <span class="inline-flex items-center bg-amber-500/20 text-amber-300 text-xs font-extrabold px-4 py-2 rounded-full uppercase tracking-wider border border-amber-400/30 shadow-sm">
                    {{ $requisiciones->count() }} por revisar
                </span>
            </div>

        </div>
    </div>
</x-slot>

    <div class="py-10 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Alertas de Sistema --}}
            @if(session('success'))
                <div class="flex items-center p-4 mb-6 text-emerald-800 rounded-2xl bg-emerald-50 border border-emerald-100 shadow-sm animate-fade-in" role="alert">
                    <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <div class="ml-3 text-sm font-bold">{{ session('success') }}</div>
                </div>
            @endif

            <div class="bg-white border-2 border-slate-300 shadow-xl rounded-3xl overflow-hidden">
                
                @if($requisiciones->count() == 0)
                    {{-- Estado Vacío --}}
                    <div class="text-center py-24">
                        <div class="relative inline-block">
                            <div class="absolute inset-0 bg-slate-100 rounded-full scale-150 opacity-50"></div>
                            <svg class="relative w-20 h-20 text-slate-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="mt-6 text-xl font-bold text-slate-800">Bandeja vacía</h3>
                        <p class="text-slate-500 mt-2 max-w-xs mx-auto">No hay nuevas requisiciones esperando aprobación o numeración en este momento.</p>
                    </div>
                @else

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                          <thead class="bg-slate-100 border-b-2 border-slate-300">
                                <tr>
                                    <th class="p-5 text-center font-bold text-slate-700 uppercase text-[10px] tracking-widest">ID</th>
                                    <th class="p-5 text-left font-bold text-slate-700 uppercase text-[10px] tracking-widest">Fecha Requisición</th>
                                    <th class="p-5 text-left font-bold text-slate-700 uppercase text-[10px] tracking-widest">Solicitante</th>
                                    <th class="p-5 text-left font-bold text-slate-500 uppercase text-[10px] tracking-widest">Área / Proyecto</th>
                                    <th class="p-5 text-left font-bold text-slate-500 uppercase text-[10px] tracking-widest">Proveedor</th>
                                    <th class="p-5 text-right font-bold text-slate-500 uppercase text-[10px] tracking-widest">Total Estimado</th>
                                    <th class="p-5 text-center font-bold text-slate-500 uppercase text-[10px] tracking-widest">Gestión</th>
                                </tr>
                            </thead>

                           <tbody class="divide-y-2 divide-slate-300">
                                @foreach($requisiciones as $req)
                                    <tr class="hover:bg-slate-50/80 transition-all group">
                                        {{-- ID con formato --}}
                                        <td class="p-5 text-center">
                                            <span class="inline-block px-2 py-1 bg-slate-100 text-slate-600 rounded-md font-mono text-xs font-bold border border-slate-200">
                                                #{{ str_pad($req->id, 4, '0', STR_PAD_LEFT) }}
                                            </span>
                                        </td>
                                        
                                        {{-- Fecha --}}
                                        <td class="p-5">
                                            <div class="flex flex-col">
                                                <span class="text-slate-800 font-bold">
                                                    {{ \Carbon\Carbon::parse($req->fecha_requisicion)->format('d/m/Y') }}
                                                </span>
                                                <span class="text-[10px] text-slate-400 uppercase tracking-tighter">
                                                    {{ \Carbon\Carbon::parse($req->created_at)->diffForHumans() }}
                                                </span>
                                            </div>
                                        </td>

                                        {{-- Solicitante con iniciales --}}
                                        <td class="p-5">
                                            <div class="flex items-center">
                                                <div class="h-9 w-9 rounded-xl bg-gradient-to-br from-sky-500 to-sky-600 text-white flex items-center justify-center font-bold text-xs mr-3 shadow-sm shadow-sky-100">
                                                    {{ strtoupper(substr($req->solicitante, 0, 2)) }}
                                                </div>
                                                <span class="text-slate-700 font-semibold truncate max-w-[150px]" title="{{ $req->solicitante }}">
                                                    {{ $req->solicitante }}
                                                </span>
                                            </div>
                                        </td>

                                        {{-- Área y Proyecto --}}
                                        <td class="p-5">
                                            <div class="flex flex-col">
                                                <span class="text-slate-700 font-medium">{{ $req->area->nombre ?? 'N/A' }}</span>
                                                <span class="text-[11px] text-sky-600 font-bold uppercase tracking-tight">
                                                    {{ $req->project->nombre ?? 'Sin proyecto' }}
                                                </span>
                                            </div>
                                        </td>

                                        {{-- Proveedor --}}
                                        <td class="p-5">
                                            <span class="text-slate-600 font-medium italic">
                                                {{ $req->supplier->nombre ?? 'Sin proveedor asignado' }}
                                            </span>
                                        </td>

                                        {{-- Importe --}}
                                        <td class="p-5 text-right">
                                            <span class="text-slate-900 font-black font-mono text-base">
                                                ${{ number_format($req->total, 2) }}
                                            </span>
                                        </td>

                                        {{-- Acciones --}}
                                        <td class="p-5 text-center">
    <div class="flex items-center justify-center gap-2 flex-wrap">

    {{-- VER --}}
    <a href="{{ route('purchase-requests.show', $req->id) }}"
       target="_blank"
       class="p-2 text-slate-400 hover:text-sky-600 hover:bg-sky-50 rounded-xl transition">
        👁
    </a>

    {{-- NUMERAR --}}
    @if($req->estatus === 'en_revision')
        <form action="{{ route('purchase-requests.change-status', $req->id) }}"
              method="POST"
              class="flex items-center gap-1">
            @csrf

            <input type="text"
                   name="num_requisicion"
                   class="bg-white text-slate-900 text-xs font-bold w-24 px-2 py-1 rounded border border-slate-300"
                   placeholder="Folio..."
                   required>

            <input type="hidden" name="newStatus" value="numerada">

            <button type="submit"
                    class="bg-emerald-600 text-white px-2 py-1 rounded text-xs hover:bg-emerald-700">
                ✔
            </button>
        </form>
    @endif


    {{-- DEVOLVER (ahora también en en_revision) --}}
    @if(in_array($req->estatus, ['en_revision','numerada']))
        <form action="{{ route('purchase-requests.change-status',$req->id) }}"
              method="POST">
            @csrf
            <input type="hidden" name="newStatus" value="devuelta">

            <button type="submit"
                class="bg-amber-500 text-white px-2 py-1 rounded text-xs hover:bg-amber-600"
                onclick="return confirm('¿Devolver requisición al coordinador?')">
                Devolver
            </button>
        </form>
    @endif


    {{-- RECHAZAR --}}
    @if(in_array($req->estatus, ['en_revision','numerada']))
        <form action="{{ route('purchase-requests.change-status',$req->id) }}"
              method="POST">
            @csrf
            <input type="hidden" name="newStatus" value="rechazada">

            <button type="submit"
                class="bg-rose-600 text-white px-2 py-1 rounded text-xs hover:bg-rose-700">
                Rechazar
            </button>
        </form>
    @endif

</div>
</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    {{-- Paginación Integrada --}}
                    @if(method_exists($requisiciones, 'links'))
                        <div class="p-6 bg-slate-50 border-t border-slate-100">
                            {{ $requisiciones->links() }}
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>

    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fade-in 0.4s ease-out forwards;
        }
    </style>
</x-app-layout>