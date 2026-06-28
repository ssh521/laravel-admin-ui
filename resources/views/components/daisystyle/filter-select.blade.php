@props([
    'name',
    'label' => null,
    'options' => [],
    'selected' => null,
    'placeholder' => null,
])

<label {{ $attributes->merge(['class' => 'flex min-w-0 flex-col gap-1']) }}>
    @if ($label)
        <span class="text-xs font-semibold text-base-content/70">{{ $label }}</span>
    @endif

    <select name="{{ $name }}" class="select select-bordered w-full">
        @if ($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif

        @foreach ($options as $value => $optionLabel)
            <option value="{{ $value }}" @selected((string) $selected === (string) $value)>{{ $optionLabel }}</option>
        @endforeach

        {{ $slot }}
    </select>
</label>
