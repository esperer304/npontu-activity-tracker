<x-app-layout>
    <div class="max-w-6xl mx-auto space-y-5">
        <div>
            <div class="text-xs uppercase tracking-wide text-npontu-green-600 dark:text-npontu-green-200 font-medium">History &amp; reports</div>
            <h1 class="text-xl sm:text-2xl font-semibold text-gray-900 dark:text-gray-100">Activity update history</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Query updates by date range, activity, personnel, or status. Export the result as CSV.</p>
        </div>

        {{-- Filters --}}
        <form method="GET" action="{{ route('reports.index') }}" class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-800 p-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-3">
            <div>
                <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">From</label>
                <input type="date" name="from" value="{{ $filters['from']->toDateString() }}" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 text-sm">
            </div>
            <div>
                <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">To</label>
                <input type="date" name="to" value="{{ $filters['to']->toDateString() }}" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 text-sm">
            </div>
            <div>
                <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Activity</label>
                <select name="activity_id" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 text-sm">
                    <option value="">All</option>
                    @foreach ($activities as $a)
                        <option value="{{ $a->id }}" {{ $filters['activity_id'] == $a->id ? 'selected' : '' }}>{{ $a->title }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Personnel</label>
                <select name="user_id" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 text-sm">
                    <option value="">All</option>
                    @foreach ($users as $u)
                        <option value="{{ $u->id }}" {{ $filters['user_id'] == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Status</label>
                <select name="status" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 text-sm">
                    <option value="">Any</option>
                    <option value="done" {{ $filters['status'] === 'done' ? 'selected' : '' }}>Done</option>
                    <option value="pending" {{ $filters['status'] === 'pending' ? 'selected' : '' }}>Pending</option>
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button class="flex-1 px-3 py-2 rounded-md bg-npontu-green-600 hover:bg-npontu-green-700 text-white text-sm flex items-center justify-center gap-1">
                    <i class="ti ti-filter"></i> Apply
                </button>
                <a href="{{ route('reports.export', request()->query()) }}"
                   class="px-3 py-2 rounded-md bg-npontu-yellow-500 hover:bg-npontu-yellow-400 text-npontu-green-800 text-sm flex items-center gap-1 font-medium">
                    <i class="ti ti-download"></i> CSV
                </a>
            </div>
        </form>

        {{-- Summary --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div class="rounded-lg bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 p-4 border-l-4 !border-l-gray-400">
                <div class="text-xs text-gray-500 dark:text-gray-400">Updates in range</div>
                <div class="text-2xl font-semibold mt-1 text-gray-900 dark:text-gray-100">{{ $summary['total'] }}</div>
            </div>
            <div class="rounded-lg bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 p-4 border-l-4 !border-l-npontu-green-600">
                <div class="text-xs text-gray-500 dark:text-gray-400">Marked done</div>
                <div class="text-2xl font-semibold mt-1 text-npontu-green-700 dark:text-npontu-green-200">{{ $summary['done'] }}</div>
            </div>
            <div class="rounded-lg bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 p-4 border-l-4 !border-l-npontu-yellow-500">
                <div class="text-xs text-gray-500 dark:text-gray-400">Marked pending</div>
                <div class="text-2xl font-semibold mt-1 text-npontu-yellow-800 dark:text-npontu-yellow-200">{{ $summary['pending'] }}</div>
            </div>
        </div>

        {{-- Results --}}
        <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-800 overflow-x-auto">
            <table class="w-full text-sm min-w-[720px]">
                <thead class="bg-gray-50 dark:bg-gray-800 text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">
                    <tr>
                        <th class="px-4 py-3 text-left">When</th>
                        <th class="px-4 py-3 text-left">Activity</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-left">Remark</th>
                        <th class="px-4 py-3 text-left">Personnel</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse ($updates as $u)
                        <tr>
                            <td class="px-4 py-3 text-gray-600 dark:text-gray-300 whitespace-nowrap">
                                <div>{{ $u->created_at->format('d M Y') }}</div>
                                <div class="text-xs text-gray-400 dark:text-gray-500">{{ $u->created_at->format('H:i') }}</div>
                            </td>
                            <td class="px-4 py-3 text-gray-900 dark:text-gray-100">{{ $u->activity->title ?? '—' }}</td>
                            <td class="px-4 py-3">
                                @if ($u->status === 'done')
                                    <span class="px-2 py-0.5 text-xs rounded-full bg-npontu-green-600 text-white font-medium">DONE</span>
                                @else
                                    <span class="px-2 py-0.5 text-xs rounded-full bg-npontu-yellow-500 text-npontu-green-800 font-medium">PENDING</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-700 dark:text-gray-200 max-w-md">{{ $u->remark }}</td>
                            <td class="px-4 py-3 text-gray-600 dark:text-gray-300">
                                <div>{{ $u->user->name ?? '—' }}</div>
                                <div class="text-xs text-gray-400 dark:text-gray-500">{{ $u->user->department ?? '' }} @if ($u->user?->employee_id) · {{ $u->user->employee_id }} @endif</div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">No updates match these filters.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div>{{ $updates->links() }}</div>
    </div>
</x-app-layout>
