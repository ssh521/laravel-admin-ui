@props([
    'name',
    'value' => null,
    'action' => null,
    'method' => 'POST',
])

@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\StyleClassResolver::class);
@endphp

<form method="POST" @if ($action) action="{{ $action }}" @endif {{ $attributes->merge(['class' => $theme->classes('inline-edit.wrapper')]) }}>
    @csrf
    @if (! in_array(strtoupper($method), ['GET', 'POST'], true))
        @method($method)
    @endif

    <input name="{{ $name }}" value="{{ $value }}" class="{{ $theme->classes('inline-edit.input') }}">
    <x-laravel-admin::admin.action-button type="submit" size="sm">저장</x-laravel-admin::admin.action-button>
</form>
