@props([
    'items' => [],
])

@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\ThemeContract::class);
@endphp

<dl {{ $attributes->merge(['class' => $theme->classes('key-value-grid.container')]) }}>
    @foreach ($items as $key => $value)
        <div class="{{ $theme->classes('key-value-grid.item') }}">
            <dt class="{{ $theme->classes('key-value-grid.key') }}">{{ $key }}</dt>
            <dd class="{{ $theme->classes('key-value-grid.value') }}">{{ $value }}</dd>
        </div>
    @endforeach

    {{ $slot }}
</dl>
