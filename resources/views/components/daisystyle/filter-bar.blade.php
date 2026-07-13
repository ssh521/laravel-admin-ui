@props([
    'mobileToggle' => true,
])

@php
    $filterPanelId = 'admin-filter-panel-'.\Illuminate\Support\Str::uuid();
@endphp

@if($mobileToggle)
    <div x-data="{ filtersOpen: false }">
        <button
            type="button"
            class="btn btn-sm mt-6 sm:hidden"
            x-bind:aria-expanded="filtersOpen.toString()"
            aria-controls="{{ $filterPanelId }}"
            @click="filtersOpen = ! filtersOpen"
        >
            <span x-text="filtersOpen ? @js(__('검색/필터 닫기')) : @js(__('검색/필터'))"></span>
        </button>

        <form id="{{ $filterPanelId }}" x-bind:class="{ '!flex': filtersOpen }" {{ $attributes->merge(['method' => 'GET', 'class' => 'mt-3 hidden flex-col gap-3 rounded-box border border-base-300 bg-base-200 p-4 sm:mt-6 sm:flex sm:flex-row sm:items-center']) }}>
            {{ $slot }}
        </form>
    </div>
@else
    <form x-bind:class="{ '!flex': filtersOpen }" {{ $attributes->merge(['method' => 'GET', 'class' => 'mt-3 hidden flex-col gap-3 rounded-box border border-base-300 bg-base-200 p-4 sm:mt-6 sm:flex sm:flex-row sm:items-center']) }}>
        {{ $slot }}
    </form>
@endif
