import { createDragHandler, createResizeHandler } from './modal-utils';

export default function modalStackModal(config = {}) {
    return {
        pos: { x: 0, y: 0 },
        size: { w: 576, h: 560 },
        minWidth: 320,
        minHeight: 220,
        draggable: true,
        resizable: true,
        isTop: true,
        previouslyFocusedElement: null,
        focusableSelector: [
            'a[href]',
            'button:not([disabled])',
            'input:not([disabled]):not([type="hidden"])',
            'select:not([disabled])',
            'textarea:not([disabled])',
            '[tabindex]:not([tabindex="-1"])'
        ].join(','),

        init() {
            this.minWidth = parseInt(config.minWidth) || 320;
            this.minHeight = parseInt(config.minHeight) || 220;
            this.size.w = this.clampWidth(parseInt(config.width) || 576);
            this.size.h = this.clampHeight(parseInt(config.height) || 560);
            this.draggable = config.draggable !== false;
            this.resizable = config.resizable !== false;
            this.isTop = config.isTop !== false;
            this.center();

            if (this.isTop) {
                this.previouslyFocusedElement = document.activeElement instanceof window.HTMLElement
                    ? document.activeElement
                    : null;
                this.$nextTick(() => this.focusModal());
            }
        },

        destroy() {
            const previouslyFocusedElement = this.previouslyFocusedElement;

            if (!previouslyFocusedElement || !previouslyFocusedElement.isConnected) {
                return;
            }

            window.requestAnimationFrame(() => {
                const activeTopModal = document.querySelector('[data-modal-stack-top] [role="dialog"]');

                if (activeTopModal && !activeTopModal.contains(previouslyFocusedElement)) {
                    return;
                }

                previouslyFocusedElement.focus({ preventScroll: true });
            });
        },

        focusModal() {
            const modal = this.$refs.modal;

            if (!modal) {
                return;
            }

            const autofocusElement = modal.querySelector('[autofocus], [data-modal-stack-autofocus]');
            (autofocusElement || modal).focus({ preventScroll: true });
        },

        focusableElements() {
            if (!this.$refs.modal) {
                return [];
            }

            return Array.from(this.$refs.modal.querySelectorAll(this.focusableSelector))
                .filter(element => element.offsetParent !== null && !element.closest('[inert]'));
        },

        trapFocus(event) {
            const modal = this.$refs.modal;
            const focusableElements = this.focusableElements();

            if (!modal || focusableElements.length === 0) {
                event.preventDefault();
                modal?.focus({ preventScroll: true });

                return;
            }

            const firstElement = focusableElements[0];
            const lastElement = focusableElements[focusableElements.length - 1];

            if (event.shiftKey && (document.activeElement === firstElement || document.activeElement === modal)) {
                event.preventDefault();
                lastElement.focus();
            } else if (!event.shiftKey && document.activeElement === lastElement) {
                event.preventDefault();
                firstElement.focus();
            }
        },

        get style() {
            return `top: ${this.pos.y}px; left: ${this.pos.x}px; width: ${this.size.w}px; height: ${this.size.h}px;`;
        },

        clampWidth(width) {
            return Math.max(this.minWidth, Math.min(width, window.innerWidth - 32));
        },

        clampHeight(height) {
            return Math.max(this.minHeight, Math.min(height, window.innerHeight - 32));
        },

        center() {
            this.pos.x = Math.max(16, Math.floor((window.innerWidth - this.size.w) / 2));
            this.pos.y = Math.max(16, Math.floor((window.innerHeight - this.size.h) / 2));
        },

        dragStart(event) {
            if (!this.draggable) {
                return;
            }

            createDragHandler({
                getPos: () => this.pos,
                setPos: (x, y) => {
                    this.pos.x = x;
                    this.pos.y = y;
                },
                getSize: () => this.size
            })(event);
        },

        resizeStart(event, direction = 'se') {
            if (!this.resizable) {
                return;
            }

            createResizeHandler({
                getPos: () => this.pos,
                setPos: (x, y) => {
                    this.pos.x = x;
                    this.pos.y = y;
                },
                getSize: () => this.size,
                setSize: (w, h) => {
                    this.size.w = w;
                    this.size.h = h;
                },
                minWidth: this.minWidth,
                minHeight: this.minHeight,
                maxWidth: window.innerWidth - 32,
                maxHeight: window.innerHeight - 32,
                direction
            })(event);
        }
    };
}
