@props([
    'name',
    'value',
    'title',
    'description' => null,
    'checked' => false,
])

@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\StyleClassResolver::class);
@endphp

<label {{ $attributes->merge(['class' => $theme->classes('choice-card.container')]) }}>
    <input type="radio" name="{{ $name }}" value="{{ $value }}" class="{{ $theme->classes('choice-card.input') }}" @checked($checked)>
    <span>
        <span class="{{ $theme->classes('choice-card.title') }}">{{ $title }}</span>
        @if ($description)
            <span class="{{ $theme->classes('choice-card.description') }}">{{ $description }}</span>
        @endif
        {{ $slot }}
    </span>
</label>
