@props([
    'items' => [],
    'active' => null,
])

@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\ThemeContract::class);
@endphp

<ol {{ $attributes->merge(['class' => $theme->classes('stepper.list')]) }}>
    @foreach ($items as $key => $item)
        @php
            $label = is_array($item) ? ($item['label'] ?? $key) : $item;
            $isActive = (string) $active === (string) $key || (is_array($item) && ! empty($item['active']));
        @endphp

        <li class="{{ trim($theme->classes('stepper.item').' '.($isActive ? 'step-primary' : '')) }}">
            <span class="{{ trim($theme->classes('stepper.marker').' '.($isActive ? $theme->classes('stepper.marker-active') : '')) }}">{{ $loop->iteration }}</span>
            <span class="{{ $theme->classes('stepper.label') }}">{{ $label }}</span>
        </li>
    @endforeach

    {{ $slot }}
</ol>
