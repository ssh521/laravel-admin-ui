@props([
    'name' => 'search',
    'value' => null,
    'placeholder' => '검색',
    'clearHref' => null,
])

<div {{ $attributes->merge(['class' => 'relative min-w-0']) }}>
    <x-laravel-admin::admin.icon name="magnifying-glass" class="pointer-events-none absolute left-3 top-1/2 size-4 -translate-y-1/2 text-base-content/40" />
    <input
        type="search"
        name="{{ $name }}"
        value="{{ $value }}"
        placeholder="{{ $placeholder }}"
        class="input input-bordered w-full pl-10 @if($clearHref) pr-10 @endif"
    >

    @if ($clearHref)
        <a href="{{ $clearHref }}" class="btn btn-ghost btn-xs absolute right-2 top-1/2 -translate-y-1/2" aria-label="검색어 지우기">
            <x-laravel-admin::admin.icon name="xmark" class="size-4" />
        </a>
    @endif
</div>
