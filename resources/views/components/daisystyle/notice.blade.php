@props([
    'type' => 'info',
    'title' => null,
    'message' => null,
])

@php
    $variantClasses = [
        'success' => 'alert-success',
        'error' => 'alert-error',
        'warning' => 'alert-warning',
        'info' => 'alert-info',
    ][$type] ?? 'alert-info';
@endphp

<section {{ $attributes->merge(['class' => trim("alert {$variantClasses}")]) }}>
    <div>
        @if ($title)
            <h2 class="font-semibold">{{ $title }}</h2>
        @endif

        @if ($message)
            <p class="text-sm">{{ $message }}</p>
        @endif

        {{ $slot }}
    </div>
</section>
