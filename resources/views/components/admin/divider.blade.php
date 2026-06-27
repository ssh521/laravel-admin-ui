@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\ThemeContract::class);
@endphp

<hr {{ $attributes->merge(['class' => $theme->classes('divider')]) }}>
