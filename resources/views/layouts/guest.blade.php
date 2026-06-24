<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Npontu Tracker') }}</title>

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
    <body class="font-sans text-gray-900 dark:text-gray-100 antialiased bg-gray-50 dark:bg-gray-950">
        <div class="min-h-screen grid md:grid-cols-2">

            <div class="hidden md:flex bg-npontu-green-700 dark:bg-npontu-green-900 text-white p-12 flex-col justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-lg bg-npontu-yellow-500 text-npontu-green-800 flex items-center justify-center font-semibold text-xl">N</div>
                    <div>
                        <div class="font-semibold">Npontu Technologies</div>
                        <div class="text-xs text-white/70">Making you free to achieve.</div>
                    </div>
                </div>
                <div class="space-y-4 max-w-sm">
                    <div class="text-3xl font-semibold leading-tight">Applications support<br>activity tracker</div>
                    <p class="text-white/80 text-sm leading-relaxed">
                        Log daily checks, update statuses, and hand pending work over to the next shift — with a full audit trail of who did what and when.
                    </p>
                    <div class="grid grid-cols-2 gap-3 pt-4 text-sm">
                        <div class="flex items-start gap-2"><i class="ti ti-checks text-npontu-yellow-500 mt-0.5"></i><span class="text-white/85">Done/pending tracking</span></div>
                        <div class="flex items-start gap-2"><i class="ti ti-history text-npontu-yellow-500 mt-0.5"></i><span class="text-white/85">Append-only audit log</span></div>
                        <div class="flex items-start gap-2"><i class="ti ti-users text-npontu-yellow-500 mt-0.5"></i><span class="text-white/85">Shift hand-over view</span></div>
                        <div class="flex items-start gap-2"><i class="ti ti-chart-bar text-npontu-yellow-500 mt-0.5"></i><span class="text-white/85">Date-range reports</span></div>
                    </div>
                </div>
                <div class="text-xs text-white/60">© {{ date('Y') }} Npontu Technologies · Accra, Ghana</div>
            </div>

            <div class="flex flex-col justify-center items-center p-4 sm:p-6">
                <div class="w-full sm:max-w-md px-5 sm:px-6 py-6 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
