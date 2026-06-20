@props([
    'padding' => config('admin-ui.components.card.padding', 'md'),
    'shadow' => config('admin-ui.components.card.shadow', true),
])

@php
    $paddings = [
        'none' => '',
        'sm' => 'p-3',
        'md' => 'p-4',
        'lg' => 'p-6',
    ];

    $classes = trim('bg-white border border-neutral-200 rounded-xl '.($shadow ? 'shadow-sm' : '').' '.($paddings[$padding] ?? $paddings['md']));
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
