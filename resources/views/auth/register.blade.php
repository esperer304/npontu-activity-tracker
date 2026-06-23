<x-guest-layout>
    <div class="mb-5">
        <h1 class="text-xl font-semibold">Create your account</h1>
        <p class="text-sm text-gray-500 mt-1">Support personnel only. Your bio is attached to every status update you log.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-3">
        @csrf

        <div>
            <label class="block text-xs text-gray-600 mb-1">Full name</label>
            <input type="text" name="name" value="{{ old('name') }}" required autofocus
                   class="w-full rounded-md border-gray-300 focus:border-npontu-green-600 focus:ring-npontu-green-600 text-sm">
            <x-input-error :messages="$errors->get('name')" class="mt-1 text-xs" />
        </div>

        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block text-xs text-gray-600 mb-1">Employee ID</label>
                <input type="text" name="employee_id" value="{{ old('employee_id') }}"
                       class="w-full rounded-md border-gray-300 focus:border-npontu-green-600 focus:ring-npontu-green-600 text-sm">
                <x-input-error :messages="$errors->get('employee_id')" class="mt-1 text-xs" />
            </div>
            <div>
                <label class="block text-xs text-gray-600 mb-1">Phone</label>
                <input type="text" name="phone" value="{{ old('phone') }}"
                       class="w-full rounded-md border-gray-300 focus:border-npontu-green-600 focus:ring-npontu-green-600 text-sm">
            </div>
        </div>

        <div>
            <label class="block text-xs text-gray-600 mb-1">Department</label>
            <input type="text" name="department" value="{{ old('department', 'Applications Support') }}"
                   class="w-full rounded-md border-gray-300 focus:border-npontu-green-600 focus:ring-npontu-green-600 text-sm">
        </div>

        <div>
            <label class="block text-xs text-gray-600 mb-1">Work email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                   class="w-full rounded-md border-gray-300 focus:border-npontu-green-600 focus:ring-npontu-green-600 text-sm">
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs" />
        </div>

        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block text-xs text-gray-600 mb-1">Password</label>
                <input type="password" name="password" required autocomplete="new-password"
                       class="w-full rounded-md border-gray-300 focus:border-npontu-green-600 focus:ring-npontu-green-600 text-sm">
                <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs" />
            </div>
            <div>
                <label class="block text-xs text-gray-600 mb-1">Confirm</label>
                <input type="password" name="password_confirmation" required autocomplete="new-password"
                       class="w-full rounded-md border-gray-300 focus:border-npontu-green-600 focus:ring-npontu-green-600 text-sm">
            </div>
        </div>

        <div class="flex items-center justify-between pt-3">
            <a class="text-sm text-npontu-green-700 hover:underline" href="{{ route('login') }}">Already registered?</a>
            <button class="px-4 py-2 rounded-md bg-npontu-green-600 hover:bg-npontu-green-700 text-white text-sm font-medium">
                Create account
            </button>
        </div>
    </form>
</x-guest-layout>
