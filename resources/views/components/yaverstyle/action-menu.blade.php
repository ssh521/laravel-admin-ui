@props([
    'align' => 'right',
])

@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\StyleClassResolver::class);
@endphp

<x-laravel-admin::admin.dropdown
    :align="$align"
    width="36"
    adaptive
    content-classes="laravel-admin-action-menu-content overflow-hidden rounded-2xl border border-gray-200 bg-white p-2 shadow-xl ring-0 dark:border-gray-700 dark:bg-gray-900"
>
    <x-slot name="trigger">
        <button type="button" class="{{ $theme->classes('action-menu.trigger') }}" aria-label="작업 메뉴">
            <x-laravel-admin::admin.icon name="ellipsis" class="size-7" />
        </button>
    </x-slot>

    <x-slot name="content">
        {{ $slot }}
    </x-slot>
</x-laravel-admin::admin.dropdown>
