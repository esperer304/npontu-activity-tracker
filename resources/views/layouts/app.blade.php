<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Npontu Tracker') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.19.0/dist/tabler-icons.min.css">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-900">
        <div class="min-h-screen flex">
            @include('layouts.sidebar')

            <div class="flex-1 flex flex-col min-w-0">
                @include('layouts.topbar')

                @if (session('status'))
                    <div class="mx-6 mt-4 rounded-lg bg-npontu-green-50 border border-npontu-green-200 text-npontu-green-800 px-4 py-2 text-sm">
                        <i class="ti ti-check"></i> {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mx-6 mt-4 rounded-lg bg-red-50 border border-red-200 text-red-800 px-4 py-2 text-sm">
                        <i class="ti ti-alert-triangle"></i>
                        <ul class="inline ml-1">
                            @foreach ($errors->all() as $error)
                                <li class="inline">{{ $error }}@if (!$loop->last);@endif</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <main class="flex-1 p-6">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
