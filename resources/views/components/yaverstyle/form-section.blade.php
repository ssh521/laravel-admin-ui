@props([
    'title' => null,
    'description' => null,
])

@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\StyleClassResolver::class);
@endphp

<section {{ $attributes->merge(['class' => $theme->classes('form-section.container')]) }}>
    <div class="{{ $theme->classes('form-section.header') }}">
        @if ($title)
            <h2 class="{{ $theme->classes('form-section.title') }}">{{ $title }}</h2>
        @endif

        @if ($description)
            <p class="{{ $theme->classes('form-section.description') }}">{{ $description }}</p>
        @endif
    </div>

    <div class="{{ $theme->classes('form-section.body') }}">
        {{ $slot }}
    </div>
</section>
