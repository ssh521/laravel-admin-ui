@props([
    'name' => 'search',
    'value' => null,
    'placeholder' => '검색',
    'clearHref' => null,
])

@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\StyleClassResolver::class);
@endphp

<div {{ $attributes->merge(['class' => $theme->classes('search-input.wrapper')]) }}>
    <x-laravel-admin::admin.icon name="magnifying-glass" class="{{ $theme->classes('search-input.icon') }}" />
    <input
        type="search"
        name="{{ $name }}"
        value="{{ $value }}"
        placeholder="{{ $placeholder }}"
        class="{{ $theme->classes('search-input.input') }}"
    >

    @if ($clearHref)
        <a href="{{ $clearHref }}" class="{{ $theme->classes('search-input.clear') }}" aria-label="검색어 지우기">
            <x-laravel-admin::admin.icon name="xmark" class="size-4" />
        </a>
    @endif
</div>
