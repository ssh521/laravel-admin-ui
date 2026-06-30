import { createDragHandler, createResizeHandler } from './modal-utils';

export default function modalStackModal(config = {}) {
    return {
        pos: { x: 0, y: 0 },
        size: { w: 576, h: 560 },
        minWidth: 320,
        minHeight: 220,
        draggable: true,
        resizable: true,

        init() {
            this.minWidth = parseInt(config.minWidth) || 320;
            this.minHeight = parseInt(config.minHeight) || 220;
            this.size.w = this.clampWidth(parseInt(config.width) || 576);
            this.size.h = this.clampHeight(parseInt(config.height) || 560);
            this.draggable = config.draggable !== false;
            this.resizable = config.resizable !== false;
            this.center();
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
