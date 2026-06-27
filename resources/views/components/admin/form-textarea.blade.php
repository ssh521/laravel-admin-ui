@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\ThemeContract::class);
@endphp

<textarea {{ $attributes->merge(['class' => $theme->classes('form.textarea')]) }}>{{ $slot }}</textarea>
