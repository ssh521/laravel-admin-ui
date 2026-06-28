@props([
    'variant' => 'neutral',
])

@php
    $variantClasses = [
        'primary' => 'badge-primary',
        'secondary' => 'badge-outline',
        'success' => 'badge-success',
        'warning' => 'badge-warning',
        'danger' => 'badge-error',
        'error' => 'badge-error',
        'info' => 'badge-info',
        'neutral' => 'badge-neutral',
    ][$variant] ?? 'badge-neutral';
@endphp

<span {{ $attributes->merge(['class' => trim("badge {$variantClasses}")]) }}>
    {{ $slot }}
</span>
