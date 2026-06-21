@props([
    'variant' => 'primary',
    'size' => 'md',
    'as' => null,
    'type' => 'button',
    'icon' => null,
])

@php
    $tag = $as ?: ($attributes->has('href') ? 'a' : 'button');

    $sizes = [
        'sm' => 'h-8 px-3 text-sm',
        'md' => 'h-10 px-4 text-sm',
        'lg' => 'h-11 px-5 text-base',
    ];

    $variants = [
        'primary' => 'bg-indigo-600 !text-white shadow-sm hover:bg-indigo-500 focus-visible:outline-indigo-600 dark:bg-indigo-500 dark:hover:bg-indigo-400',
        'secondary' => 'border border-gray-300 bg-white !text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:!text-gray-100 dark:hover:bg-gray-700',
        'danger' => 'border border-red-200 bg-white !text-red-700 shadow-sm hover:bg-red-50 focus-visible:outline-red-600 dark:border-red-500/30 dark:bg-gray-900 dark:!text-red-300 dark:hover:bg-red-500/10',
        'search' => 'bg-gray-900 !text-white shadow-sm hover:bg-gray-700 focus-visible:outline-gray-900 dark:bg-white dark:!text-gray-900 dark:hover:bg-gray-200',
        'link' => '!text-indigo-600 hover:bg-indigo-50 dark:!text-indigo-300 dark:hover:bg-indigo-500/10',
    ];

    $classes = trim(implode(' ', [
        'inline-flex cursor-pointer items-center justify-center gap-2 rounded-md font-semibold transition hover:!no-underline focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 disabled:cursor-not-allowed disabled:opacity-50',
        $sizes[$size] ?? $sizes['md'],
        $variants[$variant] ?? $variants['primary'],
    ]));
@endphp

@if ($tag === 'a')
    <a {{ $attributes->merge(['class' => $classes]) }}>
        @if ($icon)
            <x-laravel-admin::admin.icon :name="$icon" class="text-xs" />
        @endif

        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if ($icon)
            <x-laravel-admin::admin.icon :name="$icon" class="text-xs" />
        @endif

        {{ $slot }}
    </button>
@endif
