<form {{ $attributes->merge(['method' => 'GET', 'class' => 'mt-6 flex flex-col gap-3 rounded-lg border border-gray-200 bg-gray-50 p-4 sm:flex-row sm:items-center dark:border-gray-700 dark:bg-gray-800/70']) }}>
    {{ $slot }}
</form>
