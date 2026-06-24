<x-app-layout>
    <div class="max-w-6xl mx-auto">
        <div class="flex flex-wrap items-end justify-between gap-3 mb-5">
            <div>
                <div class="text-xs uppercase tracking-wide text-npontu-green-600 dark:text-npontu-green-200 font-medium">Master list</div>
                <h1 class="text-xl sm:text-2xl font-semibold text-gray-900 dark:text-gray-100">Activities</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">The recurring checks personnel update each day.</p>
            </div>
            <a href="{{ route('activities.create') }}" class="px-3 py-2 rounded-md bg-npontu-green-600 hover:bg-npontu-green-700 text-white text-sm flex items-center gap-1">
                <i class="ti ti-plus"></i> New activity
            </a>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-800 overflow-x-auto">
            <table class="w-full text-sm min-w-[640px]">
                <thead class="bg-gray-50 dark:bg-gray-800 text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">
                    <tr>
                        <th class="px-4 py-3 text-left">Title</th>
                        <th class="px-4 py-3 text-left">Latest update</th>
                        <th class="px-4 py-3 text-left">Created by</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse ($activities as $activity)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="font-medium text-gray-900 dark:text-gray-100">{{ $activity->title }}</div>
                                @if ($activity->description)
                                    <div class="text-xs text-gray-500 dark:text-gray-400 truncate max-w-md">{{ $activity->description }}</div>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-600 dark:text-gray-300">
                                @if ($activity->latestUpdate)
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $activity->latestUpdate->created_at->diffForHumans() }}</div>
                                    <div class="text-xs">by {{ $activity->latestUpdate->user->name }}</div>
                                @else
                                    <span class="text-gray-400 dark:text-gray-500">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-600 dark:text-gray-300">{{ $activity->creator->name }}</td>
                            <td class="px-4 py-3">
                                @if ($activity->is_active)
                                    <span class="px-2 py-0.5 text-xs rounded-full bg-npontu-green-50 dark:bg-npontu-green-900/40 text-npontu-green-700 dark:text-npontu-green-200 border border-npontu-green-200 dark:border-npontu-green-700">Active</span>
                                @else
                                    <span class="px-2 py-0.5 text-xs rounded-full bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400">Archived</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right whitespace-nowrap">
                                <a href="{{ route('activities.edit', $activity) }}" class="text-npontu-green-700 dark:text-npontu-green-200 hover:underline text-xs">Edit</a>
                                @if ($activity->is_active)
                                    <form method="POST" action="{{ route('activities.destroy', $activity) }}" class="inline ml-2"
                                          onsubmit="return confirm('Archive this activity? It will no longer appear on the daily board.')">
                                        @csrf @method('DELETE')
                                        <button class="text-red-600 dark:text-red-400 hover:underline text-xs">Archive</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">No activities yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $activities->links() }}</div>
    </div>
</x-app-layout>
