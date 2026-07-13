@props([
    'title' => null,
    'description' => null,
])

<section {{ $attributes->merge(['class' => 'w-full bg-base-100 px-2 py-2']) }}>
    <div class="min-h-[560px] bg-base-100 px-4 py-6 sm:px-6 lg:px-8">
        @if ($title || $description || isset($actions))
            <div class="sm:flex sm:items-center sm:justify-between">
                <div class="sm:flex-auto">
                    @if ($title)
                        <h1 class="text-2xl font-bold text-base-content">{{ $title }}</h1>
                    @endif

                    @if ($description)
                        <p class="mt-2 max-w-2xl text-sm leading-6 text-base-content/70">{{ $description }}</p>
                    @endif
                </div>

                @isset($actions)
                    <div class="mt-4 flex flex-wrap gap-2 sm:mt-0 sm:ml-16 sm:flex-none">
                        {{ $actions }}
                    </div>
                @endisset
            </div>
        @endif

        {{ $slot }}
    </div>
</section>
