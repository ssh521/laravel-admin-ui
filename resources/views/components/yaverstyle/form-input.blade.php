@props([
    'type' => 'text',
])

@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\StyleClassResolver::class);
@endphp

<input
    type="{{ $type }}"
    {{ $attributes->merge(['class' => $theme->classes('form.input')]) }}
>
