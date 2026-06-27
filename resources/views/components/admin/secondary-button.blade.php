@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\ThemeContract::class);
@endphp

<button {{ $attributes->merge(['type' => 'button', 'class' => $theme->classes('legacy-button.secondary')]) }}>
    {{ $slot }}
</button>
