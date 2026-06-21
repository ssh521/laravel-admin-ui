@props([
    'title' => null,
    'description' => null,
])

<section {{ $attributes->merge(['class' => 'w-full bg-white px-2 py-2 dark:bg-gray-900']) }}>
    <div class="min-h-[560px] bg-white px-4 py-6 sm:px-6 lg:px-8 dark:bg-gray-900">
        @if ($title || $description || isset($actions))
            <div class="sm:flex sm:items-center sm:justify-between">
                <div class="sm:flex-auto">
                    @if ($title)
                        <h1 class="text-2xl font-semibold leading-7 text-gray-900 dark:text-white">{{ $title }}</h1>
                    @endif

                    @if ($description)
                        <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-600 dark:text-gray-400">{{ $description }}</p>
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
