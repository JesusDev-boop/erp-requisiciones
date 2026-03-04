<x-app-layout>

<x-slot name="header">
    <div class="flex items-center gap-4">

        {{-- Botón Regresar --}}
        <a href="{{ route('users.index') }}"
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
                Crear Usuario
            </h2>
            <p class="text-sm text-slate-300 mt-1 font-semibold">
                Registro de nueva cuenta dentro del sistema
            </p>
        </div>

    </div>
</x-slot>

<div class="py-12 min-h-screen">
<div class="max-w-4xl mx-auto">

<form method="POST" action="{{ route('users.store') }}"
      class="bg-white/95 backdrop-blur-xl shadow-2xl 
             rounded-[2.5rem] border border-slate-200 
             p-10 space-y-8">

@csrf

{{-- Nombre --}}
<div>
    <label class="label">Nombre Completo</label>
    <input type="text" 
           name="name"
           class="input" required>
</div>

{{-- Email --}}
<div>
    <label class="label">Correo Electrónico</label>
    <input type="email" 
           name="email"
           class="input" required>
</div>

{{-- Password --}}
<div>
    <label class="label">Contraseña</label>
    <input type="password" 
           name="password"
           class="input" required>
</div>

{{-- Rol --}}
<div>
    <label class="label">Rol del Sistema</label>
    <select name="role" id="role"
        class="input select-custom">
        <option value="coordinador">Coordinador</option>
        <option value="compras">Compras</option>
        <option value="administrador">Administrador</option>
    </select>
</div>

{{-- Área --}}
<div id="area-container">
    <label class="label">Área Asignada</label>
    <select name="area_id" id="area_id"
            class="input select-custom">
        @foreach($areas as $area)
            <option value="{{ $area->id }}">
                {{ $area->nombre }}
            </option>
        @endforeach
    </select>
</div>

{{-- Botón --}}
<div class="flex justify-end pt-4">
    <button type="submit"
        class="bg-slate-900 hover:bg-slate-800 
               text-white px-10 py-4 rounded-2xl 
               font-bold shadow-2xl transition-all 
               transform hover:-translate-y-1 
               active:scale-95 flex items-center gap-2">

        Crear Usuario

        <svg class="w-5 h-5 opacity-60"
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M13 7l5 5m0 0l-5 5m5-5H6"/>
        </svg>
    </button>
</div>

</form>

</div>
</div>

<style>
.label {
    display: block;
    font-size: 11px;
    font-weight: 800;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 8px;
    padding-left: 4px;
}

.input {
    width: 100%;
    border: 1.5px solid #e2e8f0;
    padding: 12px 16px;
    border-radius: 16px;
    transition: all 0.2s;
    font-size: 14px;
    color: #000 !important;
    background: #ffffff !important;
}

.input:focus {
    outline: none;
    border-color: #0ea5e9;
    box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1);
}

.select-custom {
    appearance: none;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const roleSelect = document.getElementById('role');
    const areaContainer = document.getElementById('area-container');
    const areaSelect = document.getElementById('area_id');

    function toggleArea() {
        if (roleSelect.value === 'compras') {
            areaContainer.style.display = 'none';
            areaSelect.disabled = true;
        } else {
            areaContainer.style.display = 'block';
            areaSelect.disabled = false;
        }
    }

    toggleArea();
    roleSelect.addEventListener('change', toggleArea);
});
</script>

</x-app-layout>