@props([
    'language' => null,
    'title' => null,
])

@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\StyleClassResolver::class);
@endphp

<section {{ $attributes->merge(['class' => $theme->classes('code-block.container')]) }}>
    @if ($title || $language)
        <header class="{{ $theme->classes('code-block.header') }}">
            <span>{{ $title }}</span>
            <span>{{ $language }}</span>
        </header>
    @endif

    <pre class="{{ $theme->classes('code-block.pre') }}"><code>{{ $slot }}</code></pre>
</section>
