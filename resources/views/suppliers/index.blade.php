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
                {{-- Título --}}
                <div>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight">
                        Gestión de Proveedores
                    </h2>

                    <p class="text-sm text-slate-300 mt-2 font-semibold max-w-xl">
                        Directorio centralizado de socios comerciales y entidades fiscales.
                    </p>
                </div>
            </div>

            {{-- Botón Nuevo --}}
            <a href="{{ route('suppliers.create') }}"
               class="inline-flex items-center justify-center gap-2 
                      bg-white/10 hover:bg-white/20 
                      text-white 
                      px-6 py-3 rounded-2xl 
                      font-bold 
                      border border-white/20
                      backdrop-blur-md
                      shadow-lg 
                      transition-all 
                      transform hover:-translate-y-1 active:scale-95 text-sm">

                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                          d="M12 4v16m8-8H4"></path>
                </svg>

                Registrar Proveedor
            </a>

        </div>
    </div>
</x-slot>

<div class="py-10 min-h-screen">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-8 flex items-center p-4 bg-emerald-50 border border-emerald-200 text-emerald-900 rounded-2xl shadow-sm">
                    <div class="bg-emerald-600 text-white p-1 rounded-full mr-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-bold">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white rounded-[2rem] shadow-xl border border-slate-300 overflow-hidden">

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm border-separate border-spacing-0 text-black">
                        <thead>
                            <tr class="bg-slate-100">
                                <th class="px-8 py-5 text-left font-extrabold text-black uppercase text-[11px] tracking-widest border-b border-slate-300">
                                    Razón Social
                                </th>
                                <th class="px-8 py-5 text-left font-extrabold text-black uppercase text-[11px] tracking-widest border-b border-slate-300">
                                    Identificación Fiscal
                                </th>
                                <th class="px-8 py-5 text-left font-extrabold text-black uppercase text-[11px] tracking-widest border-b border-slate-300">
                                    Información de Contacto
                                </th>
                                <th class="px-8 py-5 text-center font-extrabold text-black uppercase text-[11px] tracking-widest border-b border-slate-300">
                                    Estado
                                </th>
                                <th class="px-8 py-5 text-right font-extrabold text-black uppercase text-[11px] tracking-widest border-b border-slate-300">
                                    Operaciones
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-200">
                            @forelse($suppliers as $supplier)
                                <tr class="hover:bg-slate-50 transition-colors">

                                    <td class="px-8 py-6">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 rounded-xl bg-slate-200 text-black flex items-center justify-center mr-4">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                                    </path>
                                                </svg>
                                            </div>
                                            <span class="font-black text-black text-base tracking-tight">
                                                {{ $supplier->nombre }}
                                            </span>
                                        </div>
                                    </td>

                                    <td class="px-8 py-6">
                                        <span class="font-mono bg-slate-200 text-black px-3 py-1 rounded-lg text-xs font-bold border border-slate-300 uppercase">
                                            {{ $supplier->rfc }}
                                        </span>
                                    </td>

                                    <td class="px-8 py-6">
                                        <div class="flex flex-col">
                                            <span class="text-black font-bold uppercase text-[12px] tracking-tight">
                                                {{ $supplier->contacto }}
                                            </span>
                                            <span class="text-slate-600 text-xs mt-0.5">
                                                Representante Legal
                                            </span>
                                        </div>
                                    </td>

                                    <td class="px-8 py-6 text-center">
                                        @if($supplier->activo)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-black uppercase tracking-widest bg-emerald-100 text-emerald-700 border border-emerald-300">
                                                Activo
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-black uppercase tracking-widest bg-slate-200 text-slate-700 border border-slate-300">
                                                Inactivo
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-8 py-6 text-right">
                                        <div class="flex items-center justify-end space-x-2">
                                            <a href="{{ route('suppliers.edit', $supplier) }}"
                                               class="p-2.5 text-black hover:text-sky-700 hover:bg-sky-100 rounded-xl transition-all">
                                                ✏
                                            </a>

                                            <form action="{{ route('suppliers.destroy', $supplier) }}"
                                                  method="POST"
                                                  class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        onclick="return confirm('¿Seguro que deseas desactivar este proveedor?')"
                                                        class="p-2.5 text-black hover:text-rose-700 hover:bg-rose-100 rounded-xl transition-all">
                                                    ✖
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-8 py-20 text-center">
                                        <h3 class="text-black font-bold text-lg">
                                            Directorio vacío
                                        </h3>
                                        <p class="text-slate-600 text-sm mt-1">
                                            No se encontraron proveedores registrados en el sistema.
                                        </p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if(method_exists($suppliers, 'links'))
                    <div class="bg-slate-100 p-6 border-t border-slate-300">
                        {{ $suppliers->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>