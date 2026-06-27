@props([
    'title',
    'open' => false,
])

@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\ThemeContract::class);
@endphp

<section
    {{ $attributes->merge(['class' => $theme->classes('accordion.container')]) }}
    x-data="{ open: @js((bool) $open) }"
>
    <button
        type="button"
        class="{{ $theme->classes('accordion.button') }}"
        :aria-expanded="open.toString()"
        @click="open = ! open"
    >
        <span>{{ $title }}</span>
        <x-laravel-admin::admin.icon name="chevron-down" class="{{ $theme->classes('accordion.icon') }}" x-bind:class="{ 'rotate-180': open }" />
    </button>

    <div x-show="open" x-collapse>
        <div class="{{ $theme->classes('accordion.content') }}">
            {{ $slot }}
        </div>
    </div>
</section>
