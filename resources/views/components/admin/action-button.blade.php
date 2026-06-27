@props([
    'variant' => 'primary',
    'size' => 'md',
    'as' => null,
    'type' => 'button',
    'icon' => null,
])

@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\ThemeContract::class);
    $tag = $as ?: ($attributes->has('href') ? 'a' : 'button');

    $classes = trim(implode(' ', [
        $theme->classes('action-button.base'),
        $theme->classes('action-button.size', ['size' => $size]),
        $theme->classes('action-button.variant', ['variant' => $variant]),
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
