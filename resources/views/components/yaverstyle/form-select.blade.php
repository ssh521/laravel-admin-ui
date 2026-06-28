@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\StyleClassResolver::class);
@endphp

<select {{ $attributes->merge(['class' => $theme->classes('form.select')]) }}>
    {{ $slot }}
</select>
