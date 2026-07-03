{{-- 메뉴 관리 페이지 - 메뉴 목록 조회, 검색, 정렬, 순서 변경 기능 --}}
<x-laravel-admin::admin.layouts.admin title="메뉴 관리">
    <x-slot name="header">
        <x-laravel-admin::admin.admin-header>
            <x-slot name="navigation">
                <a href="{{ route('admin.index') }}">관리자 홈</a>
                - <a href="{{ route('admin.menus.index') }}">메뉴 관리</a>
            </x-slot>
            <x-slot name="description">
                {{ __('메뉴 목록') }}
            </x-slot>
        </x-laravel-admin::admin.admin-header>
    </x-slot>

    @php
        $currentSort = $sort;
        $currentDirection = $direction;

        $getNextDirection = fn($field) => ($currentSort === $field && $currentDirection === 'asc') ? 'desc' : 'asc';
        $sortLinkClass = 'inline-flex items-center justify-center gap-1 !text-gray-900 hover:!text-indigo-600 hover:no-underline dark:!text-white dark:hover:!text-indigo-400';

        $renderSortIcon = function ($field) use ($currentSort, $currentDirection) {
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
                    <h1 class="text-2xl font-semibold leading-7 text-gray-900 dark:text-white">
                        {{ __('메뉴 목록') }}
                    </h1>
                    <p class="mt-2 text-sm leading-6 text-gray-600 dark:text-gray-400">
                        @if(request('search'))
                            "{{ request('search') }}" {{ __('검색 결과입니다.') }}
                        @else
                            {{ __('관리자 메뉴의 연결 경로, 카테고리, 노출 상태를 관리합니다.') }}
                        @endif
                    </p>
                </div>
                <div class="mt-4 flex flex-wrap gap-2 sm:mt-0 sm:ml-6">
                    @can('create', Ssh521\LaravelAdmin\Models\Menu::class)
                        <x-laravel-admin::admin.action-button :href="route('admin.menus.create')" size="sm" icon="plus">
                            {{ __('등록하기') }}
                        </x-laravel-admin::admin.action-button>
                    @endcan
                </div>
            </div>

            <x-laravel-admin::admin.session-messages />

            <x-laravel-admin::admin.filter-bar action="{{ route('admin.menus.index') }}">
                @if(request('sort'))
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                @endif
                @if(request('direction'))
                    <input type="hidden" name="direction" value="{{ request('direction') }}">
                @endif
                <div class="flex flex-wrap items-center gap-2 text-sm">
                    <x-laravel-admin::admin.checkbox-controls />
                    <x-laravel-admin::admin.action-button type="button" variant="secondary" size="sm" onclick="openCategorySelectionModal()" icon="tags">
                        {{ __('분류선택') }}
                    </x-laravel-admin::admin.action-button>
                </div>

                <label for="menu-search" class="sr-only">Search</label>
                <div class="relative min-w-0 flex-1">
                    <x-laravel-admin::admin.form-input
                        id="menu-search"
                        name="search"
                        value="{{ request('search') }}"
                        class="w-full h-10 pr-9"
                        placeholder="{{ __('메뉴 검색') }}"
                    />
                    @if(request('search'))
                        <a href="{{ route('admin.menus.index') }}"
                           class="absolute right-3 top-1/2 -translate-y-1/2 !text-gray-400 hover:!text-gray-600 hover:no-underline dark:hover:!text-gray-300">
                            <x-laravel-admin::admin.icon name="xmark" class="text-sm" />
                        </a>
                    @endif
                </div>

                <x-laravel-admin::admin.action-button type="submit" variant="search" icon="magnifying-glass" class="w-full shrink-0 whitespace-nowrap sm:w-auto">
                    {{ __('검색') }}
                </x-laravel-admin::admin.action-button>
            </x-laravel-admin::admin.filter-bar>

            <div class="mt-6 flow-root">
                <div class="-mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="border-y border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-800/80">
                                <tr>
                                    <th scope="col" class="py-3 pr-3 pl-4 text-left text-sm font-semibold text-gray-900 sm:pl-0 dark:text-white">
                                        <span class="sr-only">Select</span>
                                    </th>
                                    <th scope="col" class="px-3 py-3 text-center text-sm font-semibold text-gray-900 dark:text-white">
                                        <a href="{{ route('admin.menus.index', array_merge(request()->query(), ['sort' => 'name', 'direction' => $getNextDirection('name')])) }}" class="{{ $sortLinkClass }}">
                                            <span>{{ __('메뉴명') }}</span>
                                            {!! $renderSortIcon('name') !!}
                                        </a>
                                    </th>
                                    <th scope="col" class="hidden px-3 py-3 text-center text-sm font-semibold text-gray-900 md:table-cell dark:text-white">
                                        @if(empty(request('search')))
                                            <a href="{{ route('admin.menus.index', array_merge(request()->query(), ['sort' => 'category', 'direction' => $getNextDirection('category')])) }}" class="{{ $sortLinkClass }}">
                                                <span>{{ __('카테고리') }}</span>
                                                {!! $renderSortIcon('category') !!}
                                            </a>
                                        @else
                                            {{ __('카테고리') }}
                                        @endif
                                    </th>
                                    <th scope="col" class="hidden px-3 py-3 text-center text-sm font-semibold text-gray-900 lg:table-cell dark:text-white">
                                        <a href="{{ route('admin.menus.index', array_merge(request()->query(), ['sort' => 'route_name', 'direction' => $getNextDirection('route_name')])) }}" class="{{ $sortLinkClass }}">
                                            <span>{{ __('라우트/URL') }}</span>
                                            {!! $renderSortIcon('route_name') !!}
                                        </a>
                                    </th>
                                    <th scope="col" class="px-3 py-3 text-center text-sm font-semibold text-gray-900 dark:text-white">
                                        <a href="{{ route('admin.menus.index', array_merge(request()->query(), ['sort' => 'is_active', 'direction' => $getNextDirection('is_active')])) }}" class="{{ $sortLinkClass }}">
                                            <span>{{ __('상태') }}</span>
                                            {!! $renderSortIcon('is_active') !!}
                                        </a>
                                    </th>
                                    <th scope="col" class="relative py-3 pr-4 pl-3 sm:pr-0">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                @forelse ($menus as $menu)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/70">
                                        <td class="whitespace-nowrap py-3 pr-3 pl-4 text-sm sm:pl-0">
                                            <x-laravel-admin::admin.checkbox :value="$menu->id" />
                                        </td>
                                        <td class="py-3 pr-3 pl-3 text-sm">
                                            <div class="flex items-center gap-3">
                                                <div class="flex size-9 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-indigo-700 ring-1 ring-indigo-100 dark:bg-indigo-500/10 dark:text-indigo-300 dark:ring-indigo-500/20">
                                                    <x-laravel-admin::admin.icon :name="$menu->icon ?: 'bars'" class="text-xs" />
                                                </div>
                                                <div class="min-w-0">
                                                    @can('view', $menu)
                                                        <a href="{{ route('admin.menus.show', $menu) }}" class="font-semibold !text-gray-900 hover:!text-indigo-600 hover:no-underline dark:!text-white dark:hover:!text-indigo-400">
                                                            {{ $menu->name }}
                                                        </a>
                                                    @else
                                                        <span class="font-semibold text-gray-900 dark:text-white">{{ $menu->name }}</span>
                                                    @endcan
                                                    <div class="mt-0.5 flex flex-wrap items-center gap-1.5 text-xs text-gray-500 md:hidden dark:text-gray-400">
                                                        <span>{{ $menu->category ? $menu->category->name : '-' }}</span>
                                                        <span aria-hidden="true">/</span>
                                                        <span>{{ $menu->route_name ?: ($menu->url ?: '-') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="hidden whitespace-nowrap px-3 py-3 text-center text-sm text-gray-600 md:table-cell dark:text-gray-300">
                                            @if($menu->category)
                                                <button
                                                    type="button"
                                                    class="cursor-pointer font-medium text-indigo-600 hover:text-indigo-800 dark:text-indigo-300 dark:hover:text-indigo-200"
                                                    onclick="openMenuOrderModal({{ $menu->category->id }}, @js($menu->category->name))"
                                                >
                                                    {{ $menu->category->name }}
                                                </button>
                                            @else
                                                <span class="text-gray-400 dark:text-gray-500">-</span>
                                            @endif
                                        </td>
                                        <td class="hidden max-w-xs px-3 py-3 text-center text-sm text-gray-600 lg:table-cell dark:text-gray-300">
                                            @if($menu->route_name)
                                                <a href="{{ $menu->url }}" target="{{ $menu->target ?? '_self' }}" class="font-medium !text-gray-900 hover:!text-indigo-600 hover:no-underline dark:!text-white dark:hover:!text-indigo-400">
                                                    {{ $menu->route_name }}
                                                </a>
                                                @if($menu->route_parameters)
                                                    <div class="mt-1 truncate text-center text-xs text-gray-400 dark:text-gray-500">{{ $menu->route_parameters }}</div>
                                                @endif
                                            @elseif($menu->url && $menu->url !== '#')
                                                <a href="{{ $menu->url }}" target="{{ $menu->target ?? '_self' }}" class="break-all !text-gray-700 hover:!text-indigo-600 hover:no-underline dark:!text-gray-300 dark:hover:!text-indigo-400">
                                                    {{ $menu->url }}
                                                </a>
                                            @else
                                                <span class="text-gray-500 dark:text-gray-400">{{ $menu->url ?: '-' }}</span>
                                            @endif

                                            @if($menu->is_external)
                                                <x-laravel-admin::admin.badge variant="warning" class="ml-1 px-1.5 py-0.5">{{ __('외부') }}</x-laravel-admin::admin.badge>
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-3 text-center text-sm">
                                            <x-laravel-admin::admin.badge variant="{{ $menu->is_active ? 'success' : 'danger' }}">
                                                {{ $menu->is_active ? __('활성') : __('비활성') }}
                                            </x-laravel-admin::admin.badge>
                                        </td>
                                        <td class="whitespace-nowrap py-3 pr-4 pl-3 text-right text-sm font-medium sm:pr-0">
                                            <div class="flex justify-end">
                                                <x-laravel-admin::admin.action-menu>
                                                    @can('view', $menu)
                                                        <x-laravel-admin::admin.dropdown-link :href="route('admin.menus.show', $menu)" class="rounded-lg px-6 py-1 text-left text-base leading-6 !text-gray-950 hover:!bg-blue-500 hover:!text-white hover:!no-underline focus:!bg-blue-500 focus:!text-white dark:!text-gray-100">
                                                            {{ __('상세보기') }}
                                                        </x-laravel-admin::admin.dropdown-link>
                                                    @endcan
                                                    @can('update', $menu)
                                                        <x-laravel-admin::admin.dropdown-link :href="route('admin.menus.edit', $menu)" class="rounded-lg px-6 py-1 text-left text-base leading-6 !text-gray-950 hover:!bg-blue-500 hover:!text-white hover:!no-underline focus:!bg-blue-500 focus:!text-white dark:!text-gray-100">
                                                            {{ __('수정') }}
                                                        </x-laravel-admin::admin.dropdown-link>
                                                    @endcan
                                                </x-laravel-admin::admin.action-menu>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-12 text-center text-sm text-gray-500 dark:text-gray-400">
                                            @if(request('search'))
                                                {{ __('":keyword"에 대한 검색 결과가 없습니다.', ['keyword' => request('search')]) }}
                                            @else
                                                {{ __('등록된 메뉴가 없습니다.') }}
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
                {!! $menus->appends(request()->query())->links() !!}
            </div>
        </div>
    </div>

    <livewire:admin.modal-stack />

    <script>
        function openCategorySelectionModal() {
            const selectedIds = getSelectedCheckboxValues();
            if (selectedIds.length === 0) {
                alert('{{ __('카테고리를 변경할 메뉴를 먼저 선택해주세요.') }}');
                return;
            }

            Livewire.dispatch('admin:modal-stack:push', {
                id: 'change-category-' + Date.now(),
                component: 'admin.menus.change-category-modal',
                params: { selectedMenuIds: selectedIds },
                title: '메뉴 카테고리 변경',
                size: 'md',
                width: 500,
                height: 700,
                closeOnBackdrop: false
            });
        }

        function openMenuOrderModal(categoryId, categoryName) {
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
        }

        document.addEventListener('DOMContentLoaded', function() {
            Livewire.on('menu-order-modal:refresh-page', () => {
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            });

            Livewire.on('admin-menus:menu-order-modal:notification', (data) => {
                if (window.menuOrderNotificationListenerRegistered && document.getElementById('menu-list-sortable')) {
                    return;
                }

                if (typeof window.showMenuOrderNotification === 'function') {
                    window.showMenuOrderNotification(data.message, data.type || 'error');
                } else {
                    alert(data.message);
                }
            });
        });
    </script>
</x-laravel-admin::admin.layouts.admin>
