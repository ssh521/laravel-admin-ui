@props([
    'messages',
    'for' => null,
])

@if ($messages)
    <ul
        @if ($for) id="{{ $for }}-error" @endif
        role="alert"
        {{ $attributes->merge(['class' => 'text-sm text-red-600 dark:text-red-400 space-y-1']) }}
    >
        @foreach ((array) $messages as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif
