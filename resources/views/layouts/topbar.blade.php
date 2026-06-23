<header class="bg-white border-b border-gray-200">
    <div class="px-6 py-3 flex items-center justify-between">
        <div>
            <div class="text-xs uppercase tracking-wide text-npontu-green-600 font-medium">
                {{ now()->format('l') }}
            </div>
            <div class="text-base font-medium text-gray-900">
                {{ now()->format('d M Y · H:i') }} GMT
            </div>
        </div>
        <div class="flex items-center gap-2 text-sm">
            <span class="px-2 py-1 rounded-md bg-npontu-green-50 text-npontu-green-700 text-xs font-medium flex items-center gap-1">
                <i class="ti ti-shield-check"></i> Authenticated
            </span>
            <a href="{{ route('activities.create') }}" class="px-3 py-1.5 rounded-md bg-npontu-green-600 hover:bg-npontu-green-700 text-white text-xs font-medium flex items-center gap-1">
                <i class="ti ti-plus"></i> New activity
            </a>
        </div>
    </div>
</header>
