@props([
    'title' => null,
    'description' => null,
])

<section {{ $attributes->merge(['class' => 'w-full bg-base-100 px-2 py-2']) }}>
    <div class="min-h-[560px] px-4 py-6 sm:px-6 lg:px-8">
        <div class="card bg-base-100 shadow-sm">
            <div class="card-body">
                @if ($title || $description || isset($actions))
                    <div class="sm:flex sm:items-center sm:justify-between">
                        <div class="sm:flex-auto">
                            @if ($title)
                                <h1 class="card-title text-2xl">{{ $title }}</h1>
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
        </div>
    </div>
</section>
