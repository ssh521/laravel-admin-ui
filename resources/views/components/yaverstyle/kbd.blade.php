@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\StyleClassResolver::class);
@endphp

<kbd {{ $attributes->merge(['class' => $theme->classes('kbd')]) }}>{{ $slot }}</kbd>
