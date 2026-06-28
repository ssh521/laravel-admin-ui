@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\StyleClassResolver::class);
@endphp

<form {{ $attributes->merge(['method' => 'GET', 'class' => $theme->classes('filter-bar')]) }}>
    {{ $slot }}
</form>
