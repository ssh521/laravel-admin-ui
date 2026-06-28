@props([
    'label',
    'value',
    'description' => null,
])

<section {{ $attributes->merge(['class' => 'stat rounded-box border border-base-300 bg-base-100 shadow-sm']) }}>
    <p class="stat-title">{{ $label }}</p>
    <p class="stat-value text-primary">{{ $value }}</p>

    @if ($description)
        <p class="stat-desc">{{ $description }}</p>
    @endif
</section>
