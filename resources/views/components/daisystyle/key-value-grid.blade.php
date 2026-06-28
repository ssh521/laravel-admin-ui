@props([
    'items' => [],
])

<dl {{ $attributes->merge(['class' => 'divide-y divide-base-300']) }}>
    @foreach ($items as $key => $value)
        <div class="grid gap-1 px-4 py-4 sm:grid-cols-3 sm:gap-4 sm:px-6">
            <dt class="text-sm font-semibold text-base-content">{{ $key }}</dt>
            <dd class="text-sm text-base-content/70 sm:col-span-2">{{ $value }}</dd>
        </div>
    @endforeach

    {{ $slot }}
</dl>
