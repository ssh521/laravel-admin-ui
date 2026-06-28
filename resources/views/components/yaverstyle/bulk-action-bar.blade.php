@props([
    'count' => 0,
    'label' => '선택됨',
])

@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\StyleClassResolver::class);
@endphp

<div {{ $attributes->merge(['class' => $theme->classes('bulk-action-bar.container')]) }}>
    <p class="{{ $theme->classes('bulk-action-bar.summary') }}">
        {{ number_format((int) $count) }} {{ $label }}
    </p>

    <div class="{{ $theme->classes('bulk-action-bar.actions') }}">
        {{ $slot }}
    </div>
</div>
