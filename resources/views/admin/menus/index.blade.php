{{-- 메뉴 관리 페이지 - 메뉴 목록 조회, 검색, 정렬, 순서 변경 기능 --}}
<x-laravel-admin::admin.layouts.admin title="메뉴 관리">
    <x-slot name="header">
        <x-laravel-admin::admin.admin-header>
            <x-slot name="navigation">
                <a href="{{ route('admin.index') }}">관리자 홈</a>
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

        $renderSortIcon = function ($field) use ($currentSort, $currentDirection) {
            if ($currentSort !== $field) return '';

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
                        <a href="{{ route('admin.menus.create') }}" class="inline-flex h-10 items-center justify-center rounded-md bg-indigo-600 px-4 text-sm font-semibold !text-white shadow-sm hover:bg-indigo-500 hover:no-underline dark:bg-indigo-500 dark:hover:bg-indigo-400">
                            <x-laravel-admin::admin.icon name="plus" class="mr-2 text-xs" />
                            {{ __('등록하기') }}
                        </a>
                    @endcan
                </div>
            </div>

            <x-laravel-admin::admin.session-messages />

            <div class="mt-6 rounded-md border border-gray-200 bg-gray-50 p-3 dark:border-gray-700 dark:bg-gray-800/60">
                <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
                    <div class="flex flex-wrap items-center gap-2 text-sm">
                        <x-laravel-admin::admin.checkbox-controls />
                        <button type="button" onclick="openCategorySelectionModal()" class="inline-flex h-9 cursor-pointer items-center justify-center rounded-md border border-gray-300 bg-white px-3 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 dark:hover:bg-gray-800">
                            <x-laravel-admin::admin.icon name="tags" class="mr-2 text-xs" />
                            {{ __('분류선택') }}
                        </button>
                    </div>

                    <form class="flex flex-col gap-2 sm:flex-row sm:items-center" action="{{ route('admin.menus.index') }}" method="GET">
                        <label for="menu-search" class="sr-only">Search</label>
                        <input
                            id="menu-search"
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            class="h-10 w-full rounded-md border border-gray-300 bg-white px-3 text-sm text-gray-900 shadow-sm outline-none placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 sm:w-72 dark:border-gray-600 dark:bg-gray-900 dark:text-white"
                            placeholder="{{ __('메뉴 검색') }}"
                        >

                        <div class="flex gap-2">
                            @if(request('search'))
                                <a href="{{ route('admin.menus.index') }}" class="inline-flex h-10 items-center justify-center rounded-md border border-gray-300 bg-white px-4 text-sm font-semibold !text-gray-700 shadow-sm hover:bg-gray-50 hover:no-underline dark:border-gray-600 dark:bg-gray-900 dark:!text-gray-100 dark:hover:bg-gray-800">
                                    {{ __('초기화') }}
                                </a>
                            @endif

                            <button type="submit" class="inline-flex h-10 cursor-pointer items-center justify-center rounded-md bg-indigo-600 px-4 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 dark:bg-indigo-500 dark:hover:bg-indigo-400">
                                {{ __('검색') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="mt-6 flow-root">
                <div class="-mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr>
                                    <th scope="col" class="py-3.5 pr-3 pl-4 text-left text-sm font-semibold text-gray-900 sm:pl-0 dark:text-white">
                                        <span class="sr-only">Select</span>
                                    </th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                        <a href="{{ route('admin.menus.index', array_merge(request()->query(), ['sort' => 'name', 'direction' => $getNextDirection('name')])) }}" class="inline-flex items-center gap-1 !text-gray-900 hover:!text-indigo-600 hover:no-underline dark:!text-white dark:hover:!text-indigo-400">
                                            {{ __('메뉴명') }}
                                            {!! $renderSortIcon('name') !!}
                                        </a>
                                    </th>
                                    <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 md:table-cell dark:text-white">
                                        @if(empty(request('search')))
                                            <a href="{{ route('admin.menus.index', array_merge(request()->query(), ['sort' => 'category', 'direction' => $getNextDirection('category')])) }}" class="inline-flex items-center gap-1 !text-gray-900 hover:!text-indigo-600 hover:no-underline dark:!text-white dark:hover:!text-indigo-400">
                                                {{ __('카테고리') }}
                                                {!! $renderSortIcon('category') !!}
                                            </a>
                                        @else
                                            {{ __('카테고리') }}
                                        @endif
                                    </th>
                                    <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell dark:text-white">{{ __('라우트/URL') }}</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">{{ __('상태') }}</th>
                                    <th scope="col" class="relative py-3.5 pr-4 pl-3 sm:pr-0">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                @forelse ($menus as $menu)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/70">
                                        <td class="whitespace-nowrap py-4 pr-3 pl-4 text-sm sm:pl-0">
                                            <x-laravel-admin::admin.checkbox :value="$menu->id" />
                                        </td>
                                        <td class="py-4 pr-3 pl-3 text-sm">
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
                                                    <div class="mt-1 flex flex-wrap items-center gap-1.5 text-xs text-gray-500 md:hidden dark:text-gray-400">
                                                        <span>{{ $menu->category ? $menu->category->name : '-' }}</span>
                                                        <span aria-hidden="true">/</span>
                                                        <span>{{ $menu->route_name ?: ($menu->url ?: '-') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="hidden whitespace-nowrap px-3 py-4 text-sm text-gray-600 md:table-cell dark:text-gray-300">
                                            @if($menu->category)
                                                <x-laravel-admin::admin.modal-trigger
                                                    text="{{ $menu->category->name }}"
                                                    modal-id="menu-order-modal"
                                                    variant="primary"
                                                    type="link"
                                                    data-category-id="{{ $menu->category->id }}"
                                                    data-category-name="{{ $menu->category->name }}"
                                                    modal-type="single"
                                                />
                                            @else
                                                <span class="text-gray-400 dark:text-gray-500">-</span>
                                            @endif
                                        </td>
                                        <td class="hidden max-w-xs px-3 py-4 text-sm text-gray-600 lg:table-cell dark:text-gray-300">
                                            @if($menu->route_name)
                                                <a href="{{ $menu->url }}" target="{{ $menu->target ?? '_self' }}" class="font-medium !text-gray-900 hover:!text-indigo-600 hover:no-underline dark:!text-white dark:hover:!text-indigo-400">
                                                    {{ $menu->route_name }}
                                                </a>
                                                @if($menu->route_parameters)
                                                    <div class="mt-1 truncate text-xs text-gray-400 dark:text-gray-500">{{ $menu->route_parameters }}</div>
                                                @endif
                                            @elseif($menu->url && $menu->url !== '#')
                                                <a href="{{ $menu->url }}" target="{{ $menu->target ?? '_self' }}" class="break-all !text-gray-700 hover:!text-indigo-600 hover:no-underline dark:!text-gray-300 dark:hover:!text-indigo-400">
                                                    {{ $menu->url }}
                                                </a>
                                            @else
                                                <span class="text-gray-500 dark:text-gray-400">{{ $menu->url ?: '-' }}</span>
                                            @endif

                                            @if($menu->is_external)
                                                <span class="ml-1 inline-flex items-center rounded-md bg-amber-50 px-1.5 py-0.5 text-xs font-medium text-amber-700 ring-1 ring-amber-600/20 ring-inset dark:bg-amber-500/10 dark:text-amber-300 dark:ring-amber-500/20">{{ __('외부') }}</span>
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm">
                                            <span class="{{ $menu->is_active ? 'bg-green-50 text-green-700 ring-green-600/20 dark:bg-green-500/10 dark:text-green-300 dark:ring-green-500/20' : 'bg-red-50 text-red-700 ring-red-600/20 dark:bg-red-500/10 dark:text-red-300 dark:ring-red-500/20' }} inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset">
                                                {{ $menu->is_active ? __('활성') : __('비활성') }}
                                            </span>
                                        </td>
                                        <td class="whitespace-nowrap py-4 pr-4 pl-3 text-right text-sm font-medium sm:pr-0">
                                            <div class="flex justify-end gap-3">
                                                @can('view', $menu)
                                                    <a href="{{ route('admin.menus.show', $menu) }}" class="inline-flex items-center font-semibold !text-indigo-600 hover:!text-indigo-500 hover:no-underline dark:!text-indigo-400">
                                                        <x-laravel-admin::admin.icon name="eye" class="mr-1.5 text-xs" />
                                                        {{ __('상세보기') }}
                                                    </a>
                                                @endcan
                                                @can('update', $menu)
                                                    <a href="{{ route('admin.menus.edit', $menu) }}" class="inline-flex items-center font-semibold !text-indigo-600 hover:!text-indigo-500 hover:no-underline dark:!text-indigo-400">
                                                        <x-laravel-admin::admin.icon name="pen-to-square" class="mr-1.5 text-xs" />
                                                        {{ __('수정') }}
                                                    </a>
                                                @endcan
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

    <x-laravel-admin::admin.draggable-modal
        id="category-selection-modal"
        title="메뉴 카테고리 변경"
        width="500"
        height="700"
        :close-on-backdrop-click="false"
    >
        <livewire:admin.menus.change-category-modal />
    </x-laravel-admin::admin.draggable-modal>

    <x-laravel-admin::admin.draggable-modal
        id="menu-order-modal"
        title="메뉴 순서 변경"
        width="600"
        height="500"
        :close-on-backdrop-click="false"
    >
        <livewire:admin.menus.menu-order-modal />
    </x-laravel-admin::admin.draggable-modal>

    <script>
        function openCategorySelectionModal() {
            const selectedIds = getSelectedCheckboxValues();
            if (selectedIds.length === 0) {
                alert('{{ __('카테고리를 변경할 메뉴를 먼저 선택해주세요.') }}');
                return;
            }

            Livewire.dispatch('admin-menus:change-category-modal:set-selected', { ids: selectedIds });

            window.dispatchEvent(new CustomEvent('open-modal', {
                detail: { modalId: 'category-selection-modal' }
            }));
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('[data-category-id]').forEach(button => {
                button.addEventListener('click', function() {
                    const categoryId = this.getAttribute('data-category-id');
                    const categoryName = this.getAttribute('data-category-name');
                    if (categoryId && categoryName) {
                        window.dispatchEvent(new CustomEvent('open-modal', {
                            detail: { modalId: 'menu-order-modal' }
                        }));

                        Livewire.dispatch('admin-menus:menu-order-modal:open', {
                            data: {
                                categoryId: parseInt(categoryId),
                                categoryName: categoryName
                            }
                        });
                    }
                });
            });

            Livewire.on('menu-order-modal:refresh-page', () => {
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            });

            Livewire.on('admin-menus:menu-order-modal:notification', (data) => {
                alert(data.message);
            });
        });
    </script>
</x-laravel-admin::admin.layouts.admin>
