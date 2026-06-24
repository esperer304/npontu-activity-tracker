<x-app-layout>
    <div class="max-w-2xl mx-auto">
        <h1 class="text-xl sm:text-2xl font-semibold mb-1 text-gray-900 dark:text-gray-100">Edit activity</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-5">Changes only affect future updates; the audit trail stays intact.</p>

        <form method="POST" action="{{ route('activities.update', $activity) }}" class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-800 p-4 sm:p-6">
            @csrf @method('PUT')
            @include('activities._form', ['activity' => $activity])
            <div class="mt-6 flex justify-end gap-2">
                <a href="{{ route('activities.index') }}" class="px-4 py-2 text-sm text-gray-600 dark:text-gray-400">Cancel</a>
                <button class="px-4 py-2 rounded-md bg-npontu-green-600 hover:bg-npontu-green-700 text-white text-sm">Save changes</button>
            </div>
        </form>
    </div>
</x-app-layout>
