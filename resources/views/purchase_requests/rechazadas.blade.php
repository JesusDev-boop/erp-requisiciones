<x-app-layout>

<x-slot name="header">
    <div class="flex items-center gap-4">

        {{-- Botón regresar --}}
        <a href="{{ route('dashboard') }}"
           class="p-3 bg-white/5 border border-white/10 rounded-2xl 
                  text-white hover:bg-white/10 hover:border-white/20 
                  transition-all shadow-lg backdrop-blur-md group">
            <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2.5"
                      d="M15 19l-7-7 7-7" />
            </svg>
        </a>

        <div>
            <h2 class="text-3xl font-black text-white tracking-tight">
                Requisiciones Rechazadas
            </h2>
            <p class="text-sm text-rose-400 mt-1 font-semibold">
                Solicitudes descartadas del flujo operativo
            </p>
        </div>

    </div>
</x-slot>


<div class="py-12 min-h-screen">
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

    <div class="bg-white/95 backdrop-blur-xl shadow-2xl 
                rounded-[2.5rem] p-10 border border-slate-200">

        {{-- Mensaje éxito --}}
        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl 
                        bg-emerald-50 border border-emerald-200 
                        text-emerald-700 font-semibold text-sm">
                {{ session('success') }}
            </div>
        @endif


        @if($requisiciones->isEmpty())

            <div class="text-center py-20">
                <div class="bg-rose-50 w-16 h-16 rounded-full 
                            flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-rose-400"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>

                <h3 class="text-lg font-bold text-slate-800">
                    No hay requisiciones rechazadas
                </h3>
                <p class="text-slate-500 text-sm mt-1">
                    Todo está en orden actualmente.
                </p>
            </div>

        @else

        <div class="overflow-x-auto rounded-2xl border border-slate-200">

            <table class="w-full text-sm">

                <thead class="bg-slate-900 text-white uppercase text-[10px] tracking-widest">
                    <tr>
                        <th class="p-5 text-center">#</th>
                        <th class="p-5 text-left">Número</th>
                        <th class="p-5 text-left">Solicitante</th>
                        <th class="p-5 text-left">Área</th>
                        <th class="p-5 text-right">Total</th>
                        <th class="p-5 text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-200">

                    @foreach($requisiciones as $req)

                    <tr class="hover:bg-slate-50 transition">

                        <td class="p-5 text-center font-mono text-slate-400">
                            #{{ $req->id }}
                        </td>

                        <td class="p-5 font-bold text-slate-800">
                            {{ $req->num_requisicion }}
                        </td>

                        <td class="p-5 text-slate-700">
                            {{ $req->solicitante }}
                        </td>

                        <td class="p-5 text-slate-500">
                            {{ $req->area->nombre ?? '' }}
                        </td>

                        <td class="p-5 text-right font-black font-mono text-slate-900">
                            ${{ number_format($req->total,2) }}
                        </td>

                        <td class="p-5 text-center">

                            <div class="flex items-center justify-center gap-2">

                                {{-- VER --}}
                                <a href="{{ route('purchase-requests.show',$req->id) }}"
                                   class="bg-sky-600 hover:bg-sky-700 
                                          text-white px-4 py-2 rounded-xl 
                                          text-xs font-black uppercase 
                                          tracking-wider shadow-sm transition">
                                    Ver
                                </a>

                                {{-- BORRAR --}}
                                <form action="{{ route('purchase-requests.destroy',$req->id) }}"
                                      method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        onclick="return confirm('¿Eliminar definitivamente esta requisición? Esta acción no se puede deshacer.')"
                                        class="bg-rose-600 hover:bg-rose-700 
                                               text-white px-4 py-2 rounded-xl 
                                               text-xs font-black uppercase 
                                               tracking-wider shadow-sm transition">
                                        Borrar
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