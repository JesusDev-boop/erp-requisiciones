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

        {{-- Título --}}
        <div>
            <h2 class="text-3xl font-black text-white tracking-tight">
                Requisiciones Devueltas
            </h2>

            <p class="text-sm text-amber-400 mt-1 font-semibold">
                Solicitudes que requieren correcciones antes de continuar
            </p>
        </div>

    </div>
</x-slot>

<div class="py-16">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        <div class="bg-white/5 backdrop-blur-xl 
                    border border-white/10 
                    shadow-2xl rounded-[2.5rem] overflow-hidden">

            @if($requisiciones->isEmpty())

                <div class="text-center py-24">
                    <div class="h-20 w-20 mx-auto mb-6 
                                bg-amber-500/10 rounded-full 
                                flex items-center justify-center">
                        <svg class="w-10 h-10 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M12 9v4m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 
                                  1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 
                                  0L3.34 16c-.77 1.33.19 3 1.73 3z"/>
                        </svg>
                    </div>

                    <h3 class="text-xl font-bold text-white">
                        No tienes requisiciones devueltas
                    </h3>
                    <p class="text-slate-400 mt-2">
                        Excelente trabajo. No hay solicitudes pendientes de corrección.
                    </p>
                </div>

            @else

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-slate-300">

                        <thead class="bg-white/5 border-b border-white/10 uppercase text-[11px] tracking-widest">
                            <tr>
                                <th class="p-5 text-left">ID</th>
                                <th class="p-5 text-left">Número</th>
                                <th class="p-5 text-left">Solicitante</th>
                                <th class="p-5 text-right">Total</th>
                                <th class="p-5 text-center">Acciones</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-white/5">
                            @foreach($requisiciones as $req)
                                <tr class="hover:bg-white/5 transition-all duration-200">

                                    {{-- ID --}}
                                    <td class="p-5 font-mono text-slate-400">
                                        #{{ str_pad($req->id, 4, '0', STR_PAD_LEFT) }}
                                    </td>

                                    {{-- Número --}}
                                    <td class="p-5">
                                        <span class="bg-amber-500/10 text-amber-300 px-3 py-1 rounded-lg text-xs font-bold border border-amber-400/20">
                                            {{ $req->num_requisicion ?? 'Sin folio' }}
                                        </span>
                                    </td>

                                    {{-- Solicitante --}}
                                    <td class="p-5 font-semibold text-white">
                                        {{ $req->solicitante }}
                                    </td>

                                    {{-- Total --}}
                                    <td class="p-5 text-right font-black text-white font-mono">
                                        ${{ number_format($req->total, 2) }}
                                    </td>

                                   {{-- Acciones --}}
<td class="p-5 text-center">
    <div class="flex items-center justify-center gap-3">

        {{-- Editar --}}
        <a href="{{ route('purchase-requests.edit',$req->id) }}"
           class="px-4 py-2 
                  bg-sky-600 hover:bg-sky-700 
                  text-white rounded-xl 
                  text-xs font-bold 
                  transition-all shadow-lg">
            Editar
        </a>

        {{-- Reenviar --}}
        <form action="{{ route('purchase-requests.change-status',$req->id) }}"
              method="POST">
            @csrf
            <input type="hidden" name="newStatus" value="en_revision">

            <button type="submit"
                    onclick="return confirm('¿Reenviar a revisión?')"
                    class="px-4 py-2 
                           bg-emerald-600 hover:bg-emerald-700 
                           text-white rounded-xl 
                           text-xs font-bold 
                           transition-all shadow-lg">
                Reenviar
            </button>
        </form>

    {{-- Cancelar --}}
<form action="{{ route('purchase-requests.change-status',$req->id) }}" method="POST">
    @csrf
    <input type="hidden" name="newStatus" value="cancelada">
    <button type="submit"
        onclick="return confirm('¿Seguro que deseas cancelar definitivamente esta requisición?')"
        class="bg-red-600 hover:bg-red-700 text-white px-4 py-1 rounded-lg text-xs font-bold">
        Cancelar
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