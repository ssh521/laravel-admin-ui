@props([
    'align' => 'right',
])

@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\ThemeContract::class);
@endphp

<x-laravel-admin::admin.dropdown :align="$align">
    <x-slot name="trigger">
        <button type="button" class="{{ $theme->classes('action-menu.trigger') }}" aria-label="작업 메뉴">
            <x-laravel-admin::admin.icon name="bars" class="size-4" />
        </button>
    </x-slot>

    <x-slot name="content">
        {{ $slot }}
    </x-slot>
</x-laravel-admin::admin.dropdown>
