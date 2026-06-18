<x-laravel-admin::admin.layouts.admin title="메뉴 카테고리 관리">
    <x-slot name="header">
        <x-laravel-admin::admin.admin-header>
            <x-slot name="navigation">
                <a href="{{ route('admin.index') }}">관리자 홈</a>
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
                        <a href="{{ route('admin.menu-categories.create') }}" class="inline-flex h-10 items-center justify-center rounded-md bg-indigo-600 px-4 text-sm font-semibold !text-white shadow-sm hover:bg-indigo-500 hover:no-underline dark:bg-indigo-500 dark:hover:bg-indigo-400">
                            <x-laravel-admin::admin.icon name="plus" class="mr-2 text-xs" />
                            {{ __('등록하기') }}
                        </a>
                    @endcan
                </div>
            </div>

            <x-laravel-admin::admin.session-messages />

            <div class="mt-6 rounded-md border border-gray-200 bg-gray-50 p-3 dark:border-gray-700 dark:bg-gray-800/60">
                <form class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-end" action="{{ route('admin.menu-categories.index') }}" method="GET">
                    <label for="category-search" class="sr-only">Search</label>
                    <input
                        id="category-search"
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="h-10 w-full rounded-md border border-gray-300 bg-white px-3 text-sm text-gray-900 shadow-sm outline-none placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 sm:w-72 dark:border-gray-600 dark:bg-gray-900 dark:text-white"
                        placeholder="{{ __('카테고리 검색') }}"
                    >

                    <div class="flex gap-2">
                        @if(request('search'))
                            <a href="{{ route('admin.menu-categories.index') }}" class="inline-flex h-10 items-center justify-center rounded-md border border-gray-300 bg-white px-4 text-sm font-semibold !text-gray-700 shadow-sm hover:bg-gray-50 hover:no-underline dark:border-gray-600 dark:bg-gray-900 dark:!text-gray-100 dark:hover:bg-gray-800">
                                {{ __('초기화') }}
                            </a>
                        @endif

                        <button type="submit" class="inline-flex h-10 cursor-pointer items-center justify-center rounded-md bg-indigo-600 px-4 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 dark:bg-indigo-500 dark:hover:bg-indigo-400">
                            {{ __('검색') }}
                        </button>
                    </div>
                </form>
            </div>

            <div class="mt-6 flow-root">
                <div class="-mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr>
                                    <th scope="col" class="py-3.5 pr-3 pl-4 text-left text-sm font-semibold text-gray-900 sm:pl-0 dark:text-white">
                                        <span class="sr-only">순서</span>
                                    </th>
                                    <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell dark:text-white">ID</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">{{ __('카테고리명') }}</th>
                                    <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 md:table-cell dark:text-white">{{ __('메뉴 개수') }}</th>
                                    <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell dark:text-white">{{ __('정렬 순서') }}</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">{{ __('상태') }}</th>
                                    <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 xl:table-cell dark:text-white">{{ __('허용 역할') }}</th>
                                    <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell dark:text-white">{{ __('생성일') }}</th>
                                    <th scope="col" class="relative py-3.5 pr-4 pl-3 sm:pr-0">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="categories-tbody" class="divide-y divide-gray-100 dark:divide-gray-800">
                                @forelse($categories as $category)
                                    <tr data-category-id="{{ $category->id }}" class="hover:bg-gray-50 dark:hover:bg-gray-800/70">
                                        <td class="whitespace-nowrap py-4 pr-3 pl-4 text-sm sm:pl-0">
                                            <div class="drag-handle inline-flex size-8 items-center justify-center rounded-md text-gray-400 hover:bg-gray-100 hover:text-gray-600 dark:hover:bg-gray-800 dark:hover:text-gray-300">
                                                <x-laravel-admin::admin.icon name="grip-lines" />
                                            </div>
                                        </td>
                                        <td class="hidden whitespace-nowrap px-3 py-4 text-sm text-gray-600 sm:table-cell dark:text-gray-300">{{ $category->id }}</td>
                                        <td class="px-3 py-4 text-sm">
                                            @can('view', $category)
                                                <a href="{{ route('admin.menu-categories.show', $category) }}" class="font-semibold !text-gray-900 hover:!text-indigo-600 hover:no-underline dark:!text-white dark:hover:!text-indigo-400">{{ $category->name }}</a>
                                            @else
                                                <span class="font-semibold text-gray-900 dark:text-white">{{ $category->name }}</span>
                                            @endcan
                                            <div class="mt-1 flex flex-wrap items-center gap-1.5 text-xs text-gray-500 md:hidden dark:text-gray-400">
                                                <span>{{ $category->menus_count }} {{ __('menus') }}</span>
                                                <span aria-hidden="true">/</span>
                                                <span class="sort-order-cell">{{ $category->sort_order }}</span>
                                            </div>
                                        </td>
                                        <td class="hidden whitespace-nowrap px-3 py-4 text-sm text-gray-600 md:table-cell dark:text-gray-300">{{ $category->menus_count }}</td>
                                        <td class="sort-order-cell hidden whitespace-nowrap px-3 py-4 text-sm text-gray-600 lg:table-cell dark:text-gray-300">{{ $category->sort_order }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm">
                                            <span class="{{ $category->is_active ? 'bg-green-50 text-green-700 ring-green-600/20 dark:bg-green-500/10 dark:text-green-300 dark:ring-green-500/20' : 'bg-red-50 text-red-700 ring-red-600/20 dark:bg-red-500/10 dark:text-red-300 dark:ring-red-500/20' }} inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset">
                                                {{ $category->is_active ? __('활성') : __('비활성') }}
                                            </span>
                                        </td>
                                        <td class="hidden px-3 py-4 text-sm xl:table-cell" data-roles-cell="{{ $category->id }}">
                                            @if($category->roles->count() > 0)
                                                <div class="flex flex-wrap gap-1.5">
                                                    @foreach($category->roles as $role)
                                                        <span class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-700 ring-1 ring-gray-500/10 ring-inset dark:bg-gray-800 dark:text-gray-300 dark:ring-gray-700">{{ $role->name }}</span>
                                                    @endforeach
                                                </div>
                                            @else
                                                <span class="text-gray-500 dark:text-gray-400">{{ __('없음') }}</span>
                                            @endif
                                        </td>
                                        <td class="hidden whitespace-nowrap px-3 py-4 text-sm text-gray-600 lg:table-cell dark:text-gray-300">{{ $category->created_at->format('Y-m-d H:i') }}</td>
                                        <td class="whitespace-nowrap py-4 pr-4 pl-3 text-right text-sm font-medium sm:pr-0">
                                            <div class="flex justify-end gap-3">
                                                @can('view', $category)
                                                    <a href="{{ route('admin.menu-categories.show', $category) }}" class="inline-flex items-center font-semibold !text-indigo-600 hover:!text-indigo-500 hover:no-underline dark:!text-indigo-400">
                                                        <x-laravel-admin::admin.icon name="eye" class="mr-1.5 text-xs" />
                                                        {{ __('상세보기') }}
                                                    </a>
                                                @endcan
                                                @can('update', $category)
                                                    <x-laravel-admin::admin.modal-trigger
                                                        text="권한"
                                                        modal-id="roles-modal"
                                                        type="link"
                                                        variant="primary"
                                                        modal-type="single"
                                                        class="cursor-pointer"
                                                        data-category-id="{{ $category->id }}"
                                                        data-category-name="{{ $category->name }}" />
                                                    <a href="{{ route('admin.menu-categories.edit', $category) }}" class="inline-flex items-center font-semibold !text-indigo-600 hover:!text-indigo-500 hover:no-underline dark:!text-indigo-400">
                                                        <x-laravel-admin::admin.icon name="pen-to-square" class="mr-1.5 text-xs" />
                                                        {{ __('수정') }}
                                                    </a>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="py-12 text-center text-sm text-gray-500 dark:text-gray-400">
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

    <x-laravel-admin::admin.draggable-modal id="roles-modal" title="권한 관리" :width="720" :height="560">
        <div class="p-6">
            <div class="mb-5">
                <h3 class="text-base font-semibold leading-7 text-gray-900 dark:text-white" id="modal-category-name">
                    카테고리 권한 관리
                </h3>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    메뉴 카테고리에 허용할 역할을 선택합니다.
                </p>
            </div>

            <form id="roles-form" class="space-y-5">
                @csrf
                <div id="roles-container" class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                    <!-- 역할 목록이 여기에 동적으로 로드됩니다 -->
                </div>

                <div class="flex items-center justify-end gap-3 border-t border-gray-200 pt-4 dark:border-gray-700">
                    <button type="button"
                        @click="$dispatch('close-modal', { modalId: 'roles-modal', action: 'close' })"
                        class="inline-flex h-10 items-center justify-center rounded-md border border-gray-300 bg-white px-4 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 dark:hover:bg-gray-700">
                        {{ __('취소') }}
                    </button>
                    <button id="roles-submit-btn" type="submit"
                        class="inline-flex h-10 cursor-pointer items-center justify-center rounded-md bg-indigo-600 px-4 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 disabled:cursor-not-allowed disabled:opacity-50 dark:bg-indigo-500 dark:hover:bg-indigo-400">
                        {{ __('저장') }}
                    </button>
                </div>
            </form>
        </div>
    </x-laravel-admin::admin.draggable-modal>

    <script>
        let currentCategoryId = null;

        document.addEventListener('DOMContentLoaded', function() {
            initCategoryDragSort();
        });

        function initCategoryDragSort() {
            const tbody = document.querySelector('#categories-tbody');
            if (!tbody || tbody.dataset.nativeSortInitialized === 'true') {
                return;
            }

            tbody.dataset.nativeSortInitialized = 'true';
            let draggedRow = null;
            let originalOrder = [];
            let dropHandled = false;

            const captureCategoryOrder = () => Array.from(tbody.querySelectorAll('tr[data-category-id]'))
                .map(row => row.dataset.categoryId);

            tbody.querySelectorAll('tr[data-category-id]').forEach(row => {
                row.draggable = true;

                row.addEventListener('dragstart', event => {
                    if (!event.target.closest('.drag-handle')) {
                        event.preventDefault();
                        return;
                    }

                    draggedRow = row;
                    originalOrder = captureCategoryOrder();
                    dropHandled = false;
                    row.classList.add('sortable-ghost');
                    event.dataTransfer.effectAllowed = 'move';
                    event.dataTransfer.setData('text/plain', row.dataset.categoryId);
                });

                row.addEventListener('dragover', event => {
                    if (!draggedRow || draggedRow === row) {
                        return;
                    }

                    event.preventDefault();
                    const rect = row.getBoundingClientRect();
                    const shouldInsertAfter = event.clientY > rect.top + rect.height / 2;
                    tbody.insertBefore(draggedRow, shouldInsertAfter ? row.nextSibling : row);
                });

                row.addEventListener('drop', event => {
                    event.preventDefault();

                    if (!draggedRow) {
                        return;
                    }

                    draggedRow.classList.remove('sortable-ghost');
                    dropHandled = true;
                    draggedRow = null;
                    updateCategoryOrder(buildCategoryOrder(tbody), originalOrder);
                });

                row.addEventListener('dragend', () => {
                    if (draggedRow) {
                        draggedRow.classList.remove('sortable-ghost');
                    }

                    draggedRow = null;

                    if (!dropHandled && originalOrder.length > 0) {
                        restoreCategoryOrder(originalOrder);
                    }

                    originalOrder = [];
                    dropHandled = false;
                });
            });
        }

        function buildCategoryOrder(tbody) {
            return Array.from(tbody.querySelectorAll('tr[data-category-id]')).map((row, index) => ({
                id: row.dataset.categoryId,
                sort_order: index + 1
            }));
        }

        function restoreCategoryOrder(order) {
            const tbody = document.querySelector('#categories-tbody');

            if (!tbody || order.length === 0) {
                return;
            }

            order.forEach(categoryId => {
                const row = tbody.querySelector(`tr[data-category-id="${categoryId}"]`);

                if (row) {
                    tbody.appendChild(row);
                }
            });

            updateSortOrderNumbers();
        }

        function updateCategoryOrder(newOrder, previousOrder = []) {
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
                    updateSortOrderNumbers();
                    refreshLeftMenu();
                } else {
                    restoreCategoryOrder(previousOrder);
                    showNotification(data.message || '순서 변경 중 오류가 발생했습니다.', 'error');
                }
            })
            .catch(error => {
                restoreCategoryOrder(previousOrder);
                showNotification(error?.message || '순서 변경 중 네트워크 오류가 발생했습니다.', 'error');
            });
        }

        function refreshLeftMenu() {
            if (window.Livewire && typeof window.Livewire.dispatch === 'function') {
                try {
                    window.Livewire.dispatch('admin-menu-categories:menu-categories:reordered');
                } catch (error) {}
            }
        }

        function updateSortOrderNumbers() {
            const rows = document.querySelectorAll('#categories-tbody tr[data-category-id]');
            rows.forEach((row, index) => {
                row.querySelectorAll('.sort-order-cell').forEach(cell => {
                    cell.textContent = index + 1;
                });
            });
        }

        function showNotification(message, type) {
            window.dispatchEvent(new CustomEvent('notification:show', {
                detail: {
                    message: message,
                    type: type ?? 'info',
                },
            }));
        }

        document.addEventListener('open-modal', function(event) {
            if (event.detail.modalId === 'roles-modal') {
                const trigger = event.target?.closest ? event.target.closest('[data-category-id]') : null;
                if (trigger) {
                    const categoryId = trigger.getAttribute('data-category-id');
                    const categoryName = trigger.getAttribute('data-category-name');

                    currentCategoryId = categoryId;
                    document.getElementById('modal-category-name').textContent = `[${categoryName}] 권한 관리`;
                    loadCategoryRoles(categoryId);
                }
            }
        });

        const getRolesModalUrlBase = '{{ route('admin.menu-categories.get-roles-modal', ['menuCategory' => '__ID__']) }}';

        function loadCategoryRoles(categoryId) {
            fetch(getRolesModalUrlBase.replace('__ID__', categoryId), {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (!response.ok) throw new Error(response.status);
                const ct = response.headers.get('content-type');
                if (!ct || !ct.includes('application/json')) throw new Error('Unexpected response type');
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    renderRoles(data.availableRoles, data.selectedRoles);
                } else {
                    showNotification('권한 데이터를 불러오는 중 오류가 발생했습니다.', 'error');
                }
            })
            .catch(error => {
                showNotification('권한 데이터를 불러오는 중 네트워크 오류가 발생했습니다.', 'error');
            });
        }

        function renderRoles(availableRoles, selectedRoles) {
            const container = document.getElementById('roles-container');
            const submitBtn = document.getElementById('roles-submit-btn');
            container.replaceChildren();

            if (availableRoles.length === 0) {
                const emptyLabel = document.createElement('p');
                emptyLabel.className = 'text-sm text-gray-500 dark:text-gray-400';
                emptyLabel.textContent = @json(__('사용 가능한 역할이 없습니다.'));
                container.appendChild(emptyLabel);
                submitBtn.disabled = true;
                return;
            }
            submitBtn.disabled = false;

            const selectedRoleIds = selectedRoles.map(selectedRole => String(selectedRole.id ?? selectedRole));

            availableRoles.forEach(role => {
                const isSelected = selectedRoleIds.includes(String(role.id));
                const roleElement = document.createElement('label');
                roleElement.className = 'flex min-h-12 cursor-pointer items-center gap-3 rounded-md border border-gray-200 bg-white px-4 py-3 text-sm font-medium text-gray-900 shadow-sm hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:hover:bg-gray-800';
                roleElement.setAttribute('for', `role-${role.id}`);

                const checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.id = `role-${role.id}`;
                checkbox.name = 'roles[]';
                checkbox.value = role.id;
                checkbox.checked = isSelected;
                checkbox.className = 'size-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600 dark:border-gray-600 dark:bg-gray-900';

                const roleName = document.createElement('span');
                roleName.className = 'min-w-0 truncate';
                roleName.textContent = role.name;

                roleElement.append(checkbox, roleName);
                container.appendChild(roleElement);
            });
        }

        document.getElementById('roles-form').addEventListener('submit', function(e) {
            e.preventDefault();

            if (!currentCategoryId) {
                showNotification('카테고리 정보가 없습니다.', 'error');
                return;
            }

            const selectedRoles = Array.from(this.querySelectorAll('input[name="roles[]"]:checked'))
                .map(input => input.value);

            const updateRolesUrlBase = '{{ route('admin.menu-categories.update-roles-api', ['menuCategory' => '__ID__']) }}';

            fetch(updateRolesUrlBase.replace('__ID__', currentCategoryId), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ roles: selectedRoles })
            })
            .then(response => {
                if (!response.ok) throw new Error(response.status);
                const ct = response.headers.get('content-type');
                if (!ct || !ct.includes('application/json')) throw new Error('Unexpected response type');
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showNotification(data.message || '권한이 성공적으로 저장되었습니다.', 'success');
                    const rolesCell = document.querySelector(`[data-roles-cell="${currentCategoryId}"]`);
                    if (rolesCell && data.roles !== undefined) {
                        rolesCell.replaceChildren();

                        if (data.roles.length > 0) {
                            const rolesWrapper = document.createElement('div');
                            rolesWrapper.className = 'flex flex-wrap gap-1.5';

                            data.roles.forEach(role => {
                                const badge = document.createElement('span');
                                badge.className = 'inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-700 ring-1 ring-gray-500/10 ring-inset dark:bg-gray-800 dark:text-gray-300 dark:ring-gray-700';
                                badge.textContent = role.name;
                                rolesWrapper.appendChild(badge);
                            });

                            rolesCell.appendChild(rolesWrapper);
                        } else {
                            const emptyLabel = document.createElement('span');
                            emptyLabel.className = 'text-gray-500 dark:text-gray-400';
                            emptyLabel.textContent = '없음';
                            rolesCell.appendChild(emptyLabel);
                        }
                    }
                    window.dispatchEvent(new CustomEvent('close-modal', {
                        detail: { modalId: 'roles-modal' }
                    }));
                } else {
                    showNotification(data.message || '권한 저장 중 오류가 발생했습니다.', 'error');
                }
            })
            .catch(error => {
                showNotification('권한 저장 중 네트워크 오류가 발생했습니다.', 'error');
            });
        });
    </script>
</x-laravel-admin::admin.layouts.admin>
