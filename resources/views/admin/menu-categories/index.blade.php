<x-laravel-admin::admin.layouts.admin title="메뉴 카테고리 관리">
    <x-slot name="header">
        <x-laravel-admin::admin.admin-header>
            <x-slot name="navigation">
                <a href="{{ route('admin.index') }}">관리자 홈</a>
                - <a href="{{ route('admin.menu-categories.index') }}">메뉴 카테고리 관리</a>
            </x-slot>
            <x-slot name="description">
                {{ __('메뉴 카테고리') }}
            </x-slot>
        </x-laravel-admin::admin.admin-header>
    </x-slot>

    <style>
        .drag-handle {
            cursor: grab;
        }

        .drag-handle:active {
            cursor: grabbing;
        }

        .sortable-ghost {
            opacity: 0.5;
            background-color: rgb(243 244 246) !important;
        }

        .sortable-chosen {
            background-color: rgb(238 242 255) !important;
        }

        .sortable-drag {
            background-color: #ffffff !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
    </style>

    @php
        $currentSort = $sort ?? request('sort', 'sort_order');
        $currentDirection = ($direction ?? request('direction', 'asc')) === 'desc' ? 'desc' : 'asc';
        $getNextDirection = fn (string $field): string => $currentSort === $field && $currentDirection === 'asc' ? 'desc' : 'asc';
        $sortLinkClass = 'inline-flex items-center justify-center gap-1 !text-gray-900 hover:!text-indigo-600 hover:no-underline dark:!text-white dark:hover:!text-indigo-400';
        $renderSortIcon = function (string $field) use ($currentSort, $currentDirection) {
            if ($currentSort !== $field) {
                return '<svg xmlns="http://www.w3.org/2000/svg" class="size-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7l4-4 4 4M16 17l-4 4-4-4" /></svg>';
            }

            return $currentDirection === 'asc'
                ? '<svg xmlns="http://www.w3.org/2000/svg" class="size-3" viewBox="0 0 20 20" fill="currentColor" aria-label="오름차순"><path fill-rule="evenodd" d="M3.293 12.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L10 7.414l-5.293 5.293a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>'
                : '<svg xmlns="http://www.w3.org/2000/svg" class="size-3" viewBox="0 0 20 20" fill="currentColor" aria-label="내림차순"><path fill-rule="evenodd" d="M16.707 7.293a1 1 0 010 1.414l-6 6a1 1 0 01-1.414 0l-6-6A1 1 0 014.707 7.293L10 12.586l5.293-5.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>';
        };
    @endphp

    <div class="w-full bg-white px-2 py-2 dark:bg-gray-900">
        <div class="min-h-[560px] bg-white px-4 py-6 sm:px-6 lg:px-8 dark:bg-gray-900">
            <div class="sm:flex sm:items-start sm:justify-between">
                <div class="sm:flex-auto">
                    <h1 class="text-2xl font-semibold leading-7 text-gray-900 dark:text-white">{{ __('메뉴 카테고리 목록') }}</h1>
                    <p class="mt-2 text-sm leading-6 text-gray-600 dark:text-gray-400">
                        @if(request('search'))
                            "{{ request('search') }}" {{ __('검색 결과입니다.') }}
                        @else
                            {{ __('메뉴 카테고리의 순서, 상태, 허용 역할을 관리합니다.') }}
                        @endif
                    </p>
                </div>
                <div class="mt-4 flex flex-wrap gap-2 sm:mt-0 sm:ml-6">
                    @can('create', Ssh521\LaravelAdmin\Models\MenuCategory::class)
                        <x-laravel-admin::admin.action-button :href="route('admin.menu-categories.create')" size="sm" icon="plus">
                            {{ __('등록하기') }}
                        </x-laravel-admin::admin.action-button>
                    @endcan
                </div>
            </div>

            <x-laravel-admin::admin.session-messages />

            <x-laravel-admin::admin.filter-bar action="{{ route('admin.menu-categories.index') }}">
                @if(request('sort'))
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                @endif
                @if(request('direction'))
                    <input type="hidden" name="direction" value="{{ request('direction') }}">
                @endif
                <label for="category-search" class="sr-only">Search</label>
                <div class="relative min-w-0 flex-1">
                    <x-laravel-admin::admin.form-input
                        id="category-search"
                        name="search"
                        value="{{ request('search') }}"
                        class="w-full h-10 pr-9"
                        placeholder="{{ __('카테고리 검색') }}"
                    />
                    @if(request('search'))
                        <a href="{{ route('admin.menu-categories.index') }}"
                           class="absolute right-3 top-1/2 -translate-y-1/2 !text-gray-400 hover:!text-gray-600 hover:no-underline dark:hover:!text-gray-300">
                            <x-laravel-admin::admin.icon name="xmark" class="text-sm" />
                        </a>
                    @endif
                </div>

                <x-laravel-admin::admin.action-button type="submit" variant="search" icon="magnifying-glass" class="w-full shrink-0 whitespace-nowrap sm:w-auto">
                    {{ __('검색') }}
                </x-laravel-admin::admin.action-button>
            </x-laravel-admin::admin.filter-bar>

            <div class="mt-6 flow-root" x-data="menuCategoryDragSort()" x-init="initNativeDrag()">
                <div class="-mx-4 overflow-x-auto sm:min-h-64 sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="border-y border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-800/80">
                                <tr>
                                    <th scope="col" class="py-3 pr-3 pl-4 text-left text-sm font-semibold text-gray-900 sm:pl-0 dark:text-white">
                                        <span class="sr-only">순서</span>
                                    </th>
                                    <th scope="col" class="px-3 py-3 text-center text-sm font-semibold text-gray-900 dark:text-white">
                                        <a href="{{ route('admin.menu-categories.index', array_merge(request()->query(), ['sort' => 'name', 'direction' => $getNextDirection('name')])) }}" class="{{ $sortLinkClass }}">
                                            <span>{{ __('카테고리명') }}</span>
                                            {!! $renderSortIcon('name') !!}
                                        </a>
                                    </th>
                                    <th scope="col" class="hidden px-3 py-3 text-center text-sm font-semibold text-gray-900 md:table-cell dark:text-white">
                                        <a href="{{ route('admin.menu-categories.index', array_merge(request()->query(), ['sort' => 'menus_count', 'direction' => $getNextDirection('menus_count')])) }}" class="{{ $sortLinkClass }}">
                                            <span>{{ __('메뉴 개수') }}</span>
                                            {!! $renderSortIcon('menus_count') !!}
                                        </a>
                                    </th>
                                    <th scope="col" class="px-3 py-3 text-center text-sm font-semibold text-gray-900 dark:text-white">
                                        <a href="{{ route('admin.menu-categories.index', array_merge(request()->query(), ['sort' => 'is_active', 'direction' => $getNextDirection('is_active')])) }}" class="{{ $sortLinkClass }}">
                                            <span>{{ __('상태') }}</span>
                                            {!! $renderSortIcon('is_active') !!}
                                        </a>
                                    </th>
                                    <th scope="col" class="hidden px-3 py-3 text-center text-sm font-semibold text-gray-900 xl:table-cell dark:text-white">{{ __('허용 역할') }}</th>
                                    <th scope="col" class="px-3 py-3 text-center text-sm font-semibold text-gray-900 dark:text-white">{{ __('권한 수정') }}</th>
                                    <th scope="col" class="hidden px-3 py-3 text-center text-sm font-semibold text-gray-900 lg:table-cell dark:text-white">
                                        <a href="{{ route('admin.menu-categories.index', array_merge(request()->query(), ['sort' => 'created_at', 'direction' => $getNextDirection('created_at')])) }}" class="{{ $sortLinkClass }}">
                                            <span>{{ __('생성일') }}</span>
                                            {!! $renderSortIcon('created_at') !!}
                                        </a>
                                    </th>
                                    <th scope="col" class="relative py-3 pr-4 pl-3 sm:pr-0">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="categories-tbody" class="divide-y divide-gray-100 dark:divide-gray-800">
                                @forelse($categories as $category)
                                    <tr data-category-id="{{ $category->id }}"
                                        class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-800/70"
                                        @dragover.prevent="dragOver($event)"
                                        @drop.prevent="dropRow()"
                                        @dragend="endDrag()">
                                        <td class="whitespace-nowrap py-3 pr-3 pl-4 text-sm sm:pl-0">
                                            <div class="drag-handle inline-flex size-8 items-center justify-center rounded-md text-gray-400 hover:bg-gray-100 hover:text-gray-600 dark:hover:bg-gray-800 dark:hover:text-gray-300"
                                                 :draggable="sortMode === 'drag'"
                                                 @dragstart="startDrag($event)"
                                                 aria-label="순서 변경">
                                                <x-laravel-admin::admin.icon name="grip-lines" />
                                            </div>
                                        </td>
                                        <td class="px-3 py-3 text-sm">
                                            @can('view', $category)
                                                <button
                                                    type="button"
                                                    class="inline-flex cursor-pointer items-center font-semibold text-gray-900 hover:text-indigo-600 dark:text-white dark:hover:text-indigo-400"
                                                    data-menu-order-category-id="{{ $category->id }}"
                                                    data-menu-order-category-name="{{ $category->name }}">
                                                    {{ $category->name }}
                                                </button>
                                            @else
                                                <span class="font-semibold text-gray-900 dark:text-white">{{ $category->name }}</span>
                                            @endcan
                                            <div class="mt-0.5 flex flex-wrap items-center gap-1.5 text-xs text-gray-500 md:hidden dark:text-gray-400">
                                                <span>{{ $category->menus_count }} {{ __('menus') }}</span>
                                            </div>
                                        </td>
                                        <td class="hidden whitespace-nowrap px-3 py-3 text-center text-sm text-gray-600 md:table-cell dark:text-gray-300">{{ $category->menus_count }}</td>
                                        <td class="whitespace-nowrap px-3 py-3 text-center text-sm">
                                            <x-laravel-admin::admin.badge variant="{{ $category->is_active ? 'success' : 'danger' }}">
                                                {{ $category->is_active ? __('활성') : __('비활성') }}
                                            </x-laravel-admin::admin.badge>
                                        </td>
                                        <td class="hidden px-3 py-3 text-center text-sm xl:table-cell" data-roles-cell="{{ $category->id }}">
                                            @if($category->roles->count() > 0)
                                                <div class="flex flex-wrap justify-center gap-1.5">
                                                    @foreach($category->roles as $role)
                                                        <x-laravel-admin::admin.badge>{{ $role->name }}</x-laravel-admin::admin.badge>
                                                    @endforeach
                                                </div>
                                            @else
                                                <span class="text-gray-500 dark:text-gray-400">{{ __('없음') }}</span>
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-3 text-center text-sm font-medium">
                                            @can('update', $category)
                                                <button
                                                    type="button"
                                                    class="cursor-pointer font-medium text-indigo-600 hover:text-indigo-800 dark:text-indigo-300 dark:hover:text-indigo-200"
                                                    onclick="openMenuCategoryRolesModal({{ $category->id }}, @js($category->name))"
                                                >
                                                    권한 수정
                                                </button>
                                            @else
                                                <span class="text-gray-400 dark:text-gray-500">-</span>
                                            @endcan
                                        </td>
                                        <td class="hidden whitespace-nowrap px-3 py-3 text-center text-sm text-gray-600 lg:table-cell dark:text-gray-300">{{ $category->created_at->format('Y-m-d H:i') }}</td>
                                        <td class="whitespace-nowrap py-3 pr-4 pl-3 text-right text-sm font-medium sm:pr-0">
                                            <div class="flex justify-end">
                                                <x-laravel-admin::admin.action-menu>
                                                    @can('view', $category)
                                                        <x-laravel-admin::admin.dropdown-link :href="route('admin.menu-categories.show', $category)" class="rounded-lg px-6 py-1 text-left text-base leading-6 !text-gray-950 hover:!bg-blue-500 hover:!text-white hover:!no-underline focus:!bg-blue-500 focus:!text-white dark:!text-gray-100">
                                                            {{ __('상세보기') }}
                                                        </x-laravel-admin::admin.dropdown-link>
                                                    @endcan
                                                    @can('update', $category)
                                                        <x-laravel-admin::admin.dropdown-link :href="route('admin.menu-categories.edit', $category)" class="rounded-lg px-6 py-1 text-left text-base leading-6 !text-gray-950 hover:!bg-blue-500 hover:!text-white hover:!no-underline focus:!bg-blue-500 focus:!text-white dark:!text-gray-100">
                                                            {{ __('수정') }}
                                                        </x-laravel-admin::admin.dropdown-link>
                                                    @endcan
                                                </x-laravel-admin::admin.action-menu>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="py-12 text-center text-sm text-gray-500 dark:text-gray-400">
                                            @if(request('search'))
                                                {{ __('":keyword"에 대한 검색 결과가 없습니다.', ['keyword' => request('search')]) }}
                                            @else
                                                {{ __('등록된 카테고리가 없습니다.') }}
                                            @endif
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-6 text-sm">
                {!! $categories->appends(request()->query())->links() !!}
            </div>
        </div>
    </div>

    <livewire:admin.modal-stack />

    <script>
        let currentCategoryId = null;

        function menuCategoryDragSort() {
            return {
                sortMode: 'drag',
                draggedRow: null,
                originalOrder: [],
                dropHandled: false,

                initNativeDrag() {},

                captureCategoryOrder() {
                    const tbody = document.getElementById('categories-tbody');

                    return Array.from(tbody.querySelectorAll('tr[data-category-id]'))
                        .map(row => row.dataset.categoryId);
                },

                startDrag(event) {
                    if (this.sortMode !== 'drag') {
                        event.preventDefault();
                        return;
                    }

                    const row = event.target.closest('tr[data-category-id]');

                    if (!row) {
                        event.preventDefault();
                        return;
                    }

                    this.draggedRow = row;
                    this.originalOrder = this.captureCategoryOrder();
                    this.dropHandled = false;
                    this.draggedRow.classList.add('sortable-ghost');
                    event.dataTransfer.effectAllowed = 'move';
                    event.dataTransfer.setData('text/plain', this.draggedRow.dataset.categoryId);
                },

                dragOver(event) {
                    if (!this.draggedRow || this.sortMode !== 'drag') {
                        return;
                    }

                    const targetRow = event.currentTarget;

                    if (targetRow === this.draggedRow) {
                        return;
                    }

                    const rect = targetRow.getBoundingClientRect();
                    const shouldInsertAfter = event.clientY > rect.top + rect.height / 2;
                    const tbody = targetRow.parentNode;

                    tbody.insertBefore(this.draggedRow, shouldInsertAfter ? targetRow.nextSibling : targetRow);
                },

                dropRow() {
                    if (!this.draggedRow || this.sortMode !== 'drag') {
                        return;
                    }

                    this.dropHandled = true;
                    this.updateCategoryOrder(this.buildCategoryOrder(), this.originalOrder);
                    this.endDrag();
                },

                endDrag() {
                    if (this.draggedRow) {
                        this.draggedRow.classList.remove('sortable-ghost');
                    }

                    this.draggedRow = null;

                    if (!this.dropHandled && this.originalOrder.length > 0) {
                        this.restoreCategoryOrder(this.originalOrder);
                    }

                    this.originalOrder = [];
                    this.dropHandled = false;
                },

                buildCategoryOrder() {
                    const pageOffset = ({{ $categories->currentPage() }} - 1) * {{ $categories->perPage() }};
                    const tbody = document.getElementById('categories-tbody');

                    return Array.from(tbody.querySelectorAll('tr[data-category-id]')).map((row, index) => ({
                        id: row.dataset.categoryId,
                        sort_order: pageOffset + index + 1
                    }));
                },

                restoreCategoryOrder(order) {
                    const tbody = document.getElementById('categories-tbody');

                    if (!tbody || order.length === 0) {
                        return;
                    }

                    order.forEach(categoryId => {
                        const row = tbody.querySelector(`tr[data-category-id="${categoryId}"]`);

                        if (row) {
                            tbody.appendChild(row);
                        }
                    });

                },

                updateCategoryOrder(newOrder, previousOrder = []) {
                    fetch('{{ route("admin.menu-categories.update-order-multiple", [], false) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ categories: newOrder })
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.text().then(text => {
                                try {
                                    const data = JSON.parse(text);
                                    if (data && data.message) {
                                        throw new Error(data.message);
                                    }
                                } catch (e) {}

                                throw new Error(text || `HTTP error! status: ${response.status}`);
                            });
                        }

                        return response.text().then(text => {
                            if (!text) return { success: true };

                            try {
                                return JSON.parse(text);
                            } catch (e) {
                                return { success: true };
                            }
                        });
                    })
                    .then(data => {
                        if (data.success) {
                            showNotification('카테고리 순서가 성공적으로 변경되었습니다.', 'success');
                            refreshLeftMenu();
                        } else {
                            this.restoreCategoryOrder(previousOrder);
                            showNotification(data.message || '순서 변경 중 오류가 발생했습니다.', 'error');
                        }
                    })
                    .catch(error => {
                        this.restoreCategoryOrder(previousOrder);
                        showNotification(error?.message || '순서 변경 중 네트워크 오류가 발생했습니다.', 'error');
                    });
                }
            }
        }

        function refreshLeftMenu() {
            if (window.Livewire && typeof window.Livewire.dispatch === 'function') {
                try {
                    window.Livewire.dispatch('admin-menu-categories:menu-categories:reordered');
                } catch (error) {}
            }
        }

        function showNotification(message, type) {
            window.dispatchEvent(new CustomEvent('notification:show', {
                detail: {
                    message: message,
                    type: type ?? 'info',
                },
            }));
        }

        function openMenuCategoryRolesModal(categoryId, categoryName) {
            Livewire.dispatch('admin:modal-stack:push', {
                id: 'menu-category-roles-' + categoryId + '-' + Date.now(),
                component: 'admin.menu-categories.roles-modal',
                params: { menuCategoryId: parseInt(categoryId) },
                title: '[' + categoryName + '] 권한 관리',
                size: 'lg',
                width: 720,
                height: 560
            });
        }

        document.addEventListener('click', function(event) {
            const trigger = event.target?.closest ? event.target.closest('[data-menu-order-category-id]') : null;

            if (!trigger) {
                return;
            }

            event.preventDefault();
            event.stopPropagation();

            const categoryId = trigger.getAttribute('data-menu-order-category-id');
            const categoryName = trigger.getAttribute('data-menu-order-category-name');

            if (!categoryId || !categoryName) {
                return;
            }

            Livewire.dispatch('admin:modal-stack:push', {
                id: 'menu-order-' + categoryId + '-' + Date.now(),
                component: 'admin.menus.menu-order-modal',
                params: { categoryId: parseInt(categoryId), categoryName: categoryName },
                title: '메뉴 순서 변경',
                size: 'md',
                width: 560,
                height: 640,
                closeOnBackdrop: false
            });
        });
    </script>
</x-laravel-admin::admin.layouts.admin>
