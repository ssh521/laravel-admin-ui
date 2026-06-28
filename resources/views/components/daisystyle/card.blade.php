@props([
    'title' => null,
    'description' => null,
])

<section {{ $attributes->merge(['class' => 'card border border-base-300 bg-base-100 shadow-sm']) }}>
    @if ($title || $description || isset($actions))
        <header class="border-b border-base-300 px-5 py-4">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    @if ($title)
                        <h2 class="card-title text-base">{{ $title }}</h2>
                    @endif

                    @if ($description)
                        <p class="mt-1 text-sm text-base-content/70">{{ $description }}</p>
                    @endif
                </div>

                @isset($actions)
                    <div class="flex flex-wrap gap-2">
                        {{ $actions }}
                    </div>
                @endisset
            </div>
        </header>
    @endif

    <div class="card-body">
        {{ $slot }}
    </div>

    @isset($footer)
        <footer class="border-t border-base-300 px-5 py-4">
            {{ $footer }}
        </footer>
    @endisset
</section>
