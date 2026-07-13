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

    $panelClasses = trim(implode(' ', array_filter([
        $adaptive ? 'fixed z-[70]' : $theme->classes('dropdown.panel'),
        $width,
        $adaptive ? null : $alignmentClasses,
        $dropdownClasses,
    ])));

    $contentClasses = $contentClasses ?: $theme->classes('dropdown.content');
@endphp

<div
    class="{{ $theme->classes('dropdown.container') }}"
    x-data="{
        open: false,
        adaptive: @js((bool) $adaptive),
        align: @js($align),
        dropUp: false,
        panelStyle: '',
        toggle() {
            this.open = ! this.open;

            if (this.open) {
                this.$nextTick(() => this.updatePlacement());
            }
        },
        close(restoreFocus = false) {
            this.open = false;

            if (restoreFocus) {
                this.$nextTick(() => this.$refs.trigger?.querySelector('button, a, [tabindex]')?.focus());
            }
        },
        updatePlacement() {
            if (! this.open || ! this.adaptive || ! this.$refs.trigger || ! this.$refs.panel) {
                return;
            }

            const gap = 12;
            const viewportPadding = 8;
            const trigger = this.$refs.trigger.getBoundingClientRect();
            const panelHeight = this.$refs.panel.offsetHeight || 160;
            const panelWidth = this.$refs.panel.offsetWidth || 144;
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

            const top = this.dropUp
                ? Math.max(viewportPadding, trigger.top - panelHeight - gap)
                : Math.min(document.documentElement.clientHeight - viewportPadding - panelHeight, trigger.bottom + gap);
            const preferredLeft = this.align === 'left'
                ? trigger.left
                : trigger.right - panelWidth;
            const left = Math.min(
                Math.max(viewportPadding, preferredLeft),
                document.documentElement.clientWidth - viewportPadding - panelWidth
            );

            this.panelStyle = `top: ${top}px; left: ${left}px;`;
        },
    }"
    @click.away="close()"
    @close.stop="close()"
    @keydown.escape.stop.prevent="close(true)"
    @admin:dropdown-close-all.window="close()"
    @resize.window="open && updatePlacement()"
    @scroll.window="open && updatePlacement()"
>
    <div x-ref="trigger" @click="toggle()">
        {{ $trigger }}
    </div>

    <div x-ref="panel"
            x-cloak
            x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95"
            class="{{ $panelClasses }}"
            :class="adaptive ? (dropUp ? 'origin-bottom-right' : 'origin-top-right') : null"
            :style="adaptive ? panelStyle : null"
            style="display: none;"
            @click="open = false">
        <div class="{{ $contentClasses }}">
            {{ $content }}
        </div>
    </div>
</div>
