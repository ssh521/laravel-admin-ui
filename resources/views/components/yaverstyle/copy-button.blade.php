@props([
    'value',
    'label' => '복사',
    'showValue' => true,
])

@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\StyleClassResolver::class);
@endphp

<span {{ $attributes->merge(['class' => $theme->classes('copy-button.wrapper')]) }} x-data="{ copied: false }">
    @if ($showValue)
        <code class="{{ $theme->classes('copy-button.value') }}">{{ $value }}</code>
    @endif

    <x-laravel-admin::admin.action-button
        variant="secondary"
        type="button"
        icon="file-lines"
        @click="navigator.clipboard?.writeText(@js($value)); copied = true; setTimeout(() => copied = false, 1200)"
    >
        <span x-text="copied ? '복사됨' : @js($label)">{{ $label }}</span>
    </x-laravel-admin::admin.action-button>
</span>
