<x-app-layout>
    <div class="max-w-6xl mx-auto space-y-6">

        {{-- Header --}}
        <div class="flex flex-wrap items-end justify-between gap-3">
            <div class="min-w-0">
                <div class="text-xs uppercase tracking-wide text-npontu-green-600 dark:text-npontu-green-200 font-medium">Shift hand-over board</div>
                <h1 class="text-xl sm:text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $date->format('l, d F Y') }}</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Every status change and remark recorded for the day — visible to the incoming personnel.</p>
            </div>
            <form method="GET" action="{{ route('board') }}" class="flex items-center gap-2 w-full sm:w-auto">
                <input type="date" name="date" value="{{ $date->toDateString() }}"
                       class="flex-1 sm:flex-none rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 text-sm focus:border-npontu-green-600 focus:ring-npontu-green-600">
                <button class="px-3 py-1.5 rounded-md bg-npontu-green-600 hover:bg-npontu-green-700 text-white text-sm flex items-center gap-1">
                    <i class="ti ti-calendar-search"></i> View
                </button>
            </form>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            <div class="rounded-lg bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 p-4 border-l-4 !border-l-npontu-green-600">
                <div class="text-xs text-gray-500 dark:text-gray-400">Active activities</div>
                <div class="text-2xl font-semibold mt-1 text-gray-900 dark:text-gray-100">{{ $stats['total'] }}</div>
            </div>
            <div class="rounded-lg bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 p-4 border-l-4 !border-l-npontu-green-500">
                <div class="text-xs text-gray-500 dark:text-gray-400">Marked done today</div>
                <div class="text-2xl font-semibold mt-1 text-npontu-green-700 dark:text-npontu-green-200">{{ $stats['done'] }}</div>
            </div>
            <div class="rounded-lg bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 p-4 border-l-4 !border-l-npontu-yellow-500">
                <div class="text-xs text-gray-500 dark:text-gray-400">Pending</div>
                <div class="text-2xl font-semibold mt-1 text-npontu-yellow-800 dark:text-npontu-yellow-200">{{ $stats['pending'] }}</div>
            </div>
            <div class="rounded-lg bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 p-4 border-l-4 !border-l-gray-400">
                <div class="text-xs text-gray-500 dark:text-gray-400">Updates logged</div>
                <div class="text-2xl font-semibold mt-1 text-gray-900 dark:text-gray-100">{{ $stats['logged'] }}</div>
            </div>
        </div>

        {{-- Activity rows --}}
        <div class="space-y-3">
            @forelse ($activities as $activity)
                @php
                    $latest = $latestByActivity->get($activity->id);
                    $status = $latest?->status;
                    $allToday = $updatesToday->where('activity_id', $activity->id)->sortByDesc('created_at');
                @endphp
                <div x-data="{ open: false }" class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-800 overflow-hidden">
                    <div class="p-4 flex flex-col lg:flex-row lg:items-start gap-4">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 flex-wrap">
                                <h3 class="font-medium text-gray-900 dark:text-gray-100">{{ $activity->title }}</h3>
                                @if ($status === 'done')
                                    <span class="px-2 py-0.5 text-xs rounded-full bg-npontu-green-600 text-white font-medium">DONE</span>
                                @elseif ($status === 'pending')
                                    <span class="px-2 py-0.5 text-xs rounded-full bg-npontu-yellow-500 text-npontu-green-800 font-medium">PENDING</span>
                                @else
                                    <span class="px-2 py-0.5 text-xs rounded-full bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400">No update yet</span>
                                @endif
                            </div>
                            @if ($activity->description)
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $activity->description }}</p>
                            @endif
                            @if ($latest)
                                <div class="mt-2 text-sm text-gray-700 dark:text-gray-200 italic">"{{ $latest->remark }}"</div>
                                <div class="mt-1 text-xs text-gray-500 dark:text-gray-400 flex flex-wrap gap-x-3 gap-y-1">
                                    <span><i class="ti ti-user"></i> {{ $latest->user->name }}
                                        @if ($latest->user->employee_id) <span class="text-gray-400 dark:text-gray-500">({{ $latest->user->employee_id }})</span>@endif
                                    </span>
                                    <span><i class="ti ti-building"></i> {{ $latest->user->department ?? '—' }}</span>
                                    <span><i class="ti ti-clock"></i> {{ $latest->created_at->format('H:i') }} GMT</span>
                                </div>
                            @endif
                        </div>

                        <form method="POST" action="{{ route('activities.updates.store', $activity) }}"
                              class="flex flex-col sm:flex-row sm:flex-wrap items-stretch sm:items-center gap-2 w-full lg:w-auto lg:min-w-[300px]">
                            @csrf
                            <select name="status" required class="rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 text-sm">
                                <option value="pending">Pending</option>
                                <option value="done">Done</option>
                            </select>
                            <input name="remark" required maxlength="1000" placeholder="Remark (required)"
                                   class="flex-1 sm:flex-none sm:w-56 rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 dark:placeholder-gray-500 text-sm">
                            <button class="px-3 py-1.5 rounded-md bg-npontu-green-600 hover:bg-npontu-green-700 text-white text-sm">
                                Log
                            </button>
                        </form>
                    </div>

                    @if ($allToday->count() > 0)
                        <button type="button" @click="open = !open"
                                class="w-full text-left px-4 py-2 text-xs text-npontu-green-700 dark:text-npontu-green-200 hover:bg-npontu-green-50 dark:hover:bg-npontu-green-900/30 border-t border-gray-100 dark:border-gray-800 flex items-center gap-1">
                            <i class="ti ti-history"></i>
                            <span x-text="open ? 'Hide today\'s timeline' : 'Show today\'s timeline (' + {{ $allToday->count() }} + ')'"></span>
                        </button>
                        <div x-show="open" x-cloak class="px-4 pb-4 pt-2 bg-gray-50 dark:bg-gray-950/60 border-t border-gray-100 dark:border-gray-800">
                            <ol class="relative border-l-2 border-npontu-green-100 dark:border-npontu-green-800 ml-2 space-y-3">
                                @foreach ($allToday as $u)
                                    <li class="ml-4">
                                        <div class="absolute -left-[7px] w-3 h-3 rounded-full
                                            {{ $u->status === 'done' ? 'bg-npontu-green-600' : 'bg-npontu-yellow-500' }} border-2 border-white dark:border-gray-900"></div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $u->created_at->format('H:i') }} · {{ $u->user->name }} marked
                                            <span class="font-medium {{ $u->status === 'done' ? 'text-npontu-green-700 dark:text-npontu-green-200' : 'text-npontu-yellow-800 dark:text-npontu-yellow-200' }}">{{ ucfirst($u->status) }}</span>
                                        </div>
                                        <div class="text-sm text-gray-800 dark:text-gray-200">"{{ $u->remark }}"</div>
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                    @endif
                </div>
            @empty
                <div class="bg-white dark:bg-gray-900 rounded-lg border border-dashed border-gray-300 dark:border-gray-700 p-12 text-center">
                    <i class="ti ti-clipboard-list text-3xl text-gray-300 dark:text-gray-600"></i>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">No active activities yet.</p>
                    <a href="{{ route('activities.create') }}" class="inline-block mt-3 px-3 py-1.5 rounded-md bg-npontu-green-600 hover:bg-npontu-green-700 text-white text-sm">
                        Create the first one
                    </a>
                </div>
            @endforelse
        </div>
    </div>
    <style>[x-cloak]{display:none !important}</style>
</x-app-layout>
