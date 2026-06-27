@props([
    'formats' => ['csv' => 'CSV'],
])

@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\ThemeContract::class);
@endphp

<x-laravel-admin::admin.dropdown align="right">
    <x-slot name="trigger">
        <x-laravel-admin::admin.action-button variant="secondary" type="button" icon="arrow-down">
            내보내기
        </x-laravel-admin::admin.action-button>
    </x-slot>

    <x-slot name="content">
        <div class="{{ $theme->classes('export-button.menu') }}">
            @foreach ($formats as $href => $label)
                <x-laravel-admin::admin.dropdown-link href="{{ $href }}">{{ $label }}</x-laravel-admin::admin.dropdown-link>
            @endforeach
            {{ $slot }}
        </div>
    </x-slot>
</x-laravel-admin::admin.dropdown>
