@props([
    'title',
    'description' => null,
    'breadcrumbs' => [],
])

@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\ThemeContract::class);
@endphp

<header {{ $attributes->merge(['class' => $theme->classes('page-header.container')]) }}>
    <div>
        @if ($breadcrumbs)
            <x-laravel-admin::admin.breadcrumb :items="$breadcrumbs" class="mb-3" />
        @endif

        <h1 class="{{ $theme->classes('page-header.title') }}">{{ $title }}</h1>

        @if ($description)
            <p class="{{ $theme->classes('page-header.description') }}">{{ $description }}</p>
        @endif
    </div>

    @isset($actions)
        <div class="{{ $theme->classes('page-header.actions') }}">
            {{ $actions }}
        </div>
    @endisset
</header>
