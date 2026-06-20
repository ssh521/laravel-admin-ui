@props([
    'variant' => config('admin-ui.components.button.default_variant', 'solid'),
    'size' => config('admin-ui.components.button.default_size', 'md'),
    'type' => 'button',
])

@php
    $base = 'inline-flex items-center justify-center gap-2 font-medium transition focus:outline-none focus:ring-2 focus:ring-brand-400 disabled:opacity-50 disabled:cursor-not-allowed';

    $sizes = [
        'sm' => 'h-8 px-3 text-sm rounded-lg',
        'md' => 'h-10 px-4 text-sm rounded-lg',
        'lg' => 'h-11 px-5 text-base rounded-lg',
    ];

    $variants = [
        'solid' => 'bg-brand-500 text-white hover:bg-brand-600',
        'outline' => 'border border-neutral-300 bg-white text-neutral-800 hover:bg-neutral-50',
        'ghost' => 'bg-transparent text-neutral-700 hover:bg-neutral-100',
        'danger' => 'bg-danger-500 text-white hover:bg-danger-600',
    ];

    $classes = trim($base.' '.($sizes[$size] ?? $sizes['md']).' '.($variants[$variant] ?? $variants['solid']));
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</button>
