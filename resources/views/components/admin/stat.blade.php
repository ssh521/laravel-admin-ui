@props([
    'label',
    'value',
    'description' => null,
])

@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\ThemeContract::class);
@endphp

<section {{ $attributes->merge(['class' => $theme->classes('stat.container')]) }}>
    <p class="{{ $theme->classes('stat.label') }}">{{ $label }}</p>
    <p class="{{ $theme->classes('stat.value') }}">{{ $value }}</p>

    @if ($description)
        <p class="{{ $theme->classes('stat.description') }}">{{ $description }}</p>
    @endif
</section>
