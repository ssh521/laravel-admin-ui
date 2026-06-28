@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\StyleClassResolver::class);
@endphp

<hr {{ $attributes->merge(['class' => $theme->classes('divider')]) }}>
