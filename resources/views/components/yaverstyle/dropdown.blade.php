@props(['align' => 'right', 'width' => '48', 'contentClasses' => null, 'dropdownClasses' => '', 'adaptive' => false])

@php
    $theme = app(\Ssh521\LaravelAdminUi\Contracts\StyleClassResolver::class);

    $alignmentClasses = match ($align) {
        'left' => 'ltr:origin-top-left rtl:origin-top-right start-0',
        'top' => 'origin-top',
        'none', 'false' => '',
        default => 'ltr:origin-top-right rtl:origin-top-left end-0',
    };

    $width = match ($width) {
        '36' => 'w-36',
        '40' => 'w-40',
        '44' => 'w-44',
        '48' => 'w-48',
        '60' => 'w-60',
        default => 'w-48',
    };

    $panelClasses = trim(implode(' ', [
        $adaptive ? 'absolute z-50' : $theme->classes('dropdown.panel'),
        $width,
        $alignmentClasses,
        $dropdownClasses,
    ]));

    $contentClasses = $contentClasses ?: $theme->classes('dropdown.content');
@endphp

<div
    class="{{ $theme->classes('dropdown.container') }}"
    x-data="{
        open: false,
        adaptive: @js((bool) $adaptive),
        dropUp: false,
        toggle() {
            this.open = ! this.open;

            if (this.open) {
                this.$nextTick(() => this.updatePlacement());
            }
        },
        updatePlacement() {
            if (! this.adaptive || ! this.$refs.trigger || ! this.$refs.panel) {
                return;
            }

            const gap = 12;
            const trigger = this.$refs.trigger.getBoundingClientRect();
            const panelHeight = this.$refs.panel.offsetHeight || 160;
            let boundaryTop = 0;
            let boundaryBottom = document.documentElement.clientHeight;
            let parent = this.$root.parentElement;

            while (parent) {
                const style = getComputedStyle(parent);
                const overflow = `${style.overflow} ${style.overflowY}`;

                if (/(auto|scroll|overlay)/.test(overflow) && parent.scrollHeight > parent.clientHeight) {
                    const boundary = parent.getBoundingClientRect();
                    boundaryTop = Math.max(boundaryTop, boundary.top);
                    boundaryBottom = Math.min(boundaryBottom, boundary.bottom);
                    break;
                }

                parent = parent.parentElement;
            }

            const spaceBelow = boundaryBottom - trigger.bottom;
            const spaceAbove = trigger.top - boundaryTop;

            this.dropUp = spaceBelow < panelHeight + gap && spaceAbove > spaceBelow;
        },
    }"
    @click.away="open = false"
    @close.stop="open = false"
    @resize.window="updatePlacement()"
    @scroll.window="updatePlacement()"
>
    <div x-ref="trigger" @click="toggle()">
        {{ $trigger }}
    </div>

    <div x-ref="panel"
            x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95"
            class="{{ $panelClasses }}"
            :class="adaptive ? (dropUp ? 'bottom-full mb-3 mt-0' : 'top-full mt-3 mb-0') : null"
            style="display: none;"
            @click="open = false">
        <div class="{{ $contentClasses }}">
            {{ $content }}
        </div>
    </div>
</div>
