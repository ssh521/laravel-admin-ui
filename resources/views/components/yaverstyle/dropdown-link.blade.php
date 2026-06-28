@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\StyleClassResolver::class);
@endphp

<a {{ $attributes->merge(['class' => $theme->classes('dropdown-link')]) }}>{{ $slot }}</a>
