<nav class="fixed top-0 left-0 w-full z-50 
            bg-gradient-to-r from-[#0f172a] via-[#0b1f35] to-[#0f2a3f] 
            border-b border-white/10 backdrop-blur-2xl shadow-2xl">

    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        {{-- ================= BARRA SUPERIOR ================= --}}
        <div class="flex items-center justify-between h-16">

            {{-- IZQUIERDA --}}
            <div class="flex items-center gap-10">

                <a href="{{ route('dashboard') }}" 
                   class="flex items-center gap-3 group">

                    <img src="{{ asset('images/logo.png') }}" 
                         alt="Logo Empresa" 
                         class="h-9 w-auto object-contain drop-shadow-lg 
                                transition-transform duration-300 
                                group-hover:scale-105">

                    <div class="flex flex-col leading-tight">
                        <span class="text-sky-400 font-bold text-sm tracking-wide">
             Sistema de Requisiciones
                        </span>
                        <span class="text-slate-300 text-xs tracking-wide">
                         Y Ordenes De Compra
                        </span>
                    </div>
                </a>

            </div>

            {{-- DERECHA --}}
            <div class="flex items-center gap-6">

                {{-- Usuario --}}
                <div x-data="{ open: false }" class="relative">

                    <button @click="open = !open"
                        class="flex items-center gap-3 
                               bg-white/5 hover:bg-white/10 
                               border border-white/10 
                               px-3 py-2 rounded-2xl 
                               transition-all duration-300 
                               shadow-md hover:shadow-lg">

                        <div class="h-8 w-8 rounded-full 
                                    bg-gradient-to-br from-sky-500 to-blue-600 
                                    flex items-center justify-center 
                                    text-white text-xs font-bold shadow-md">
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </div>

                        <span class="text-white text-sm font-semibold">
                            {{ auth()->user()->name }}
                        </span>

                        <svg class="w-4 h-4 text-slate-400 transition-transform duration-300"
                             :class="{'rotate-180': open}"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    {{-- Dropdown --}}
                    <div x-show="open"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-2"
                         @click.away="open = false"
                         class="absolute right-0 mt-3 w-52 
                                bg-slate-900 border border-white/10 
                                rounded-2xl shadow-2xl overflow-hidden">

                        <div class="px-4 py-3 border-b border-white/5">
                            <p class="text-xs text-slate-400 uppercase tracking-widest">
                                Cuenta
                            </p>
                            <p class="text-sm text-white font-semibold">
                                {{ auth()->user()->email }}
                            </p>
                        </div>

                        <a href="{{ route('profile.edit') }}"
                           class="block px-4 py-3 text-sm text-slate-300 hover:bg-white/5 transition">
                            Mi Perfil
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-3 text-sm text-rose-400 hover:bg-rose-500/10 transition">
                                Cerrar Sesión
                            </button>
                        </form>

                    </div>
                </div>

            </div>
        </div>

        {{-- ================= HEADER DE PÁGINA ================= --}}
        @isset($header)
            <div class="mt-4 pb-6 border-t border-white/5">
                <div class="pt-6">
                    {{ $header }}
                </div>
            </div>
        @endisset

    </div>
</nav>