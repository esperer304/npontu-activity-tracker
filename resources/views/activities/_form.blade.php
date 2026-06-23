@props(['activity' => null])
<div class="space-y-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
        <input type="text" name="title" required maxlength="150"
               value="{{ old('title', $activity?->title) }}"
               class="w-full rounded-md border-gray-300 focus:border-npontu-green-600 focus:ring-npontu-green-600">
        <p class="text-xs text-gray-500 mt-1">e.g. "Daily SMS count in comparison to SMS count from logs"</p>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Description (optional)</label>
        <textarea name="description" rows="3" maxlength="2000"
                  class="w-full rounded-md border-gray-300 focus:border-npontu-green-600 focus:ring-npontu-green-600">{{ old('description', $activity?->description) }}</textarea>
    </div>
    <label class="inline-flex items-center gap-2 text-sm">
        <input type="checkbox" name="is_active" value="1"
               {{ old('is_active', $activity?->is_active ?? true) ? 'checked' : '' }}
               class="rounded border-gray-300 text-npontu-green-600 focus:ring-npontu-green-600">
        Active (appears on the daily board)
    </label>
</div>
