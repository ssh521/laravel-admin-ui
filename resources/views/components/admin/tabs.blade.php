@props([
    'items' => [],
    'active' => null,
])

@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\ThemeContract::class);
@endphp

<nav {{ $attributes->merge(['class' => $theme->classes('tabs.nav')]) }} aria-label="Tabs">
    @foreach ($items as $key => $item)
        @php
            $label = is_array($item) ? ($item['label'] ?? $key) : $item;
            $href = is_array($item) ? ($item['href'] ?? '#') : '#';
            $isActive = (string) $active === (string) $key || (is_array($item) && ! empty($item['active']));
            $classes = trim($theme->classes('tabs.item').' '.($isActive ? $theme->classes('tabs.item-active') : ''));
        @endphp

        <a href="{{ $href }}" class="{{ $classes }}" aria-current="{{ $isActive ? 'page' : 'false' }}">
            {{ $label }}
        </a>
    @endforeach

    {{ $slot }}
</nav>
