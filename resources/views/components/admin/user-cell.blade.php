@props([
    'name',
    'email' => null,
    'src' => null,
])

@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\ThemeContract::class);
@endphp

<div {{ $attributes->merge(['class' => $theme->classes('user-cell.wrapper')]) }}>
    <x-laravel-admin::admin.avatar :src="$src" :name="$name" size="sm" />
    <div class="{{ $theme->classes('user-cell.body') }}">
        <p class="{{ $theme->classes('user-cell.name') }}">{{ $name }}</p>
        @if ($email)
            <p class="{{ $theme->classes('user-cell.email') }}">{{ $email }}</p>
        @endif
    </div>
</div>
