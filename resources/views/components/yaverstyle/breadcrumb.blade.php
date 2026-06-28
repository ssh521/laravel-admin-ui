@props([
    'items' => [],
])

@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\StyleClassResolver::class);
@endphp

<nav {{ $attributes->merge(['class' => $theme->classes('breadcrumb.nav')]) }} aria-label="Breadcrumb">
    <ol class="{{ $theme->classes('breadcrumb.list') }}">
        @foreach ($items as $item)
            @php
                $label = is_array($item) ? ($item['label'] ?? '') : $item;
                $href = is_array($item) ? ($item['href'] ?? null) : null;
                $active = is_array($item) ? (bool) ($item['active'] ?? false) : $loop->last;
            @endphp

            <li class="flex items-center gap-2">
                @if (! $loop->first)
                    <span class="{{ $theme->classes('breadcrumb.separator') }}">/</span>
                @endif

                @if ($href && ! $active)
                    <a href="{{ $href }}" class="{{ $theme->classes('breadcrumb.link') }}">{{ $label }}</a>
                @else
                    <span class="{{ $theme->classes('breadcrumb.current') }}" aria-current="page">{{ $label }}</span>
                @endif
            </li>
        @endforeach

        {{ $slot }}
    </ol>
</nav>
