@props([
    'mobileToggle' => true,
])

@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\StyleClassResolver::class);
@endphp

@if($mobileToggle)
    <div x-data="{ filtersOpen: false }">
        <button
            type="button"
            class="mt-6 inline-flex h-9 items-center rounded-md border border-gray-300 bg-white px-3 text-sm font-semibold text-gray-800 shadow-sm transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 sm:hidden dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 dark:hover:bg-gray-800"
            x-bind:aria-expanded="filtersOpen.toString()"
            @click="filtersOpen = ! filtersOpen"
        >
            <span x-text="filtersOpen ? @js(__('검색/필터 닫기')) : @js(__('검색/필터'))"></span>
        </button>

        <form x-bind:class="{ '!flex': filtersOpen }" {{ $attributes->merge(['method' => 'GET', 'class' => $theme->classes('filter-bar')]) }}>
            {{ $slot }}
        </form>
    </div>
@else
    <form x-bind:class="{ '!flex': filtersOpen }" {{ $attributes->merge(['method' => 'GET', 'class' => $theme->classes('filter-bar')]) }}>
        {{ $slot }}
    </form>
@endif
