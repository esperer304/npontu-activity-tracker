<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Npontu Tracker') }}</title>

        {{-- FOUC-safe theme bootstrap: runs before any CSS paints --}}
        <script>
            (function () {
                try {
                    var stored = localStorage.getItem('theme');
                    var prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                    if (stored === 'dark' || (!stored && prefersDark)) {
                        document.documentElement.classList.add('dark');
                    }
                } catch (e) {}
            })();
        </script>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.19.0/dist/tabler-icons.min.css">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-gray-100">
        <div class="min-h-screen flex" x-data="{ sidebarOpen: false }">
            {{-- Mobile backdrop --}}
            <div x-show="sidebarOpen"
                 x-transition.opacity
                 @click="sidebarOpen = false"
                 class="fixed inset-0 bg-black/50 z-30 lg:hidden"
                 style="display:none"></div>

            @include('layouts.sidebar')

            <div class="flex-1 flex flex-col min-w-0">
                @include('layouts.topbar')

                @if (session('status'))
                    <div class="mx-4 sm:mx-6 mt-4 rounded-lg bg-npontu-green-50 dark:bg-npontu-green-900/30 border border-npontu-green-200 dark:border-npontu-green-700 text-npontu-green-800 dark:text-npontu-green-100 px-4 py-2 text-sm">
                        <i class="ti ti-check"></i> {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mx-4 sm:mx-6 mt-4 rounded-lg bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-100 px-4 py-2 text-sm">
                        <i class="ti ti-alert-triangle"></i>
                        <ul class="inline ml-1">
                            @foreach ($errors->all() as $error)
                                <li class="inline">{{ $error }}@if (!$loop->last);@endif</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <main class="flex-1 p-4 sm:p-6">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
