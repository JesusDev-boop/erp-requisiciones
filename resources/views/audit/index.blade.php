<x-app-layout>

<x-slot name="header">
    <div>
        <h2 class="text-3xl font-black text-white tracking-tight">
            Módulo de Auditoría
        </h2>
        <p class="text-sm text-amber-400 mt-1">
            Historial global de cambios del sistema
        </p>
    </div>
</x-slot>

<div class="py-16">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        <div class="bg-white/5 backdrop-blur-xl 
                    border border-white/10 
                    shadow-2xl rounded-[2.5rem] p-8 text-white">

                    {{-- ================= FILTROS ================= --}}
<div class="mb-10">

    <form method="GET" 
          class="grid md:grid-cols-5 gap-4 items-end">

        {{-- Número --}}
        <div>
            <label class="text-xs text-slate-400">Número</label>
            <input type="text"
                   name="numero"
                   value="{{ request('numero') }}"
                   placeholder="REQ-0001"
                   class="w-full px-4 py-2 rounded-xl 
                          bg-white/10 text-white 
                          border border-white/20
                          focus:outline-none focus:ring-2 focus:ring-amber-500">
        </div>

        {{-- Usuario Custom Dropdown --}}
<div 
    x-data="{
        open:false,
        selected:'{{ request('usuario') }}',
        label:'{{ request('usuario') ? $usuarios->firstWhere('id', request('usuario'))->name ?? 'Todos' : 'Todos' }}'
    }"
    class="relative">

    <label class="text-xs text-slate-400">Usuario</label>

    {{-- Botón --}}
    <button type="button"
            @click="open = !open"
            class="w-full px-4 py-2 rounded-xl 
                   bg-white/10 text-white 
                   border border-white/20
                   flex justify-between items-center">

        <span x-text="label"></span>

        <svg class="w-4 h-4 ml-2 text-slate-400"
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M19 9l-7 7-7-7"/>
        </svg>
    </button>

    {{-- Dropdown --}}
    <div x-show="open"
         @click.away="open = false"
         x-transition
         class="absolute z-50 mt-2 w-full bg-slate-800 
                border border-white/10 rounded-xl 
                shadow-2xl max-h-60 overflow-y-auto">

        {{-- Todos --}}
        <div @click="
                selected='';
                label='Todos';
                open=false"
             class="px-4 py-2 hover:bg-amber-500/20 cursor-pointer text-white">
            Todos
        </div>

        {{-- Usuarios --}}
        @foreach($usuarios as $user)
            <div @click="
                    selected='{{ $user->id }}';
                    label='{{ $user->name }}';
                    open=false"
                 class="px-4 py-2 hover:bg-amber-500/20 cursor-pointer text-white">
                {{ $user->name }}
            </div>
        @endforeach
    </div>

    {{-- Campo oculto --}}
    <input type="hidden" name="usuario" x-model="selected">
</div>

        {{-- Fecha inicio --}}
        <div>
            <label class="text-xs text-slate-400">Desde</label>
            <input type="date"
                   name="fecha_inicio"
                   value="{{ request('fecha_inicio') }}"
                   class="w-full px-4 py-2 rounded-xl 
                          bg-white/10 text-white 
                          border border-white/20">
        </div>

        {{-- Fecha fin --}}
        <div>
            <label class="text-xs text-slate-400">Hasta</label>
            <input type="date"
                   name="fecha_fin"
                   value="{{ request('fecha_fin') }}"
                   class="w-full px-4 py-2 rounded-xl 
                          bg-white/10 text-white 
                          border border-white/20">
        </div>

        {{-- Botones --}}
        <div class="flex gap-2">

            <button type="submit"
                    class="px-6 py-2 bg-amber-600 hover:bg-amber-700
                           text-white rounded-xl font-bold text-sm transition-all">
                Filtrar
            </button>

            <a href="{{ route('audit.index') }}"
               class="px-6 py-2 bg-slate-700 hover:bg-slate-800
                      text-white rounded-xl font-bold text-sm transition-all">
                Limpiar
            </a>

        </div>

    </form>

</div>

            @forelse($logs as $log)

                <div class="mb-4 p-4 bg-white/5 rounded-xl border border-white/10">

                    <div class="flex justify-between items-center">

                        <p>
                            <span class="font-bold text-white">
                                {{ $log->purchaseRequest->num_requisicion ?? 'Sin número' }}
                            </span>

                            cambió de

                            <span class="text-slate-300 font-semibold">
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
                        Usuario: {{ $log->user->name ?? 'Sistema' }}
                    </p>

                    @if($log->reason)
                        <p class="text-xs text-rose-400 mt-1">
                            Motivo: {{ $log->reason }}
                        </p>
                    @endif

                </div>

            @empty

                <p class="text-slate-400">
                    No hay registros de auditoría.
                </p>

            @endforelse

            <div class="mt-8">
                {{ $logs->links() }}
            </div>

        </div>

    </div>
</div>

</x-app-layout>