@php
    $nav = [
        ['route' => 'board',             'icon' => 'ti-layout-dashboard', 'label' => 'Daily board'],
        ['route' => 'activities.index',  'icon' => 'ti-list-check',       'label' => 'Activities'],
        ['route' => 'reports.index',     'icon' => 'ti-chart-bar',        'label' => 'Reports'],
        ['route' => 'profile.edit',      'icon' => 'ti-user',             'label' => 'Profile'],
    ];
@endphp
<aside
    class="fixed lg:static inset-y-0 left-0 w-64 lg:w-60 shrink-0 z-40
           bg-npontu-green-700 dark:bg-npontu-green-900 text-white flex flex-col
           transform transition-transform duration-200
           -translate-x-full lg:translate-x-0"
    :class="sidebarOpen && '!translate-x-0'">
    <div class="px-5 py-5 flex items-center justify-between gap-3 border-b border-white/10">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-npontu-yellow-500 text-npontu-green-800 flex items-center justify-center font-semibold text-lg">N</div>
            <div>
                <div class="font-semibold leading-tight">Npontu</div>
                <div class="text-xs text-white/70 leading-tight">Support tracker</div>
            </div>
        </div>
        {{-- Close button (mobile only) --}}
        <button type="button"
                @click="sidebarOpen = false"
                aria-label="Close menu"
                class="lg:hidden p-1.5 -mr-1 rounded text-white/80 hover:bg-white/10">
            <i class="ti ti-x text-lg"></i>
        </button>
    </div>

    <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
        @foreach ($nav as $item)
            @php $active = request()->routeIs($item['route']) || (str_starts_with($item['route'], 'activities') && request()->routeIs('activities.*')); @endphp
            <a href="{{ route($item['route']) }}"
               @click="sidebarOpen = false"
               class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition
                      {{ $active ? 'bg-npontu-yellow-500 text-npontu-green-800 font-medium' : 'text-white/90 hover:bg-white/10' }}">
                <i class="ti {{ $item['icon'] }} text-base"></i>
                <span>{{ $item['label'] }}</span>
            </a>
        @endforeach
    </nav>

    <div class="px-3 py-4 border-t border-white/10">
        <div class="flex items-center gap-3 px-2 py-2">
            <div class="w-9 h-9 rounded-full bg-npontu-yellow-500 text-npontu-green-800 flex items-center justify-center text-sm font-semibold">
                {{ strtoupper(substr(auth()->user()->name ?? '?', 0, 1)) }}{{ strtoupper(substr(strrchr(auth()->user()->name ?? '', ' '), 1, 1)) }}
            </div>
            <div class="min-w-0">
                <div class="text-sm truncate">{{ auth()->user()->name }}</div>
                <div class="text-xs text-white/60 truncate capitalize">{{ auth()->user()->role }} &middot; {{ auth()->user()->department ?? 'Support' }}</div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="px-2 mt-1">
            @csrf
            <button type="submit" class="w-full text-left text-xs text-white/70 hover:text-white flex items-center gap-2 px-1 py-1">
                <i class="ti ti-logout"></i> Sign out
            </button>
        </form>
    </div>
</aside>
