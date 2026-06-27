@props([
    'name' => null,
    'label' => null,
    'help' => null,
    'required' => false,
])

@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\ThemeContract::class);
@endphp

<div {{ $attributes->merge(['class' => $theme->classes('field.wrapper')]) }}>
    @if ($label)
        <label @if ($name) for="{{ $name }}" @endif class="{{ $theme->classes('field.label') }}">
            {{ $label }}
            @if ($required)
                <span class="{{ $theme->classes('field.required') }}" aria-hidden="true">*</span>
            @endif
        </label>
    @endif

    {{ $slot }}

    @if ($help)
        <p class="{{ $theme->classes('field.help') }}">{{ $help }}</p>
    @endif

    @if ($name)
        <x-laravel-admin::admin.input-error :for="$name" />
    @endif
</div>
