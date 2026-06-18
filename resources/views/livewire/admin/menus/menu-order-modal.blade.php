<div class="p-4" x-data>
    {{-- 카테고리명 표시 --}}
    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
        메뉴 순서 변경@if($categoryName) - {{ $categoryName }}@endif
    </h3>
    
    {{-- 사용 안내 메시지 --}}
    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
        드래그하여 메뉴 순서를 변경하면 자동으로 저장됩니다.
    </p>
    
    {{-- 로딩 스피너 --}}
    @if($isLoading)
    <div class="flex justify-center items-center py-8">
        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
    </div>
    @endif

    {{-- 드래그 가능한 메뉴 리스트 --}}
    @if(!$isLoading && count($menus) > 0)
    <div id="menu-list-sortable" data-livewire-id="{{ $this->getId() }}" class="space-y-2">
        @foreach($menus as $index => $menu)
        <div 
            wire:key="menu-{{ $menu['id'] }}"
            class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600 menu-item cursor-move hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors"
            data-menu-id="{{ $menu['id'] }}"
            data-sort-order="{{ $menu['sort_order'] }}">
            <div class="flex items-center flex-1">
                <div class="flex-shrink-0 mr-3 drag-handle pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <div class="flex items-center">
                        @if($menu['icon'])
                        <x-laravel-admin::admin.icon :name="$menu['icon']" class="mr-2 text-blue-500" />
                        @endif
                        <span class="font-medium text-gray-900 dark:text-white">{{ $menu['name'] }}</span>
                        @if(!$menu['is_active'])
                        <span class="ml-2 px-2 py-1 text-xs bg-red-100 text-red-800 rounded-full">비활성</span>
                        @endif
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        순서: {{ $menu['sort_order'] }}
                    </div>
                </div>
                <div class="flex-shrink-0 ml-2">
                    <button
                        type="button"
                        @click.stop="
                            $dispatch('close-modal', { modalId: 'menu-order-modal' });
                            setTimeout(() => {
                                window.location.href = '{{ route('admin.menus.edit', ['menu' => $menu['id']]) }}';
                            }, 100);
                        "
                        class="cursor-pointer px-3 py-1.5 text-xs font-medium text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/30 rounded-md transition-colors"
                        title="메뉴 수정">
                        수정
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    {{-- 빈 상태 메시지 --}}
    @if(!$isLoading && count($menus) === 0)
    <div class="text-center py-8 text-gray-500 dark:text-gray-400">
        이 카테고리에 등록된 메뉴가 없습니다.
    </div>
    @endif

    {{-- 모달 푸터 버튼들 --}}
    <div class="flex justify-end space-x-3 mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
        <x-laravel-admin::admin.primary-button
            type="button"
            @click="$dispatch('close-modal', { modalId: 'menu-order-modal' })">
            닫기
        </x-laravel-admin::admin.primary-button>
    </div>

    <script>
        function updateMenuOrderFromNativeDrag(newOrder, livewireId) {
            // Livewire 3 방식으로 호출
            if (window.Livewire && livewireId) {
                const component = window.Livewire.find(livewireId);
                if (component) {
                    component.call('updateOrder', newOrder);
                } else {
                    console.warn('Livewire component not found:', livewireId);
                }
            } else {
                console.error('Livewire not available or livewire-id missing');
            }
        }

        function initMenuNativeDrag() {
            const menuContainer = document.getElementById('menu-list-sortable');
            if (!menuContainer || menuContainer.dataset.nativeSortInitialized === 'true') {
                return;
            }

            const livewireId = menuContainer.dataset.livewireId;
            if (!livewireId) return;

            menuContainer.dataset.nativeSortInitialized = 'true';
            let draggedItem = null;

            const refreshDraggableItems = () => {
                menuContainer.querySelectorAll('[data-menu-id]').forEach(item => {
                    item.draggable = true;
                });
            };

            refreshDraggableItems();

            menuContainer.addEventListener('dragstart', event => {
                const item = event.target.closest('[data-menu-id]');

                if (!item || event.target.closest('button')) {
                    event.preventDefault();
                    return;
                }

                draggedItem = item;
                item.classList.add('sortable-ghost');
                event.dataTransfer.effectAllowed = 'move';
                event.dataTransfer.setData('text/plain', item.dataset.menuId);
            });

            menuContainer.addEventListener('dragover', event => {
                const item = event.target.closest('[data-menu-id]');

                if (!draggedItem || !item || draggedItem === item) {
                    return;
                }

                event.preventDefault();
                const rect = item.getBoundingClientRect();
                const shouldInsertAfter = event.clientY > rect.top + rect.height / 2;
                menuContainer.insertBefore(draggedItem, shouldInsertAfter ? item.nextSibling : item);
            });

            menuContainer.addEventListener('drop', event => {
                event.preventDefault();

                if (!draggedItem) {
                    return;
                }

                draggedItem.classList.remove('sortable-ghost');
                draggedItem = null;

                const items = Array.from(menuContainer.querySelectorAll('[data-menu-id]'));
                const newOrder = items.map((item, index) => ({
                    id: parseInt(item.dataset.menuId),
                    sort_order: index
                }));

                updateMenuOrderFromNativeDrag(newOrder, livewireId);
            });

            menuContainer.addEventListener('dragend', () => {
                if (draggedItem) {
                    draggedItem.classList.remove('sortable-ghost');
                }

                draggedItem = null;
                refreshDraggableItems();
            });
        }

        // Livewire 컴포넌트가 업데이트될 때마다 native drag 초기화
        document.addEventListener('livewire:init', () => {
            Livewire.hook('morph.updated', ({ el, component }) => {
                if (el.querySelector('#menu-list-sortable')) {
                    setTimeout(() => {
                        initMenuNativeDrag();
                    }, 100);
                }
            });
        });

        // 모달이 열릴 때 초기화
        window.addEventListener('opened-modal', function(event) {
            if (event.detail.modalId === 'menu-order-modal') {
                setTimeout(() => {
                    initMenuNativeDrag();
                }, 200);
            }
        });

        // 초기 마운트 시 초기화 시도
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => {
                setTimeout(() => {
                    initMenuNativeDrag();
                }, 300);
            });
        } else {
            setTimeout(() => {
                initMenuNativeDrag();
            }, 300);
        }
    </script>

    <!-- Native drag and drop style -->
    <style>
        .sortable-ghost {
            opacity: 0.5;
            background-color: #f3f4f6 !important;
        }

        .sortable-chosen {
            background-color: #dbeafe !important;
        }

        .sortable-drag {
            background-color: #ffffff !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .drag-handle {
            cursor: grab;
            color: #6b7280;
            transition: color 0.2s;
        }

        .drag-handle:hover {
            color: #374151;
        }

        .drag-handle:active {
            cursor: grabbing;
        }
    </style>
</div>
