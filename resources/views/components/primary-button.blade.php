<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-npontu-green-600 hover:bg-npontu-green-700 border border-transparent rounded-md font-medium text-sm text-white focus:outline-none focus:ring-2 focus:ring-npontu-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition']) }}>
    {{ $slot }}
</button>
