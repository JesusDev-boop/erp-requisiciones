<x-app-layout>

<x-slot name="header">
    <div class="flex items-center gap-4">

        {{-- Botón Regresar --}}
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
                Administración de Usuarios
            </h2>
            <p class="text-sm text-slate-300 mt-1 font-semibold">
                Gestión de accesos y permisos del sistema
            </p>
        </div>

    </div>
</x-slot>

<div class="py-12 min-h-screen">
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

    {{-- Mensaje éxito --}}
    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl 
                    bg-emerald-50 border border-emerald-200 
                    text-emerald-700 font-semibold text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Botón Nuevo Usuario --}}
    <div class="flex justify-between items-center mb-8">

        <div>
            <h3 class="text-xl font-bold text-slate-800">
                Lista de Usuarios
            </h3>
            <p class="text-sm text-slate-500">
                Control total sobre cuentas registradas
            </p>
        </div>

        <a href="{{ route('users.create') }}"
           class="bg-slate-900 hover:bg-slate-800 text-white 
                  px-6 py-3 rounded-2xl font-bold shadow-xl 
                  transition-all transform hover:-translate-y-1 
                  active:scale-95 flex items-center gap-2">

            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M12 4v16m8-8H4" />
            </svg>

            Nuevo Usuario
        </a>

    </div>

    {{-- Tabla --}}
    <div class="bg-white/95 backdrop-blur-xl shadow-2xl 
                rounded-[2.5rem] border border-slate-200 overflow-hidden">

        <table class="w-full text-sm">

            <thead class="bg-slate-900 text-white uppercase text-[10px] tracking-widest">
                <tr>
                    <th class="p-5 text-left">Nombre</th>
                    <th class="p-5 text-left">Email</th>
                    <th class="p-5 text-left">Rol</th>
                    <th class="p-5 text-left">Área</th>
                    <th class="p-5 text-center">Acciones</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-200">

                @foreach($users as $user)

                <tr class="hover:bg-slate-50 transition">

                    {{-- Nombre --}}
                    <td class="p-5 font-semibold text-slate-800">
                        {{ $user->name }}
                    </td>

                    {{-- Email --}}
                    <td class="p-5 text-slate-600">
                        {{ $user->email }}
                    </td>

                    {{-- Rol --}}
                    <td class="p-5">
                        @if($user->role === 'administrador')
                            <span class="px-3 py-1 rounded-full text-xs font-black uppercase bg-purple-100 text-purple-700">
                                Administrador
                            </span>
                        @elseif($user->role === 'compras')
                            <span class="px-3 py-1 rounded-full text-xs font-black uppercase bg-emerald-100 text-emerald-700">
                                Compras
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-full text-xs font-black uppercase bg-sky-100 text-sky-700">
                                Coordinador
                            </span>
                        @endif
                    </td>

                    {{-- Área --}}
                    <td class="p-5 text-slate-500">
                        {{ $user->area->nombre ?? '-' }}
                    </td>

                    {{-- Acciones --}}
                    <td class="p-5 text-center">

                        <div class="flex items-center justify-center gap-3">

                            {{-- Editar --}}
                            <a href="{{ route('users.edit',$user) }}"
                               class="bg-sky-600 hover:bg-sky-700 
                                      text-white px-4 py-2 rounded-xl 
                                      text-xs font-black uppercase 
                                      tracking-wider shadow-sm transition">
                                Editar
                            </a>

                            {{-- Eliminar --}}
                            <form action="{{ route('users.destroy',$user) }}"
                                  method="POST">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    onclick="return confirm('¿Eliminar usuario definitivamente?')"
                                    class="bg-rose-600 hover:bg-rose-700 
                                           text-white px-4 py-2 rounded-xl 
                                           text-xs font-black uppercase 
                                           tracking-wider shadow-sm transition">
                                    Eliminar
                                </button>
                            </form>

                        </div>

                    </td>

                </tr>

                @endforeach

            </tbody>
        </table>

    </div>

</div>
</div>

</x-app-layout>