<div {{ $attributes->merge(['class' => 'overflow-hidden rounded-box border border-base-300 bg-base-100 shadow-sm']) }}>
    <div class="overflow-x-auto">
        {{ $slot }}
    </div>
</div>
