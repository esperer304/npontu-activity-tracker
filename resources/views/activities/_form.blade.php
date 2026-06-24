@props(['activity' => null])
<div class="space-y-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Title</label>
        <input type="text" name="title" required maxlength="150"
               value="{{ old('title', $activity?->title) }}"
               class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 focus:border-npontu-green-600 focus:ring-npontu-green-600">
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">e.g. "Daily SMS count in comparison to SMS count from logs"</p>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Description (optional)</label>
        <textarea name="description" rows="3" maxlength="2000"
                  class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 focus:border-npontu-green-600 focus:ring-npontu-green-600">{{ old('description', $activity?->description) }}</textarea>
    </div>
    <label class="inline-flex items-center gap-2 text-sm text-gray-700 dark:text-gray-200">
        <input type="checkbox" name="is_active" value="1"
               {{ old('is_active', $activity?->is_active ?? true) ? 'checked' : '' }}
               class="rounded border-gray-300 dark:border-gray-600 text-npontu-green-600 focus:ring-npontu-green-600">
        Active (appears on the daily board)
    </label>
</div>
