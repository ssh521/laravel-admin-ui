@props([
    'title' => null,
    'side' => 'right',
])

@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\ThemeContract::class);
@endphp

<div x-data="{ open: false }">
    @isset($trigger)
        <div @click="open = true">
            {{ $trigger }}
        </div>
    @endisset

    <div
        x-show="open"
        x-cloak
        class="{{ $theme->classes('drawer.backdrop') }}"
        @keydown.escape.window="open = false"
    >
        <aside class="{{ $theme->classes('drawer.panel', ['side' => $side]) }}" @click.outside="open = false">
            <header class="{{ $theme->classes('drawer.header') }}">
                @if ($title)
                    <h2 class="{{ $theme->classes('drawer.title') }}">{{ $title }}</h2>
                @else
                    <span></span>
                @endif

                <button type="button" @click="open = false" aria-label="닫기">
                    <x-laravel-admin::admin.icon name="xmark" class="size-5" />
                </button>
            </header>

            <div class="{{ $theme->classes('drawer.body') }}">
                {{ $slot }}
            </div>
        </aside>
    </div>
</div>
