@props([
    'show' => false,
    'label' => '처리 중',
])

@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\ThemeContract::class);
@endphp

<div {{ $attributes->merge(['class' => $theme->classes('loading-overlay.wrapper')]) }}>
    {{ $slot }}

    <div
        class="{{ $theme->classes('loading-overlay.overlay') }}"
        @if (! $show) style="display: none;" @endif
        aria-live="polite"
        aria-label="{{ $label }}"
    >
        <span class="{{ $theme->classes('loading-overlay.spinner') }}"></span>
    </div>
</div>
