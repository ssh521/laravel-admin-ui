@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\ThemeContract::class);
@endphp

<button {{ $attributes->merge(['type' => 'submit', 'class' => $theme->classes('legacy-button.primary')]) }}>
    {{ $slot }}
</button>
