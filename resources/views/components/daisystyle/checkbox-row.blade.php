@props([
    'for' => null,
    'title' => null,
    'description' => null,
])

<label @if($for) for="{{ $for }}" @endif {{ $attributes->merge(['class' => 'flex min-h-12 cursor-pointer items-start gap-3 rounded-box border border-base-300 bg-base-100 p-4 shadow-sm transition hover:bg-base-200']) }}>
    {{ $slot }}

    @if ($title || $description)
        <span>
            @if ($title)
                <span class="block text-sm font-semibold text-base-content">{{ $title }}</span>
            @endif

            @if ($description)
                <span class="block text-sm text-base-content/70">{{ $description }}</span>
            @endif
        </span>
    @endif
</label>
