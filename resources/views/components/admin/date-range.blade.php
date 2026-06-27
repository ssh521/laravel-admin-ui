@props([
    'fromName' => 'from',
    'toName' => 'to',
    'from' => null,
    'to' => null,
    'fromLabel' => '시작일',
    'toLabel' => '종료일',
])

@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\ThemeContract::class);
@endphp

<div {{ $attributes->merge(['class' => $theme->classes('date-range.wrapper')]) }}>
    <label class="{{ $theme->classes('date-range.field') }}">
        <span class="{{ $theme->classes('date-range.label') }}">{{ $fromLabel }}</span>
        <input type="date" name="{{ $fromName }}" value="{{ $from }}" class="{{ $theme->classes('date-range.input') }}">
    </label>

    <label class="{{ $theme->classes('date-range.field') }}">
        <span class="{{ $theme->classes('date-range.label') }}">{{ $toLabel }}</span>
        <input type="date" name="{{ $toName }}" value="{{ $to }}" class="{{ $theme->classes('date-range.input') }}">
    </label>
</div>
