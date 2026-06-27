@props([
    'name',
    'label' => null,
    'options' => [],
    'selected' => null,
    'placeholder' => null,
])

@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\ThemeContract::class);
@endphp

<label {{ $attributes->merge(['class' => $theme->classes('filter-select.wrapper')]) }}>
    @if ($label)
        <span class="{{ $theme->classes('filter-select.label') }}">{{ $label }}</span>
    @endif

    <select name="{{ $name }}" class="{{ $theme->classes('filter-select.select') }}">
        @if ($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif

        @foreach ($options as $value => $optionLabel)
            <option value="{{ $value }}" @selected((string) $selected === (string) $value)>{{ $optionLabel }}</option>
        @endforeach

        {{ $slot }}
    </select>
</label>
