@props([
    'src' => null,
    'name' => null,
    'size' => 'md',
])

@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\ThemeContract::class);
    $initials = collect(preg_split('/\s+/', trim((string) $name)) ?: [])
        ->filter()
        ->map(fn ($part) => mb_substr($part, 0, 1))
        ->take(2)
        ->implode('');
@endphp

<span {{ $attributes->merge(['class' => trim($theme->classes('avatar.container').' '.$theme->classes('avatar.size', ['size' => $size]))]) }}>
    @if ($src)
        <img src="{{ $src }}" alt="{{ $name ?: 'Avatar' }}" class="{{ $theme->classes('avatar.image') }}">
    @else
        <span>{{ $initials ?: '?' }}</span>
    @endif
</span>
