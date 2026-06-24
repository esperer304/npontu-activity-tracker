<x-guest-layout>
    <div class="mb-5">
        <h1 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Create your account</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Support personnel only. Your bio is attached to every status update you log.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-3">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div>
                <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Last name</label>
                <input type="text" name="last_name" value="{{ old('last_name') }}" required autofocus
                       class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 focus:border-npontu-green-600 focus:ring-npontu-green-600 text-sm">
                <x-input-error :messages="$errors->get('last_name')" class="mt-1 text-xs" />
            </div>
            <div>
                <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Middle name</label>
                <input type="text" name="middle_name" value="{{ old('middle_name') }}"
                       class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 focus:border-npontu-green-600 focus:ring-npontu-green-600 text-sm">
                <x-input-error :messages="$errors->get('middle_name')" class="mt-1 text-xs" />
            </div>
            <div>
                <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">First name</label>
                <input type="text" name="first_name" value="{{ old('first_name') }}" required
                       class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 focus:border-npontu-green-600 focus:ring-npontu-green-600 text-sm">
                <x-input-error :messages="$errors->get('first_name')" class="mt-1 text-xs" />
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div>
                <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Employee ID</label>
                <input type="text" name="employee_id" value="{{ old('employee_id') }}"
                       class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 focus:border-npontu-green-600 focus:ring-npontu-green-600 text-sm">
                <x-input-error :messages="$errors->get('employee_id')" class="mt-1 text-xs" />
            </div>
            <div>
                <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Phone</label>
                <input type="tel" name="phone" value="{{ old('phone') }}"
                       inputmode="tel"
                       pattern="\+?[0-9 \-()]{7,20}"
                       maxlength="20"
                       placeholder="+233 24 123 4567"
                       title="Digits, spaces, +, -, or ( ) only — 7 to 20 characters."
                       class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 dark:placeholder-gray-500 focus:border-npontu-green-600 focus:ring-npontu-green-600 text-sm">
                <x-input-error :messages="$errors->get('phone')" class="mt-1 text-xs" />
            </div>
        </div>

        <div>
            <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Department</label>
            <input type="text" name="department" value="{{ old('department', 'Applications Support') }}"
                   class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 focus:border-npontu-green-600 focus:ring-npontu-green-600 text-sm">
        </div>

        <div>
            <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Work email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                   class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 focus:border-npontu-green-600 focus:ring-npontu-green-600 text-sm">
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs" />
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3" x-data="{ show: false }">
            <div>
                <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Password</label>
                <div class="relative">
                    <input :type="show ? 'text' : 'password'" name="password" required autocomplete="new-password"
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
            <div>
                <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Confirm</label>
                <div class="relative">
                    <input :type="show ? 'text' : 'password'" name="password_confirmation" required autocomplete="new-password"
                           class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 focus:border-npontu-green-600 focus:ring-npontu-green-600 text-sm pr-10">
                    <button type="button" @click="show = !show"
                            :aria-label="show ? 'Hide password' : 'Show password'"
                            class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 dark:text-gray-400 hover:text-npontu-green-700 dark:hover:text-npontu-green-200 focus:outline-none">
                        <i x-show="!show" class="ti ti-eye text-lg" aria-hidden="true"></i>
                        <i x-show="show"  class="ti ti-eye-off text-lg" aria-hidden="true" style="display:none"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between pt-3">
            <a class="text-sm text-npontu-green-700 dark:text-npontu-green-200 hover:underline" href="{{ route('login') }}">Already registered?</a>
            <button class="px-4 py-2 rounded-md bg-npontu-green-600 hover:bg-npontu-green-700 text-white text-sm font-medium">
                Create account
            </button>
        </div>
    </form>
</x-guest-layout>
