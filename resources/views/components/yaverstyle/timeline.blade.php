@props([
    'items' => [],
])

@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\StyleClassResolver::class);
@endphp

<ol {{ $attributes->merge(['class' => $theme->classes('timeline.list')]) }}>
    @foreach ($items as $item)
        <li class="{{ $theme->classes('timeline.item') }}">
            <span class="{{ $theme->classes('timeline.marker') }}"></span>
            <h3 class="{{ $theme->classes('timeline.title') }}">{{ $item['title'] ?? '' }}</h3>

            @if (! empty($item['meta']))
                <p class="{{ $theme->classes('timeline.meta') }}">{{ $item['meta'] }}</p>
            @endif

            @if (! empty($item['body']))
                <p class="{{ $theme->classes('timeline.body') }}">{{ $item['body'] }}</p>
            @endif
        </li>
    @endforeach

    {{ $slot }}
</ol>
