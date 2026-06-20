@props([
    'title' => null,
    'description' => null,
])

<section {{ $attributes->merge(['class' => 'rounded-xl border border-neutral-200 bg-white shadow-sm']) }}>
    @if ($title || $description || isset($actions))
        <header class="flex flex-col gap-3 border-b border-neutral-200 p-4 md:flex-row md:items-center md:justify-between">
            <div>
                @if ($title)
                    <h2 class="text-lg font-semibold text-neutral-900">{{ $title }}</h2>
                @endif

                @if ($description)
                    <p class="mt-1 text-sm text-neutral-500">{{ $description }}</p>
                @endif
            </div>

            @isset($actions)
                <div class="flex flex-wrap items-center gap-2">
                    {{ $actions }}
                </div>
            @endisset
        </header>
    @endif

    @isset($filters)
        <div class="border-b border-neutral-200 bg-neutral-50 p-4">
            <div class="grid grid-cols-1 gap-3 md:grid-cols-3">
                {{ $filters }}
            </div>
        </div>
    @endisset

    <div>
        {{ $slot }}
    </div>

    @isset($footer)
        <footer class="flex justify-end gap-2 border-t border-neutral-200 p-4">
            {{ $footer }}
        </footer>
    @endisset
</section>
