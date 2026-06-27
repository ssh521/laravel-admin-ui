@props([
    'type' => 'info',
    'title' => null,
    'message' => null,
])

@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\ThemeContract::class);
@endphp

<section {{ $attributes->merge(['class' => trim($theme->classes('notice.container').' '.$theme->classes('notice.variant', ['type' => $type]))]) }}>
    <div>
        @if ($title)
            <h2 class="{{ $theme->classes('notice.title') }}">{{ $title }}</h2>
        @endif

        @if ($message)
            <p class="{{ $theme->classes('notice.body') }}">{{ $message }}</p>
        @endif

        {{ $slot }}
    </div>
</section>
