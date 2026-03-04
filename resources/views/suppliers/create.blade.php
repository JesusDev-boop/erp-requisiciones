<x-app-layout>
    <x-slot name="header">
      <div class="flex items-center gap-4">
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
                <h2 class="text-3xl font-black text-white tracking-tight">
                    Nuevo Proveedor
                </h2>

                <p class="text-sm text-slate-300 mt-1 font-semibold">
                    Registra una nueva entidad comercial en el sistema de adquisiciones.
                </p>
            </div>

        </div>
    </div>
</x-slot>

<div class="py-10 min-h-screen">
        <div class="max-w-4xl mx-auto px-6">

            {{-- Errores de Validación --}}
            @if ($errors->any())
                <div class="mb-8 bg-rose-50 border border-rose-100 text-rose-800 px-6 py-4 rounded-[2rem] shadow-sm animate-fade-in">
                    <div class="flex items-center mb-2">
                        <svg class="w-5 h-5 mr-2 text-rose-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                        <span class="font-bold">Revisa los siguientes campos:</span>
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-sm ml-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Card del Formulario --}}
            <div class="bg-white rounded-[2.5rem]">
                <form method="POST" action="{{ route('suppliers.store') }}" class="p-8 md:p-12 space-y-8">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        
                        {{-- Selección de Área --}}
                        <div class="md:col-span-2">
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em] mb-3 ml-1">
                                Área Asignada
                            </label>
                            <div class="relative">
                                <select name="area_id" required
                                        class="w-full appearance-none rounded-2xl border-slate-200 bg-slate-50/50 px-5 py-4 focus:bg-white focus:ring-4 focus:ring-sky-50 focus:border-sky-500 transition-all font-semibold text-slate-800 cursor-pointer">
                                    <option value="" disabled selected>Selecciona el departamento responsable...</option>
                                    @foreach(\App\Models\Area::all() as $area)
                                        <option value="{{ $area->id }}" {{ old('area_id') == $area->id ? 'selected' : '' }}>
                                            {{ $area->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>

                        {{-- Nombre --}}
                        <div class="md:col-span-2">
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em] mb-3 ml-1">
                                Razón Social / Nombre
                            </label>
                            <input type="text" name="nombre" value="{{ old('nombre') }}" required
                                   placeholder="Ej. Comercializadora de Insumos S.A. de C.V."
                                   class="w-full rounded-2xl border-slate-200 bg-slate-50/50 px-5 py-4 focus:bg-white focus:ring-4 focus:ring-sky-50 focus:border-sky-500 transition-all font-semibold text-slate-800">
                        </div>

                        {{-- RFC --}}
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em] mb-3 ml-1">
                                RFC
                            </label>
                            <input type="text" name="rfc" value="{{ old('rfc') }}" required
                                   oninput="this.value = this.value.toUpperCase()"
                                   placeholder="XAXX010101000"
                                   class="w-full rounded-2xl border-slate-200 bg-slate-50/50 px-5 py-4 focus:bg-white focus:ring-4 focus:ring-sky-50 focus:border-sky-500 transition-all font-mono text-sm font-bold text-slate-700 uppercase">
                        </div>

                        {{-- Contacto --}}
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em] mb-3 ml-1">
                                Persona de Contacto
                            </label>
                            <input type="text" name="contacto" value="{{ old('contacto') }}" required
                                   placeholder="Nombre del representante"
                                   class="w-full rounded-2xl border-slate-200 bg-slate-50/50 px-5 py-4 focus:bg-white focus:ring-4 focus:ring-sky-50 focus:border-sky-500 transition-all font-semibold text-slate-800">
                        </div>

                        {{-- Dirección --}}
                        <div class="md:col-span-2">
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em] mb-3 ml-1">
                                Domicilio Fiscal
                            </label>
                            <textarea name="direccion" rows="3" required
                                      placeholder="Calle, número, colonia, CP y Ciudad..."
                                      class="w-full rounded-2xl border-slate-200 bg-slate-50/50 px-5 py-4 focus:bg-white focus:ring-4 focus:ring-sky-50 focus:border-sky-500 transition-all font-semibold text-slate-800">{{ old('direccion') }}</textarea>
                        </div>
                    </div>

                    {{-- Footer de Acción --}}
                    <div class="pt-10 flex flex-col md:flex-row items-center justify-between border-t border-slate-100 gap-6">
                        <a href="{{ route('suppliers.index') }}" class="text-sm font-bold text-slate-400 hover:text-slate-600 transition-colors">
                            Cancelar y volver al listado
                        </a>

                        <button type="submit" class="w-full md:w-auto bg-slate-900 hover:bg-black text-white px-10 py-4 rounded-2xl font-black shadow-xl shadow-slate-200 transition-all transform hover:-translate-y-1 active:scale-95 text-sm uppercase tracking-widest flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            Registrar Proveedor
                        </button>
                    </div>
                </form>
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