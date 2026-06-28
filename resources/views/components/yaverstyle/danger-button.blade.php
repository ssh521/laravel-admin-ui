@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\StyleClassResolver::class);
@endphp

<button {{ $attributes->merge(['type' => 'button', 'class' => $theme->classes('legacy-button.danger')]) }}>
    {{ $slot }}
</button>
