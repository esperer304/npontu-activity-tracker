<header class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800"
        x-data="{
            theme: localStorage.getItem('theme') || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'),
            toggleTheme() {
                this.theme = this.theme === 'dark' ? 'light' : 'dark';
                localStorage.setItem('theme', this.theme);
                document.documentElement.classList.toggle('dark', this.theme === 'dark');
            }
        }">
    <div class="px-4 sm:px-6 py-3 flex items-center justify-between gap-3">
        <div class="flex items-center gap-3 min-w-0">
            {{-- Hamburger (mobile only) --}}
            <button type="button"
                    @click="sidebarOpen = true"
                    aria-label="Open menu"
                    class="lg:hidden p-2 -ml-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                <i class="ti ti-menu-2 text-xl"></i>
            </button>
            <div class="min-w-0">
                <div class="text-xs uppercase tracking-wide text-npontu-green-600 dark:text-npontu-green-200 font-medium">
                    {{ now()->format('l') }}
                </div>
                <div class="text-sm sm:text-base font-medium text-gray-900 dark:text-gray-100 truncate">
                    {{ now()->format('d M Y · H:i') }} GMT
                </div>
            </div>
        </div>

        <div class="flex items-center gap-2 text-sm">
            <span class="hidden sm:flex px-2 py-1 rounded-md bg-npontu-green-50 dark:bg-npontu-green-900/40 text-npontu-green-700 dark:text-npontu-green-200 text-xs font-medium items-center gap-1">
                <i class="ti ti-shield-check"></i> Authenticated
            </span>

            <button type="button"
                    @click="toggleTheme()"
                    :aria-label="theme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode'"
                    class="p-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-npontu-green-500">
                <i x-show="theme === 'light'" class="ti ti-moon text-lg" aria-hidden="true"></i>
                <i x-show="theme === 'dark'"  class="ti ti-sun text-lg"  aria-hidden="true" style="display:none"></i>
            </button>

            <a href="{{ route('activities.create') }}"
               class="px-3 py-1.5 rounded-md bg-npontu-green-600 hover:bg-npontu-green-700 text-white text-xs font-medium flex items-center gap-1">
                <i class="ti ti-plus"></i><span class="hidden sm:inline"> New activity</span>
            </a>
        </div>
    </div>
</header>
