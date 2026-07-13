@props([
    'show' => false,
    'label' => '처리 중',
])

@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\StyleClassResolver::class);
@endphp

<div aria-busy="{{ $show ? 'true' : 'false' }}" {{ $attributes->merge(['class' => $theme->classes('loading-overlay.wrapper')]) }}>
    {{ $slot }}

    <div
        class="{{ $theme->classes('loading-overlay.overlay') }}"
        @if (! $show) style="display: none;" @endif
        aria-live="polite"
        aria-label="{{ $label }}"
        role="status"
    >
        <span class="{{ $theme->classes('loading-overlay.spinner') }}"></span>
        <span class="sr-only">{{ $label }}</span>
    </div>
</div>
