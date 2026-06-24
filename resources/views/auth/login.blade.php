<x-guest-layout>
    <div class="mb-5">
        <h1 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Welcome back</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Sign in to log activity updates and view the daily board.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-3">
        @csrf

        <div>
            <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                   class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 focus:border-npontu-green-600 focus:ring-npontu-green-600 text-sm">
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs" />
        </div>

        <div x-data="{ show: false }">
            <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Password</label>
            <div class="relative">
                <input :type="show ? 'text' : 'password'" name="password" required autocomplete="current-password"
                       class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 focus:border-npontu-green-600 focus:ring-npontu-green-600 text-sm pr-10">
                <button type="button" @click="show = !show"
                        :aria-label="show ? 'Hide password' : 'Show password'"
                        class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 dark:text-gray-400 hover:text-npontu-green-700 dark:hover:text-npontu-green-200 focus:outline-none">
                    <i x-show="!show" class="ti ti-eye text-lg" aria-hidden="true"></i>
                    <i x-show="show"  class="ti ti-eye-off text-lg" aria-hidden="true" style="display:none"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs" />
        </div>

        <label class="inline-flex items-center text-sm">
            <input type="checkbox" name="remember" class="rounded border-gray-300 dark:border-gray-600 text-npontu-green-600 focus:ring-npontu-green-600">
            <span class="ml-2 text-gray-600 dark:text-gray-300">Remember me</span>
        </label>

        <div class="flex items-center justify-between pt-3">
            @if (Route::has('password.request'))
                <a class="text-sm text-npontu-green-700 dark:text-npontu-green-200 hover:underline" href="{{ route('password.request') }}">Forgot password?</a>
            @endif
            <button class="px-4 py-2 rounded-md bg-npontu-green-600 hover:bg-npontu-green-700 text-white text-sm font-medium">
                Sign in
            </button>
        </div>

        <div class="pt-3 text-center text-xs text-gray-500 dark:text-gray-400">
            New here? <a href="{{ route('register') }}" class="text-npontu-green-700 dark:text-npontu-green-200 hover:underline">Create an account</a>
        </div>
    </form>
</x-guest-layout>
