@props([
    'title' => null,
    'description' => null,
])

@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\ThemeContract::class);
@endphp

<section {{ $attributes->merge(['class' => $theme->classes('card.container')]) }}>
    @if ($title || $description || isset($actions))
        <header class="{{ $theme->classes('card.header') }}">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    @if ($title)
                        <h2 class="{{ $theme->classes('card.title') }}">{{ $title }}</h2>
                    @endif

                    @if ($description)
                        <p class="{{ $theme->classes('card.description') }}">{{ $description }}</p>
                    @endif
                </div>

                @isset($actions)
                    <div class="flex flex-wrap gap-2">
                        {{ $actions }}
                    </div>
                @endisset
            </div>
        </header>
    @endif

    <div class="{{ $theme->classes('card.body') }}">
        {{ $slot }}
    </div>

    @isset($footer)
        <footer class="{{ $theme->classes('card.footer') }}">
            {{ $footer }}
        </footer>
    @endisset
</section>
