@props([
    'variant' => 'primary',
    'size' => 'md',
    'as' => null,
    'type' => 'button',
    'icon' => null,
])

@php
    $tag = $as ?: ($attributes->has('href') ? 'a' : 'button');

    $sizeClasses = [
        'xs' => 'btn-xs',
        'sm' => 'btn-sm',
        'md' => '',
        'lg' => 'btn-lg',
    ][$size] ?? '';

    $variantClasses = [
        'primary' => 'btn-primary',
        'secondary' => 'btn-outline',
        'danger' => 'btn-error',
        'search' => 'btn-primary',
        'link' => 'btn-ghost',
        'ghost' => 'btn-ghost',
    ][$variant] ?? 'btn-primary';

    $classes = trim("laravel-admin-action-button btn cursor-pointer {$sizeClasses} {$variantClasses} gap-2 hover:!no-underline");
@endphp

@if ($tag === 'a')
    <a {{ $attributes->merge(['class' => $classes]) }}>
        @if ($icon)
            <x-laravel-admin::admin.icon :name="$icon" class="size-4" />
        @endif

        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if ($icon)
            <x-laravel-admin::admin.icon :name="$icon" class="size-4" />
        @endif

        {{ $slot }}
    </button>
@endif
