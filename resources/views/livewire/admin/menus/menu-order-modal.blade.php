<div id="menu-order-modal-content" class="p-4" x-data>
    {{-- 카테고리명 표시 --}}
    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
        메뉴 순서 변경@if($categoryName) - {{ $categoryName }}@endif
    </h3>
    
    {{-- 사용 안내 메시지 --}}
    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
        드래그하여 메뉴 순서를 변경한 뒤 순서 저장하기 버튼을 눌러 저장합니다.
    </p>

    <div
        id="menu-order-save-status"
        class="mb-4 hidden items-center gap-2 rounded-md border border-blue-200 bg-blue-50 px-3 py-2 text-sm text-blue-700 dark:border-blue-500/30 dark:bg-blue-500/10 dark:text-blue-300"
        role="status"
        aria-live="polite"
    >
        <div class="h-4 w-4 animate-spin rounded-full border-2 border-blue-200 border-t-blue-600 dark:border-blue-500/30 dark:border-t-blue-300"></div>
        <span>메뉴 순서를 저장하는 중입니다.</span>
    </div>

    <div
        id="menu-order-dirty-status"
        class="mb-4 hidden rounded-md border border-amber-200 bg-amber-50 px-3 py-2 text-sm text-amber-800 dark:border-amber-500/30 dark:bg-amber-500/10 dark:text-amber-300"
        role="status"
        aria-live="polite"
    >
        변경된 순서가 아직 저장되지 않았습니다.
    </div>
    
    {{-- 로딩 스피너 --}}
    @if($isLoading)
    <div class="flex justify-center items-center py-8">
        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
    </div>
    @endif

    {{-- 드래그 가능한 메뉴 리스트 --}}
    @if(!$isLoading && count($menus) > 0)
    <div
        id="menu-list-sortable"
        data-livewire-id="{{ $this->getId() }}"
        data-category-id="{{ $categoryId }}"
        class="space-y-2"
    >
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
        <button
            id="menu-order-save-button"
            type="button"
            class="inline-flex h-10 cursor-pointer items-center justify-center rounded-md bg-indigo-600 px-4 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 disabled:cursor-not-allowed disabled:bg-indigo-300 disabled:opacity-60 dark:bg-indigo-500 dark:hover:bg-indigo-400 dark:disabled:bg-indigo-900">
            순서 저장하기
        </button>
        <x-laravel-admin::admin.secondary-button
            type="button"
            @click="$dispatch('close-modal', { modalId: 'menu-order-modal' })">
            닫기
        </x-laravel-admin::admin.secondary-button>
    </div>

    <script>
        function setMenuOrderSaving(isSaving) {
            const status = document.getElementById('menu-order-save-status');
            const menuContainer = document.getElementById('menu-list-sortable');
            const saveButton = document.getElementById('menu-order-save-button');

            if (status) {
                status.classList.toggle('hidden', !isSaving);
                status.classList.toggle('flex', isSaving);
            }

            if (menuContainer) {
                menuContainer.classList.toggle('pointer-events-none', isSaving);
                menuContainer.classList.toggle('opacity-70', isSaving);
            }

            if (saveButton) {
                saveButton.disabled = isSaving;
            }
        }

        function setMenuOrderDirty(isDirty) {
            const status = document.getElementById('menu-order-dirty-status');
            const saveButton = document.getElementById('menu-order-save-button');

            window.menuOrderDirty = isDirty;

            if (status) {
                status.classList.toggle('hidden', !isDirty);
            }

            if (saveButton) {
                saveButton.disabled = false;
            }
        }

        function showMenuOrderNotification(message, type = 'success') {
            const notification = document.createElement('div');
            const variantClass = {
                success: 'bg-green-500 text-white',
                info: 'bg-blue-500 text-white',
                error: 'bg-red-500 text-white'
            }[type] || 'bg-red-500 text-white';

            notification.className = `fixed top-4 right-4 z-[9999] rounded-md px-4 py-3 text-sm font-medium shadow-lg ${variantClass}`;
            notification.textContent = message;
            document.body.appendChild(notification);

            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

        window.showMenuOrderNotification = showMenuOrderNotification;

        function captureMenuOrder(menuContainer) {
            return Array.from(menuContainer.querySelectorAll('[data-menu-id]'))
                .map(item => item.dataset.menuId);
        }

        function buildMenuOrderPayload(menuContainer) {
            return Array.from(menuContainer.querySelectorAll('[data-menu-id]')).map((item, index) => ({
                id: parseInt(item.dataset.menuId),
                sort_order: index
            }));
        }

        function hasMenuOrderChanged(menuContainer) {
            if (!menuContainer) {
                return false;
            }

            const savedOrder = menuContainer.dataset.savedOrder || '[]';

            return JSON.stringify(captureMenuOrder(menuContainer)) !== savedOrder;
        }

        function restoreMenuOrder(menuContainer, order) {
            if (!menuContainer || order.length === 0) {
                return;
            }

            order.forEach(menuId => {
                const item = menuContainer.querySelector(`[data-menu-id="${menuId}"]`);

                if (item) {
                    menuContainer.appendChild(item);
                }
            });
        }

        function refreshMenuDraggableItems(menuContainer) {
            if (!menuContainer) {
                return;
            }

            menuContainer.querySelectorAll('[data-menu-id]').forEach(item => {
                item.draggable = true;
            });
        }

        function dispatchMenuOrderUpdate(categoryId, newOrder) {
            if (window.Livewire && typeof window.Livewire.dispatch === 'function') {
                window.Livewire.dispatch('admin-menus:menu-order-modal:update-order', {
                    data: {
                        categoryId: categoryId,
                        newOrder: newOrder
                    }
                });

                return;
            }

            throw new Error('Livewire dispatch is not available');
        }

        window.pendingMenuOrderChange = null;
        window.menuOrderDirty = false;

        function initMenuNativeDrag() {
            const menuContainer = document.getElementById('menu-list-sortable');
            if (!menuContainer || menuContainer.dataset.nativeSortInitialized === 'true') {
                return;
            }

            const categoryId = Number(menuContainer.dataset.categoryId);
            if (!categoryId) return;

            menuContainer.dataset.nativeSortInitialized = 'true';
            menuContainer.dataset.savedOrder = JSON.stringify(captureMenuOrder(menuContainer));
            let draggedItem = null;

            refreshMenuDraggableItems(menuContainer);
            setMenuOrderDirty(false);

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
                setMenuOrderDirty(hasMenuOrderChanged(menuContainer));
            });

            menuContainer.addEventListener('drop', event => {
                event.preventDefault();

                if (!draggedItem) {
                    return;
                }

                draggedItem.classList.remove('sortable-ghost');
                draggedItem = null;

                setMenuOrderDirty(hasMenuOrderChanged(menuContainer));
            });

            menuContainer.addEventListener('dragend', () => {
                if (draggedItem) {
                    draggedItem.classList.remove('sortable-ghost');
                }

                draggedItem = null;
                setMenuOrderDirty(hasMenuOrderChanged(menuContainer));
                refreshMenuDraggableItems(menuContainer);
            });

            const saveButton = document.getElementById('menu-order-save-button');
            if (saveButton && saveButton.dataset.listenerRegistered !== 'true') {
                saveButton.dataset.listenerRegistered = 'true';
                saveButton.addEventListener('click', () => {
                    const hasChanges = hasMenuOrderChanged(menuContainer);

                    if (!hasChanges) {
                        setMenuOrderDirty(false);
                        showMenuOrderNotification('변경된 순서가 없습니다.', 'info');
                        return;
                    }

                    const savedOrder = menuContainer.dataset.savedOrder
                        ? JSON.parse(menuContainer.dataset.savedOrder)
                        : captureMenuOrder(menuContainer);

                    setMenuOrderSaving(true);

                    window.pendingMenuOrderChange = {
                        originalOrder: savedOrder
                    };

                    try {
                        dispatchMenuOrderUpdate(categoryId, buildMenuOrderPayload(menuContainer));
                    } catch (error) {
                        console.error('Menu order update failed:', error);
                        restoreMenuOrder(menuContainer, savedOrder);
                        showMenuOrderNotification('메뉴 순서 저장 중 오류가 발생했습니다.', 'error');
                        window.pendingMenuOrderChange = null;
                        setMenuOrderSaving(false);
                        setMenuOrderDirty(false);
                        refreshMenuDraggableItems(menuContainer);
                    }
                });
            }
        }

        // Livewire 컴포넌트가 업데이트될 때마다 native drag 초기화
        document.addEventListener('livewire:init', () => {
            if (!window.menuOrderNotificationListenerRegistered) {
                window.menuOrderNotificationListenerRegistered = true;

                Livewire.on('admin-menus:menu-order-modal:notification', (data) => {
                    const menuContainer = document.getElementById('menu-list-sortable');
                    const pendingChange = window.pendingMenuOrderChange;
                    const type = data.type || 'success';

                    if (menuContainer) {
                        if (type === 'success') {
                            menuContainer.dataset.savedOrder = JSON.stringify(captureMenuOrder(menuContainer));
                            setMenuOrderDirty(false);
                        } else if (pendingChange) {
                            restoreMenuOrder(menuContainer, pendingChange.originalOrder);
                            setMenuOrderDirty(false);
                        }
                    }

                    showMenuOrderNotification(data.message || '메뉴 순서가 저장되었습니다.', type);
                    window.pendingMenuOrderChange = null;
                    setMenuOrderSaving(false);
                    refreshMenuDraggableItems(menuContainer);
                });
            }

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
