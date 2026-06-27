@props([
    'value' => 0,
    'max' => 100,
    'label' => null,
])

@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\ThemeContract::class);
    $percent = $max > 0 ? max(0, min(100, ((float) $value / (float) $max) * 100)) : 0;
@endphp

<div {{ $attributes->merge(['class' => $theme->classes('progress.container')]) }}>
    @if ($label)
        <div class="{{ $theme->classes('progress.header') }}">
            <span>{{ $label }}</span>
            <span>{{ round($percent) }}%</span>
        </div>
    @endif

    <div class="{{ $theme->classes('progress.track') }}" role="progressbar" aria-valuenow="{{ $value }}" aria-valuemin="0" aria-valuemax="{{ $max }}">
        <div class="{{ $theme->classes('progress.bar') }}" style="width: {{ $percent }}%"></div>
    </div>
</div>
