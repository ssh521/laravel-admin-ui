@props([
    'for' => null,
    'title' => null,
    'description' => null,
])

<label @if($for) for="{{ $for }}" @endif {{ $attributes->merge(['class' => 'flex min-h-12 cursor-pointer items-start gap-3 rounded-md border border-gray-200 bg-white p-4 shadow-sm hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-900 dark:hover:bg-gray-800']) }}>
    {{ $slot }}

    @if ($title || $description)
        <span>
            @if ($title)
                <span class="block text-sm font-medium text-gray-900 dark:text-white">{{ $title }}</span>
            @endif

            @if ($description)
                <span class="block text-sm text-gray-500 dark:text-gray-400">{{ $description }}</span>
            @endif
        </span>
    @endif
</label>
