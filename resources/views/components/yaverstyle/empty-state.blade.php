@props([
    'title' => null,
    'description' => null,
    'icon' => null,
])

<div {{ $attributes->merge(['class' => 'rounded-lg border border-dashed border-gray-300 bg-white px-6 py-16 text-center text-sm text-gray-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-400']) }}>
    @if ($icon)
        <x-laravel-admin::admin.icon :name="$icon" class="mx-auto mb-3 size-8 text-gray-400" />
    @endif

    @if ($title)
        <h3 class="text-sm font-medium text-gray-900 dark:text-white">{{ $title }}</h3>
    @endif

    @if ($description)
        <p class="mt-1">{{ $description }}</p>
    @else
        {{ $slot }}
    @endif
</div>
