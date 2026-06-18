<x-laravel-admin::admin.layouts.admin title="권한 관리">

    <x-slot name="header">

        <x-laravel-admin::admin.admin-header>
            <x-slot name="navigation">
                <a href="{{ route('admin.index') }}">{{ __('Admin Home') }}</a>
            </x-slot>
            <x-slot name="description">
                {{ __('권한 목록') }}
            </x-slot>
        </x-laravel-admin::admin.admin-header>

    </x-slot>


    <div class="w-full bg-white px-2 py-2 dark:bg-gray-900">
        <div class="min-h-[560px] bg-white px-4 py-6 sm:px-6 lg:px-8 dark:bg-gray-900">
            <div class="sm:flex sm:items-center sm:justify-between">
                <div class="sm:flex-auto">
                    <h1 class="text-2xl font-semibold leading-7 text-gray-900 dark:text-white">{{ __('권한 목록') }}</h1>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-600 dark:text-gray-400">
                        {{ __('관리자 권한 이름, 설명, 정렬 순서를 관리합니다.') }}
                    </p>
                    @if(request('search'))
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">"{{ request('search') }}" 검색 결과</p>
                    @endif
                </div>

                <div class="mt-4 flex flex-wrap gap-2 sm:mt-0 sm:ml-16 sm:flex-none">
                    @can('create', arguments: Ssh521\LaravelAdmin\Models\Permission::class)
                        <a href="{{ route('admin.permissions.create') }}" class="inline-flex h-9 items-center justify-center rounded-md bg-indigo-600 px-3 text-sm font-semibold !text-white shadow-sm hover:bg-indigo-500 hover:no-underline dark:bg-indigo-500 dark:hover:bg-indigo-400">
                            <x-laravel-admin::admin.icon name="plus" class="mr-2 text-xs" />
                            {{ __('등록하기') }}
                        </a>
                    @endcan
                </div>
            </div>

            <x-laravel-admin::admin.session-messages />

            <form class="mt-6 flex flex-col gap-3 rounded-lg border border-gray-200 bg-gray-50 p-4 sm:flex-row sm:items-center dark:border-gray-700 dark:bg-gray-800/70" action="{{ route('admin.permissions.index') }}" method="GET">
                @if(request('sort'))
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                @endif
                @if(request('direction'))
                    <input type="hidden" name="direction" value="{{ request('direction') }}">
                @endif
                <label for="permission-search" class="sr-only">권한 검색</label>
                <div class="relative min-w-0 flex-1">
                    <input id="permission-search" type="text" name="search" value="{{ request('search') }}"
                        class="h-10 w-full rounded-md border border-gray-300 bg-white px-3 pr-9 text-sm text-gray-900 shadow-sm outline-none placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-gray-600 dark:bg-gray-900 dark:text-white"
                        placeholder="권한 이름 또는 설명 검색">
                    @if(request('search'))
                        <a href="{{ route('admin.permissions.index') }}"
                           class="absolute right-3 top-1/2 -translate-y-1/2 !text-gray-400 hover:!text-gray-600 hover:no-underline dark:hover:!text-gray-300">
                            <x-laravel-admin::admin.icon name="xmark" class="text-sm" />
                        </a>
                    @endif
                </div>

                <button type="submit"
                    class="inline-flex h-10 w-full cursor-pointer items-center justify-center rounded-md bg-gray-900 px-4 text-sm font-semibold text-white shadow-sm hover:bg-gray-700 sm:w-auto dark:bg-white dark:text-gray-900 dark:hover:bg-gray-200">
                    <x-laravel-admin::admin.icon name="magnifying-glass" class="mr-2 text-xs" />
                    {{ __('검색') }}
                </button>
            </form>

            <div class="mt-6" x-data="permissionSortable()" x-init="initSortable()">
                <div class="mb-4 flex flex-col gap-3 rounded-lg border border-gray-200 bg-white p-3 sm:flex-row sm:items-center sm:justify-between dark:border-gray-700 dark:bg-gray-900">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('정렬 방식') }}</span>
                        <button type="button" @click="setSortMode('drag')"
                                :class="sortMode === 'drag' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 ring-1 ring-gray-300 hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-100 dark:ring-gray-600 dark:hover:bg-gray-700'"
                                class="inline-flex h-8 cursor-pointer items-center rounded-md px-3 text-sm font-semibold shadow-sm">
                            <x-laravel-admin::admin.icon name="grip-vertical" class="mr-1.5 text-xs" />
                            {{ __('Drag Sort') }}
                        </button>
                        <button type="button" @click="setSortMode('click')"
                                :class="sortMode === 'click' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 ring-1 ring-gray-300 hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-100 dark:ring-gray-600 dark:hover:bg-gray-700'"
                                class="inline-flex h-8 cursor-pointer items-center rounded-md px-3 text-sm font-semibold shadow-sm">
                            <x-laravel-admin::admin.icon name="arrow-up-wide-short" class="mr-1.5 text-xs" />
                            {{ __('Click Sort') }}
                        </button>
                    </div>
                    <div x-show="sortMode === 'drag'" class="text-sm text-gray-500 dark:text-gray-400">
                        {{ __('Drag rows to reorder') }}
                    </div>
                </div>

                <div class="flow-root">
                    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                            <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                                <thead>
                                    <tr>
                                        <th scope="col" class="w-10 py-3.5 pr-3 pl-4 text-left text-sm font-semibold text-gray-900 sm:pl-0 dark:text-white">
                                            <span x-show="sortMode === 'drag'" class="text-gray-400">⋮⋮</span>
                                        </th>
                                        <th scope="col" class="py-3.5 pr-3 pl-3 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                            <button type="button" x-show="sortMode === 'click'"
                                                    @click="sortBy('name')"
                                                    class="inline-flex cursor-pointer items-center gap-1 text-sm font-semibold text-gray-900 hover:text-indigo-600 dark:text-white dark:hover:text-indigo-300">
                                                <span>{{ __('Permission Name') }}</span>
                                                <x-laravel-admin::admin.icon name="arrow-up" x-show="sortField === 'name' && sortDirection === 'asc'" class="text-xs" />
                                                <x-laravel-admin::admin.icon name="arrow-down" x-show="sortField === 'name' && sortDirection === 'desc'" class="text-xs" />
                                                <x-laravel-admin::admin.icon name="sort" x-show="sortField !== 'name'" class="text-xs text-gray-400" />
                                            </button>
                                            <span x-show="sortMode === 'drag'">{{ __('Permission Name') }}</span>
                                        </th>
                                        <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 md:table-cell dark:text-white">
                                            <button type="button" x-show="sortMode === 'click'"
                                                    @click="sortBy('description')"
                                                    class="inline-flex cursor-pointer items-center gap-1 text-sm font-semibold text-gray-900 hover:text-indigo-600 dark:text-white dark:hover:text-indigo-300">
                                                <span>{{ __('Permission Description') }}</span>
                                                <x-laravel-admin::admin.icon name="arrow-up" x-show="sortField === 'description' && sortDirection === 'asc'" class="text-xs" />
                                                <x-laravel-admin::admin.icon name="arrow-down" x-show="sortField === 'description' && sortDirection === 'desc'" class="text-xs" />
                                                <x-laravel-admin::admin.icon name="sort" x-show="sortField !== 'description'" class="text-xs text-gray-400" />
                                            </button>
                                            <span x-show="sortMode === 'drag'">{{ __('Permission Description') }}</span>
                                        </th>
                                        <th scope="col" class="relative py-3.5 pr-4 pl-3 sm:pr-0">
                                            <span class="sr-only">Actions</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="sortable-permissions" class="divide-y divide-gray-200 bg-white dark:divide-gray-800 dark:bg-gray-900">
                                    @forelse ($data as $permission)
                                        <tr data-id="{{ $permission->id }}"
                                            class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-800/80"
                                            :class="sortMode === 'drag' ? 'cursor-move' : 'cursor-default'">
                                            <td class="py-4 pr-3 pl-4 text-sm sm:pl-0">
                                                <span x-show="sortMode === 'drag'" class="cursor-move text-gray-400">⋮⋮</span>
                                            </td>
                                            <th scope="row" class="py-4 pr-3 pl-3 text-left text-sm">
                                                <div class="font-medium text-gray-900 dark:text-white">{{ $permission->name }}</div>
                                                <div class="mt-1 text-xs text-gray-500 md:hidden dark:text-gray-400">{{ $permission->description ?: '설명 없음' }}</div>
                                            </th>
                                            <td class="hidden px-3 py-4 text-sm text-gray-500 md:table-cell dark:text-gray-400">
                                                {{ $permission->description ?: '설명 없음' }}
                                            </td>
                                            <td class="py-4 pr-4 pl-3 text-right text-sm font-medium whitespace-nowrap sm:pr-0">
                                                @can('view', $permission)
                                                    <a class="inline-flex items-center rounded-md px-2 py-1 text-sm font-semibold !text-indigo-600 hover:bg-indigo-50 hover:no-underline dark:!text-indigo-300 dark:hover:bg-indigo-500/10"
                                                        href="{{ route('admin.permissions.show', $permission) }}">
                                                        <x-laravel-admin::admin.icon name="eye" class="mr-1.5 text-xs" />
                                                        {{ __('보기') }}
                                                    </a>
                                                @endcan
                                                @can('update', $permission)
                                                    <a class="ml-1 inline-flex items-center rounded-md px-2 py-1 text-sm font-semibold !text-indigo-600 hover:bg-indigo-50 hover:no-underline dark:!text-indigo-300 dark:hover:bg-indigo-500/10"
                                                        href="{{ route('admin.permissions.edit', $permission) }}">
                                                        <x-laravel-admin::admin.icon name="pen-to-square" class="mr-1.5 text-xs" />
                                                        {{ __('수정') }}
                                                    </a>
                                                @endcan
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-3 py-16 text-center text-sm text-gray-500 dark:text-gray-400">
                                                @if(request('search'))
                                                    {{ __('No search results found for') }} "{{ request('search') }}".
                                                @else
                                                    {{ __('No permissions registered.') }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            @if($data->hasPages())
                <div class="mt-6 text-sm">
                    {!! $data->withQueryString()->links() !!}
                </div>
            @endif
        </div>
    </div>

    <script>
        function permissionSortable() {
            return {
                sortMode: 'click', // 'click' or 'drag'
                sortField: '{{ request('sort', 'name') }}',
                sortDirection: '{{ request('direction', 'asc') }}',
                sortableInstance: null,
                permissions: @json($data->items()),

                initSortable() {
                    this.$nextTick(() => {
                        this.initSortableInstance();
                    });
                },

                initSortableInstance() {
                    if (this.sortMode === 'drag') {
                        const tbody = document.getElementById('sortable-permissions');
                        if (tbody && !this.sortableInstance) {
                            this.sortableInstance = new Sortable(tbody, {
                                animation: 150,
                                ghostClass: 'opacity-40',
                                chosenClass: 'bg-gray-100',
                                dragClass: 'bg-gray-200',
                                handle: '.cursor-move',
                                onEnd: (evt) => {
                                    this.updateOrder(evt);
                                }
                            });
                        }
                    } else {
                        if (this.sortableInstance) {
                            this.sortableInstance.destroy();
                            this.sortableInstance = null;
                        }
                    }
                },

                setSortMode(mode) {
                    this.sortMode = mode;
                    this.initSortableInstance();
                },

                sortBy(field) {
                    if (this.sortField === field) {
                        this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
                    } else {
                        this.sortField = field;
                        this.sortDirection = 'asc';
                    }
                    this.performSort();
                },

                performSort() {
                    const url = new URL(window.location);
                    url.searchParams.set('sort', this.sortField);
                    url.searchParams.set('direction', this.sortDirection);
                    window.location.href = url.toString();
                },

                updateOrder(evt) {
                    const pageOffset = ({{ $data->currentPage() }} - 1) * {{ $data->perPage() }};
                    const newOrder = Array.from(evt.to.children).map((row, index) => ({
                        id: row.dataset.id,
                        order: pageOffset + index + 1
                    }));

                    // 서버에 새로운 순서 저장
                    fetch('{{ route("admin.permissions.update-order") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ order: newOrder })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // 성공 메시지 표시
                            this.showNotification('{{ __("Order updated successfully") }}', 'success');
                        } else {
                            // 오류 메시지 표시
                            this.showNotification('{{ __("Failed to update order") }}', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        this.showNotification('{{ __("An error occurred") }}', 'error');
                    });
                },

                showNotification(message, type) {
                    // 간단한 알림 표시 (실제 프로젝트에서는 더 정교한 알림 시스템 사용)
                    const notification = document.createElement('div');
                    notification.className = `fixed top-4 right-4 p-4 rounded-md text-white z-50 ${
                        type === 'success' ? 'bg-green-500' : 'bg-red-500'
                    }`;
                    notification.textContent = message;
                    document.body.appendChild(notification);

                    setTimeout(() => {
                        notification.remove();
                    }, 3000);
                }
            }
        }
    </script>

</x-laravel-admin::admin.layouts.admin>
