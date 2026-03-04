<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center gap-4">
        
               {{-- Botón Regresar al Dashboard --}}
                <a href="{{ route('suppliers.index') }}"
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
            <h2 class="text-2xl font-black text-white tracking-tight">
                Editar Proveedor
            </h2>

            <p class="text-sm text-slate-300 mt-0.5 font-semibold">
                Modificando el registro 
            </p>
        </div>

    </div>
</x-slot>

    <div class="py-10 min-h-screen">
        <div class="max-w-4xl mx-auto px-6">

            {{-- Manejo de Errores --}}
            @if ($errors->any())
                <div class="mb-8 bg-rose-50 border border-rose-100 text-rose-800 px-6 py-4 rounded-[2rem] shadow-sm animate-fade-in">
                    <div class="flex items-center mb-2">
                        <svg class="w-5 h-5 mr-2 text-rose-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                        <span class="font-bold">Por favor corrige lo siguiente:</span>
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-sm ml-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Card del Formulario --}}
            <div class="bg-white rounded-[2.5rem] ">
                <form method="POST" action="{{ route('suppliers.update', $supplier) }}" class="p-8 md:p-12 space-y-8">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        
                        {{-- Nombre --}}
                        <div class="md:col-span-2">
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em] mb-3 ml-1">
                                Razón Social / Nombre Comercial
                            </label>
                            <input type="text" name="nombre" value="{{ old('nombre', $supplier->nombre) }}" required
                                   class="w-full rounded-2xl border-slate-200 bg-slate-50/50 px-5 py-4 focus:bg-white focus:ring-4 focus:ring-sky-50 focus:border-sky-500 transition-all font-semibold text-slate-800">
                        </div>

                        {{-- RFC (AHORA EDITABLE) --}}
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em] mb-3 ml-1">
                                RFC
                            </label>
                            <input type="text" name="rfc" value="{{ old('rfc', $supplier->rfc) }}" required
                                   class="w-full rounded-2xl border-slate-200 bg-slate-50/50 px-5 py-4 focus:bg-white focus:ring-4 focus:ring-sky-50 focus:border-sky-500 transition-all font-mono text-sm font-bold text-slate-700 uppercase"
                                   placeholder="ABCD123456XYZ">
                            <p class="text-[10px] text-slate-400 mt-2 ml-1 italic">Asegúrate de que coincida con la constancia de situación fiscal.</p>
                        </div>

                        {{-- Contacto --}}
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em] mb-3 ml-1">
                                Persona de Contacto
                            </label>
                            <input type="text" name="contacto" value="{{ old('contacto', $supplier->contacto) }}" required
                                   class="w-full rounded-2xl border-slate-200 bg-slate-50/50 px-5 py-4 focus:bg-white focus:ring-4 focus:ring-sky-50 focus:border-sky-500 transition-all font-semibold text-slate-800">
                        </div>

                        {{-- Dirección --}}
                        <div class="md:col-span-2">
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em] mb-3 ml-1">
                                Domicilio Fiscal
                            </label>
                            <textarea name="direccion" rows="3" required
                                      class="w-full rounded-2xl border-slate-200 bg-slate-50/50 px-5 py-4 focus:bg-white focus:ring-4 focus:ring-sky-50 focus:border-sky-500 transition-all font-semibold text-slate-800">{{ old('direccion', $supplier->direccion) }}</textarea>
                        </div>
{{-- Estado --}}
<div class="md:col-span-2">
    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-[0.25em] mb-3 ml-1">
        Estatus del Proveedor
    </label>

    <div class="grid grid-cols-2 gap-4">

        {{-- ACTIVO --}}
        <label class="relative flex items-center p-5 border-2 rounded-2xl cursor-pointer transition-all 
            has-[:checked]:bg-emerald-100 
            has-[:checked]:border-emerald-400 
            has-[:checked]:ring-4 
            has-[:checked]:ring-emerald-200 
            border-slate-300 bg-white shadow-sm">

            <input type="radio" name="activo" value="1"
                   {{ $supplier->activo ? 'checked' : '' }}
                   class="sr-only">

            <span class="flex flex-col">
                <span class="text-base font-extrabold text-slate-900 tracking-wide">
                    ACTIVO
                </span>
                <span class="text-xs font-semibold text-slate-600 mt-1">
                    Disponible en catálogo
                </span>
            </span>
        </label>

        {{-- INACTIVO --}}
        <label class="relative flex items-center p-5 border-2 rounded-2xl cursor-pointer transition-all 
            has-[:checked]:bg-rose-100 
            has-[:checked]:border-rose-400 
            has-[:checked]:ring-4 
            has-[:checked]:ring-rose-200 
            border-slate-300 bg-white shadow-sm">

            <input type="radio" name="activo" value="0"
                   {{ !$supplier->activo ? 'checked' : '' }}
                   class="sr-only">

            <span class="flex flex-col">
                <span class="text-base font-extrabold text-slate-900 tracking-wide">
                    INACTIVO
                </span>
                <span class="text-xs font-semibold text-slate-600 mt-1">
                    Ocultar en solicitudes
                </span>
            </span>
        </label>

    </div>
</div>
                    </div>

                    {{-- Footer --}}
                    <div class="pt-10 flex flex-col md:flex-row items-center justify-between border-t border-slate-100 gap-6">
                        <a href="{{ route('suppliers.index') }}" class="text-sm font-bold text-slate-400 hover:text-slate-600 transition-colors">
                            Cancelar edición
                        </a>

                        <button type="submit" class="w-full md:w-auto bg-sky-600 hover:bg-sky-700 text-white px-10 py-4 rounded-2xl font-black shadow-xl shadow-sky-100 transition-all transform hover:-translate-y-1 active:scale-95 text-sm uppercase tracking-widest">
                            Actualizar Información
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>