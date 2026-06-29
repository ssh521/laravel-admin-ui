<x-laravel-admin::admin.layouts.admin title="역할 관리">

    <x-slot name="header">

        <x-laravel-admin::admin.admin-header>
            <x-slot name="navigation">
                <a href="{{ route('admin.index') }}">관리자 홈</a>
            </x-slot>
            <x-slot name="description">
                {{ __('역할 목록') }}
            </x-slot>
        </x-laravel-admin::admin.admin-header>

    </x-slot>

    <div class="w-full bg-white px-2 py-2 dark:bg-gray-900">
        <div class="min-h-[560px] bg-white px-4 py-6 sm:px-6 lg:px-8 dark:bg-gray-900">
            <div class="sm:flex sm:items-center sm:justify-between">
                <div class="sm:flex-auto">
                    <h1 class="text-2xl font-semibold leading-7 text-gray-900 dark:text-white">{{ __('역할 목록') }}</h1>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-600 dark:text-gray-400">
                        {{ __('역할과 연결된 권한, 메뉴 카테고리 접근 범위를 관리합니다.') }}
                    </p>
                    @if(request('search'))
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">"{{ request('search') }}" 검색 결과</p>
                    @endif
                </div>
                <div class="mt-4 flex flex-wrap gap-2 sm:mt-0 sm:ml-16 sm:flex-none">
                    @can('create', \Spatie\Permission\Models\Role::class)
                        <x-laravel-admin::admin.action-button :href="route('admin.roles.create')" size="sm" icon="plus">
                            {{ __('등록하기') }}
                        </x-laravel-admin::admin.action-button>
                    @endcan

                    <x-laravel-admin::admin.action-button type="button" id="open-menu-category-selector" variant="secondary" size="sm" icon="folder-open">
                        {{ __('메뉴 카테고리 관리') }}
                    </x-laravel-admin::admin.action-button>
                </div>
            </div>

            <x-laravel-admin::admin.session-messages />

            <x-laravel-admin::admin.filter-bar action="{{ route('admin.roles.index') }}">
                <label for="role-search" class="sr-only">역할 검색</label>
                <div class="relative min-w-0 flex-1">
                    <x-laravel-admin::admin.form-input id="role-search" name="search" value="{{ request('search') }}" class="w-full h-10 pr-9" placeholder="역할 이름 검색" />
                    @if(request('search'))
                        <a href="{{ route('admin.roles.index') }}"
                           class="absolute right-3 top-1/2 -translate-y-1/2 !text-gray-400 hover:!text-gray-600 hover:no-underline dark:hover:!text-gray-300">
                            <x-laravel-admin::admin.icon name="xmark" class="text-sm" />
                        </a>
                    @endif
                </div>

                <x-laravel-admin::admin.action-button type="submit" variant="search" icon="magnifying-glass" class="w-full shrink-0 whitespace-nowrap sm:w-auto">
                    {{ __('검색') }}
                </x-laravel-admin::admin.action-button>
            </x-laravel-admin::admin.filter-bar>

            <div class="mt-6">
                @if($data->count() > 0)
                    <ul role="list" class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                        @foreach ($data as $role)
                            <li class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm transition hover:border-gray-300 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-900 dark:hover:border-gray-600 dark:hover:bg-gray-800/80">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="min-w-0">
                                        @can('view', $role)
                                            <button type="button"
                                                onclick="Livewire.dispatch('admin-roles:role-detail-modal:show', { roleId: {{ Js::from($role->id) }} })"
                                                class="cursor-pointer text-left text-base font-semibold leading-6 text-gray-900 hover:text-indigo-600 dark:text-white dark:hover:text-indigo-300">
                                                {{ $role->name }}
                                            </button>
                                        @else
                                            <h2 class="text-base font-semibold leading-6 text-gray-900 dark:text-white">{{ $role->name }}</h2>
                                        @endcan
                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                            {{ $role->permissions->count() }} {{ __('permissions') }}
                                        </p>
                                    </div>

                                    @can('view', $role)
                                        <x-laravel-admin::admin.action-button variant="link" size="sm" :href="route('admin.roles.show', $role)" icon="eye" class="shrink-0">
                                            상세보기
                                        </x-laravel-admin::admin.action-button>
                                    @endcan
                                </div>

                                <div class="mt-4 border-t border-gray-100 pt-4 dark:border-gray-800">
                                    @if($role->permissions->count() > 0)
                                        <div class="flex max-h-28 flex-wrap gap-1.5 overflow-y-auto pr-1">
                                            @foreach($role->permissions as $permission)
                                                <x-laravel-admin::admin.badge>{{ $permission->name }}</x-laravel-admin::admin.badge>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-sm text-gray-500 dark:text-gray-400">권한 없음</span>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="rounded-lg border border-dashed border-gray-300 bg-white px-6 py-16 text-center text-sm text-gray-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-400">
                        @if(request('search'))
                            "{{ request('search') }}"에 대한 검색 결과가 없습니다.
                        @else
                            등록된 역할이 없습니다.
                        @endif
                    </div>
                @endif
            </div>

            <div class="mt-6 text-sm">
                {!! $data->appends(request()->query())->links() !!}
            </div>
        </div>
    </div>

    {{-- 메뉴 카테고리 선택 모달 --}}
    <x-laravel-admin::admin.draggable-modal
        id="menu-category-selector-modal"
        title="메뉴 카테고리 관리"
        width="720"
        height="620"
        :close-on-backdrop-click="true"
    >
        <div class="p-5">
            <div>
                <h3 class="text-lg font-semibold leading-7 text-gray-900 dark:text-white">메뉴 카테고리 관리</h3>
                <p class="mt-1 text-sm leading-6 text-gray-500 dark:text-gray-400">카테고리별 접근 역할을 확인하고 관리합니다.</p>
            </div>

            <div class="mt-5 rounded-lg border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-800/70">
                <div class="relative">
                    <x-laravel-admin::admin.form-input id="menu-category-search" placeholder="메뉴 카테고리 검색..." class="w-full h-10 !pl-10" />
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <x-laravel-admin::admin.icon name="magnifying-glass" class="text-sm text-gray-400" />
                    </div>
                </div>
            </div>

            <div class="mt-5 max-h-[380px] overflow-y-auto pr-1">
                <div id="menu-category-list" class="grid grid-cols-1 gap-3">
                    @php
                        $menuCategories = \Ssh521\LaravelAdmin\Models\MenuCategory::withCount('menus')->with('roles')->ordered()->get();
                    @endphp
                    @foreach($menuCategories as $category)
                    <div class="menu-category-item rounded-lg border border-gray-200 bg-white p-4 shadow-sm transition hover:border-gray-300 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-900 dark:hover:border-gray-600 dark:hover:bg-gray-800/80"
                         data-category-id="{{ $category->id }}"
                         data-category-name="{{ $category->name }}"
                         data-category-menu-count="{{ $category->menu_count ?? 0 }}">
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                            <div class="min-w-0 flex-1">
                                <div class="truncate text-base font-semibold text-gray-900 dark:text-white">
                                    {{ $category->name }}
                                </div>
                                <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    메뉴 {{ $category->menu_count ?? 0 }}개
                                </div>
                                <div class="category-roles-list mt-3 flex flex-wrap gap-1.5">
                                    @if($category->roles->count() > 0)
                                        @foreach($category->roles as $role)
                                            <x-laravel-admin::admin.badge>
                                                {{ $role->name }}
                                            </x-laravel-admin::admin.badge>
                                        @endforeach
                                    @else
                                        <span class="text-sm text-gray-500 dark:text-gray-400">허용된 역할 없음</span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex shrink-0 items-center gap-2">
                                @if($category->is_active)
                                    <x-laravel-admin::admin.badge variant="success">
                                        활성
                                    </x-laravel-admin::admin.badge>
                                @else
                                    <x-laravel-admin::admin.badge variant="danger">
                                        비활성
                                    </x-laravel-admin::admin.badge>
                                @endif
                                <button type="button"
                                        class="inline-flex h-8 cursor-pointer items-center rounded-md px-2.5 text-sm font-semibold text-indigo-600 hover:bg-indigo-50 dark:text-indigo-300 dark:hover:bg-indigo-500/10"
                                        onclick="manageCategoryRoles({{ $category->id }}, '{{ $category->name }}')">
                                    <x-laravel-admin::admin.icon name="pen-to-square" class="mr-1.5 text-xs" />
                                    역할 관리
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div id="no-menu-categories-message" class="hidden rounded-lg border border-dashed border-gray-300 bg-white p-8 text-center text-gray-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-400">
                    <x-laravel-admin::admin.icon name="folder-open" class="text-3xl text-gray-400" />
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">메뉴 카테고리가 없습니다</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">등록된 메뉴 카테고리가 없습니다.</p>
                </div>
            </div>

            <div class="mt-6 flex justify-end border-t border-gray-200 pt-4 dark:border-gray-700">
                <x-laravel-admin::admin.action-button type="button" id="close-menu-category-selector" variant="secondary">
                    닫기
                </x-laravel-admin::admin.action-button>
            </div>
        </div>
    </x-laravel-admin::admin.draggable-modal>

    {{-- 역할 관리 모달 --}}
    <x-laravel-admin::admin.draggable-modal
        id="role-management-modal"
        title="카테고리 역할 관리"
        width="560"
        height="520"
        :close-on-backdrop-click="true"
    >
        <div class="p-5">
            <div>
                <h3 class="text-lg font-semibold leading-7 text-gray-900 dark:text-white" id="category-name-display"></h3>
                <p class="mt-1 text-sm leading-6 text-gray-500 dark:text-gray-400">이 카테고리에 접근할 수 있는 역할을 선택하세요.</p>
            </div>

            <div class="mt-5 max-h-72 overflow-y-auto pr-1">
                <div id="role-list" class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                    @php
                        $allRoles = \Spatie\Permission\Models\Role::all();
                    @endphp
                    @foreach($allRoles as $role)
                    <x-laravel-admin::admin.checkbox-row title="{{ $role->name }}" class="min-h-11 items-center px-3 py-2 text-sm font-medium">
                        <input type="checkbox"
                               class="role-checkbox size-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600 dark:border-gray-600 dark:bg-gray-900"
                               value="{{ $role->id }}"
                               data-role-name="{{ $role->name }}">
                    </x-laravel-admin::admin.checkbox-row>
                    @endforeach
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-2 border-t border-gray-200 pt-4 dark:border-gray-700">
                <x-laravel-admin::admin.action-button type="button" id="cancel-role-management" variant="secondary">
                    취소
                </x-laravel-admin::admin.action-button>
                <x-laravel-admin::admin.action-button type="button" id="save-role-management">
                    저장
                </x-laravel-admin::admin.action-button>
            </div>
        </div>
    </x-laravel-admin::admin.draggable-modal>



    {{-- JavaScript --}}
    <script>
    // 전역 변수 선언
    let currentCategoryId = null;

    document.addEventListener('DOMContentLoaded', function() {
        const openMenuCategorySelector = document.getElementById('open-menu-category-selector');
        const closeMenuCategorySelector = document.getElementById('close-menu-category-selector');
        const menuCategorySearch = document.getElementById('menu-category-search');
        const menuCategoryList = document.getElementById('menu-category-list');
        const noMenuCategoriesMessage = document.getElementById('no-menu-categories-message');
        const cancelRoleManagement = document.getElementById('cancel-role-management');
        const saveRoleManagement = document.getElementById('save-role-management');
        let allMenuCategories = [];
        let filteredMenuCategories = [];

        // 초기 메뉴 카테고리 목록 설정
        allMenuCategories = Array.from(document.querySelectorAll('.menu-category-item')).map(item => ({
            id: item.dataset.categoryId,
            name: item.dataset.categoryName,
            menuCount: item.dataset.categoryMenuCount,
            element: item
        }));

        filteredMenuCategories = [...allMenuCategories];

        // 메뉴 카테고리 선택 모달 열기
        openMenuCategorySelector.addEventListener('click', function() {
            window.dispatchEvent(new CustomEvent('open-modal', {
                detail: { modalId: 'menu-category-selector-modal', action: 'open' }
            }));
        });

        // 메뉴 카테고리 선택 모달 닫기
        closeMenuCategorySelector.addEventListener('click', function() {
            window.dispatchEvent(new CustomEvent('close-modal', {
                detail: { modalId: 'menu-category-selector-modal' }
            }));
        });

        // 메뉴 카테고리 검색
        menuCategorySearch.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();

            if (searchTerm === '') {
                filteredMenuCategories = [...allMenuCategories];
            } else {
                filteredMenuCategories = allMenuCategories.filter(category =>
                    category.name.toLowerCase().includes(searchTerm)
                );
            }

            renderMenuCategoryList();
        });

        // 메뉴 카테고리 목록 렌더링
        function renderMenuCategoryList() {
            allMenuCategories.forEach(category => {
                category.element.style.display = 'none';
            });

            if (filteredMenuCategories.length === 0) {
                noMenuCategoriesMessage.classList.remove('hidden');
                menuCategoryList.classList.add('hidden');
            } else {
                noMenuCategoriesMessage.classList.add('hidden');
                menuCategoryList.classList.remove('hidden');

                filteredMenuCategories.forEach(category => {
                    category.element.style.display = 'block';
                });
            }
        }

        // 역할 관리 취소
        cancelRoleManagement.addEventListener('click', function() {
            window.dispatchEvent(new CustomEvent('close-modal', {
                detail: { modalId: 'role-management-modal' }
            }));
        });

        // 역할 관리 저장
        saveRoleManagement.addEventListener('click', function() {
            if (!currentCategoryId) {
                console.error('currentCategoryId가 설정되지 않음');
                showNotification('카테고리 ID가 설정되지 않았습니다.', 'error');
                return;
            }

            const selectedRoles = Array.from(document.querySelectorAll('.role-checkbox:checked'))
                .map(checkbox => checkbox.value);

            // AJAX 요청으로 역할 저장
            fetch(`/admin/menu-categories/${currentCategoryId}/roles/api`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    roles: selectedRoles
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // 성공 메시지 표시
                    showNotification('역할이 성공적으로 저장되었습니다.', 'success');

                    // 부모 모달은 유지하고 역할 관리 모달만 닫기
                    window.dispatchEvent(new CustomEvent('close-modal', {
                        detail: { modalId: 'role-management-modal' }
                    }));

                    updateCategoryRoleBadges(currentCategoryId, data.roles || []);
                } else {
                    showNotification(data.message || '역할 저장 중 오류가 발생했습니다.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('역할 저장 중 오류가 발생했습니다: ' + error.message, 'error');
            });
        });

        // 모달이 열릴 때 검색어 초기화
        document.addEventListener('open-modal', function(event) {
            if (event.detail.modalId === 'menu-category-selector-modal') {
                menuCategorySearch.value = '';
                filteredMenuCategories = [...allMenuCategories];
                renderMenuCategoryList();
            }
        });

    });

    // 전역 알림 표시 함수
    function showNotification(message, type = 'info') {
        // 간단한 알림 구현 (실제 프로젝트에서는 더 정교한 알림 시스템 사용)
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 px-4 py-2 rounded-md text-white z-50 ${
            type === 'success' ? 'bg-green-500' :
            type === 'error' ? 'bg-red-500' : 'bg-blue-500'
        }`;
        notification.textContent = message;
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.remove();
        }, 3000);
    }

    function updateCategoryRoleBadges(categoryId, roles) {
        const categoryItem = document.querySelector(`.menu-category-item[data-category-id="${categoryId}"]`);
        const rolesContainer = categoryItem?.querySelector('.category-roles-list');

        if (!rolesContainer) {
            return;
        }

        rolesContainer.replaceChildren();

        if (roles.length === 0) {
            const emptyLabel = document.createElement('span');
            emptyLabel.className = 'text-sm text-gray-500 dark:text-gray-400';
            emptyLabel.textContent = '허용된 역할 없음';
            rolesContainer.appendChild(emptyLabel);

            return;
        }

        roles.forEach(role => {
            const badge = document.createElement('span');
            badge.className = 'inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-700 ring-1 ring-gray-500/10 ring-inset dark:bg-gray-800 dark:text-gray-300 dark:ring-gray-700';
            badge.textContent = role.name;
            rolesContainer.appendChild(badge);
        });
    }

    // 전역 함수: 카테고리 역할 관리
    function manageCategoryRoles(categoryId, categoryName) {
        currentCategoryId = categoryId;

        // 카테고리 이름 표시
        document.getElementById('category-name-display').textContent = categoryName;

        // 현재 카테고리의 역할 정보 가져오기
        fetch(`/admin/menu-categories/${categoryId}/roles/api`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                // 모든 체크박스 해제
                document.querySelectorAll('.role-checkbox').forEach(checkbox => {
                    checkbox.checked = false;
                });

                // 현재 카테고리에 허용된 역할 체크
                if (data.roles) {
                    const selectedRoleIds = data.roles.map(role => String(role.id ?? role));

                    document.querySelectorAll('.role-checkbox').forEach(checkbox => {
                        checkbox.checked = selectedRoleIds.includes(String(checkbox.value));
                    });
                }

                // 역할 관리 모달 열기
                window.dispatchEvent(new CustomEvent('open-modal', {
                    detail: { modalId: 'role-management-modal', action: 'open' }
                }));
            })
            .catch(error => {
                console.error('역할 정보 가져오기 오류:', error);
                document.querySelectorAll('.role-checkbox').forEach(checkbox => {
                    checkbox.checked = false;
                });

                // 오류 발생 시에도 모달은 열기
                window.dispatchEvent(new CustomEvent('open-modal', {
                    detail: { modalId: 'role-management-modal', action: 'open' }
                }));
            });
    }
    </script>

    {{-- 역할 상세 모달 --}}
    <livewire:admin.roles.role-detail-modal />

</x-laravel-admin::admin.layouts.admin>
