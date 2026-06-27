@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\ThemeContract::class);
@endphp

<a {{ $attributes->merge(['class' => $theme->classes('dropdown-link')]) }}>{{ $slot }}</a>
