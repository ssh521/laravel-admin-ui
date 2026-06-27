@props([
    'height' => '1rem',
    'width' => '100%',
])

@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\ThemeContract::class);
@endphp

<span {{ $attributes->merge(['class' => $theme->classes('skeleton')]) }} style="display: block; width: {{ $width }}; height: {{ $height }};" aria-hidden="true"></span>
