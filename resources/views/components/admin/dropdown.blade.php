@props(['align' => 'right', 'width' => '48', 'contentClasses' => null, 'dropdownClasses' => ''])

@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\ThemeContract::class);

    $alignmentClasses = match ($align) {
        'left' => 'ltr:origin-top-left rtl:origin-top-right start-0',
        'top' => 'origin-top',
        'none', 'false' => '',
        default => 'ltr:origin-top-right rtl:origin-top-left end-0',
    };

    $width = match ($width) {
        '48' => 'w-48',
        '60' => 'w-60',
        default => 'w-48',
    };

    $panelClasses = trim(implode(' ', [
        $theme->classes('dropdown.panel'),
        $width,
        $alignmentClasses,
        $dropdownClasses,
    ]));

    $contentClasses = $contentClasses ?: $theme->classes('dropdown.content');
@endphp

<div class="{{ $theme->classes('dropdown.container') }}" x-data="{ open: false }" @click.away="open = false" @close.stop="open = false">
    <div @click="open = ! open">
        {{ $trigger }}
    </div>

    <div x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95"
            class="{{ $panelClasses }}"
            style="display: none;"
            @click="open = false">
        <div class="{{ $contentClasses }}">
            {{ $content }}
        </div>
    </div>
</div>
