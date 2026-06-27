@props([
    'items' => [],
])

@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\ThemeContract::class);
@endphp

<dl {{ $attributes->merge(['class' => $theme->classes('description-list.container')]) }}>
    <div class="{{ $theme->classes('description-list.grid') }}">
        @foreach ($items as $term => $description)
            <div class="{{ $theme->classes('description-list.row') }}">
                <dt class="{{ $theme->classes('description-list.term') }}">{{ $term }}</dt>
                <dd class="{{ $theme->classes('description-list.description') }}">{{ $description }}</dd>
            </div>
        @endforeach

        {{ $slot }}
    </div>
</dl>
