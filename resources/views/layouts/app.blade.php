<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="font-sans antialiased bg-[#0b1220] text-white relative overflow-x-hidden">

        <!-- Fondo Corporativo Dark -->
        <div class="fixed inset-0 -z-10">
            <!-- Gradiente principal -->
            <div class="absolute inset-0 bg-gradient-to-br from-[#0b1220] via-[#0f1b2d] to-[#0a1626]"></div>

            <!-- Iluminaciones decorativas -->
            <div class="absolute top-[-200px] right-[-200px] w-[600px] h-[600px] bg-cyan-500/10 blur-3xl rounded-full"></div>
            <div class="absolute bottom-[-200px] left-[-200px] w-[600px] h-[600px] bg-blue-500/10 blur-3xl rounded-full"></div>
        </div>

        <div class="min-h-screen">

            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white/5 backdrop-blur-xl border-b border-white/10 shadow-lg">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
           <main class="pt-32 pb-20">
                {{ $slot }}
            </main>

            <!-- Alert Success -->
            @if(session('success'))
                <div class="max-w-6xl mx-auto mt-4 px-4">
                    <div class="bg-emerald-500/20 border border-emerald-400/30 text-emerald-300 px-4 py-3 rounded-xl backdrop-blur-lg shadow-lg">
                        {{ session('success') }}
                    </div>
                </div>
            @endif

        </div>

    </body>
</html>