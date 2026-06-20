@props([
    'show' => false,
    'title' => null,
    'maxWidth' => 'lg',
])

@php
    $widths = [
        'sm' => 'max-w-sm',
        'md' => 'max-w-md',
        'lg' => 'max-w-lg',
        'xl' => 'max-w-xl',
        '2xl' => 'max-w-2xl',
    ];

    $panelWidth = $widths[$maxWidth] ?? $widths['lg'];
@endphp

<div
    x-data="{ open: @js($show) }"
    x-show="open"
    x-cloak
    x-on:keydown.escape.window="open = false"
    class="fixed inset-0 z-50 grid place-items-center p-4"
    role="dialog"
    aria-modal="true"
>
    <div class="fixed inset-0 bg-black/40" x-on:click="open = false"></div>

    <div class="relative w-full {{ $panelWidth }} rounded-xl bg-white shadow-lg">
        @if ($title || isset($header))
            <div class="flex items-center justify-between border-b border-neutral-200 p-4">
                <div class="text-lg font-semibold text-neutral-900">
                    {{ $header ?? $title }}
                </div>

                <button type="button" class="rounded-lg p-1 text-neutral-500 hover:bg-neutral-100 hover:text-neutral-700" x-on:click="open = false" aria-label="Close modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="p-4 text-neutral-800">
            {{ $slot }}
        </div>

        @isset($footer)
            <div class="flex justify-end gap-2 border-t border-neutral-200 p-4">
                {{ $footer }}
            </div>
        @endisset
    </div>
</div>
