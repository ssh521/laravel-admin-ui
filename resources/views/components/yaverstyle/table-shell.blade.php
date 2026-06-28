@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\StyleClassResolver::class);
@endphp

<div {{ $attributes->merge(['class' => $theme->classes('table-shell.outer')]) }}>
    <div class="{{ $theme->classes('table-shell.scroller') }}">
        <div class="{{ $theme->classes('table-shell.inner') }}">
            {{ $slot }}
        </div>
    </div>
</div>
