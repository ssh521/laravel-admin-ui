@props([
    'variant' => 'neutral',
])

@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\ThemeContract::class);
@endphp

<span {{ $attributes->merge(['class' => trim($theme->classes('badge.base').' '.$theme->classes('badge.variant', ['variant' => $variant]))]) }}>
    {{ $slot }}
</span>
