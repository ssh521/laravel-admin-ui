@props([
    'variant' => 'neutral',
    'label' => null,
])

@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\ThemeContract::class);
@endphp

<span {{ $attributes->merge(['class' => $theme->classes('status-dot.wrapper')]) }}>
    <span class="{{ $theme->classes('status-dot.dot', ['variant' => $variant]) }}" aria-hidden="true"></span>
    @if ($label)
        <span>{{ $label }}</span>
    @endif
</span>
