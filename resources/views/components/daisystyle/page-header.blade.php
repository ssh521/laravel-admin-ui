@props([
    'title',
    'description' => null,
    'breadcrumbs' => [],
])

<header {{ $attributes->merge(['class' => 'flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between']) }}>
    <div>
        @if ($breadcrumbs)
            <x-laravel-admin::admin.breadcrumb :items="$breadcrumbs" class="mb-3" />
        @endif

        <h1 class="text-2xl font-bold text-base-content">{{ $title }}</h1>

        @if ($description)
            <p class="mt-2 max-w-2xl text-sm leading-6 text-base-content/70">{{ $description }}</p>
        @endif
    </div>

    @isset($actions)
        <div class="flex flex-wrap gap-2">
            {{ $actions }}
        </div>
    @endisset
</header>
