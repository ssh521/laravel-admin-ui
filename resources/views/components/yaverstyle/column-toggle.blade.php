@props([
    'columns' => [],
])

@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\StyleClassResolver::class);
@endphp

<x-laravel-admin::admin.dropdown align="right">
    <x-slot name="trigger">
        <button type="button" class="{{ $theme->classes('column-toggle.trigger') }}">
            컬럼
        </button>
    </x-slot>

    <x-slot name="content">
        @foreach ($columns as $name => $label)
            <label class="{{ $theme->classes('column-toggle.item') }}">
                <input type="checkbox" name="columns[]" value="{{ $name }}" checked>
                <span>{{ $label }}</span>
            </label>
        @endforeach

        {{ $slot }}
    </x-slot>
</x-laravel-admin::admin.dropdown>
