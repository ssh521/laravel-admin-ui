@props([
    'title' => null,
    'description' => null,
    'icon' => null,
])

<div {{ $attributes->merge(['class' => 'alert flex flex-col items-center justify-center border border-base-300 bg-base-200 px-6 py-16 text-center']) }}>
    @if ($icon)
        <x-laravel-admin::admin.icon :name="$icon" class="size-10 text-base-content/50" />
    @endif

    @if ($title)
        <h3 class="text-base font-semibold text-base-content">{{ $title }}</h3>
    @endif

    @if ($description)
        <p class="text-sm text-base-content/70">{{ $description }}</p>
    @else
        <div class="text-sm text-base-content/70">
            {{ $slot }}
        </div>
    @endif
</div>
