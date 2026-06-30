<div>
    @foreach($modals as $index => $modal)
        <div
            wire:key="modal-stack-wrapper-{{ $modal['key'] }}"
            class="fixed inset-0 bg-black/50 dark:bg-black/70"
            style="z-index: {{ $this->zIndexFor($index) }};"
            x-data="modalStackModal({
                width: {{ $modal['width'] }},
                height: {{ $modal['height'] }},
                minWidth: {{ $modal['minWidth'] }},
                minHeight: {{ $modal['minHeight'] }},
                draggable: {{ $modal['draggable'] ? 'true' : 'false' }},
                resizable: {{ $modal['resizable'] ? 'true' : 'false' }}
            })"
            @if($loop->last)
                x-on:keydown.escape.window="$wire.closeTopModal()"
            @endif
            @if($modal['closeOnBackdrop'] && $loop->last)
                wire:click.self="closeTopModal"
            @endif
        >
            <section
                x-ref="modal"
                x-bind:style="style"
                class="absolute flex max-h-[calc(100vh-2rem)] max-w-[calc(100vw-2rem)] flex-col overflow-hidden rounded-lg border border-gray-200 bg-white shadow-xl dark:border-gray-700 dark:bg-gray-900"
                role="dialog"
                aria-modal="true"
                aria-labelledby="modal-stack-title-{{ $modal['id'] }}"
                wire:ignore.self
            >
                <header
                    class="flex shrink-0 select-none items-center justify-between gap-3 border-b border-gray-200 bg-gray-50 px-4 py-3 dark:border-gray-700 dark:bg-gray-800"
                    x-bind:class="{ 'cursor-move': draggable }"
                    x-on:mousedown.stop="dragStart"
                    x-on:touchstart.stop="dragStart"
                    data-modal-stack-drag-handle
                >
                    <h2 id="modal-stack-title-{{ $modal['id'] }}" class="min-w-0 truncate text-sm font-semibold text-gray-900 dark:text-white">
                        {{ $modal['title'] }}
                    </h2>

                    <button
                        type="button"
                        class="inline-flex size-8 cursor-pointer items-center justify-center rounded-md text-gray-500 hover:bg-gray-200 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white"
                        wire:click="closeModal('{{ $modal['id'] }}')"
                        aria-label="닫기"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </header>

                <div class="min-h-0 flex-1 overflow-y-auto text-sm text-gray-900 dark:text-gray-100">
                    @livewire($modal['component'], $modal['params'], key($modal['key']))
                </div>

                @if($modal['resizable'])
                    <div
                        class="absolute bottom-0 right-0 z-10 hidden h-6 w-6 cursor-se-resize touch-none items-center justify-center text-gray-400 hover:text-gray-700 sm:flex dark:text-gray-500 dark:hover:text-gray-200"
                        x-on:mousedown.stop.prevent="resizeStart($event, 'se')"
                        x-on:touchstart.stop.prevent="resizeStart($event, 'se')"
                        data-modal-stack-resize-handle
                    >
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M22 22H20V20H22V22ZM22 18H20V16H22V18ZM18 22H16V20H18V22ZM18 18H16V16H18V18ZM14 22H12V20H14V22ZM22 14H20V12H22V14Z" />
                        </svg>
                    </div>
                @endif
            </section>
        </div>
    @endforeach
</div>
