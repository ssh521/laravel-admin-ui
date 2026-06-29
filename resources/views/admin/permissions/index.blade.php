<x-laravel-admin::admin.layouts.admin title="권한 관리">

    <x-slot name="header">

        <x-laravel-admin::admin.admin-header>
            <x-slot name="navigation">
                <a href="{{ route('admin.index') }}">{{ __('관리자 홈') }}</a>
            </x-slot>
            <x-slot name="description">
                {{ __('권한 목록') }}
            </x-slot>
        </x-laravel-admin::admin.admin-header>

    </x-slot>


    <x-laravel-admin::admin.page-section
        title="{{ __('권한 목록') }}"
        description="{{ __('관리자 권한 이름, 설명, 정렬 순서를 관리합니다.') }}"
    >
            <x-slot name="actions">
                @can('create', arguments: Ssh521\LaravelAdmin\Models\Permission::class)
                    <x-laravel-admin::admin.action-button :href="route('admin.permissions.create')" size="sm" icon="plus">
                        {{ __('등록하기') }}
                    </x-laravel-admin::admin.action-button>
                @endcan
            </x-slot>

            @if(request('search'))
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">"{{ request('search') }}" 검색 결과</p>
            @endif

            <x-laravel-admin::admin.session-messages />

            <x-laravel-admin::admin.filter-bar action="{{ route('admin.permissions.index') }}">
                @if(request('sort'))
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                @endif
                @if(request('direction'))
                    <input type="hidden" name="direction" value="{{ request('direction') }}">
                @endif
                <label for="permission-search" class="sr-only">권한 검색</label>
                <div class="relative min-w-0 flex-1">
                    <x-laravel-admin::admin.form-input id="permission-search" name="search" value="{{ request('search') }}" class="h-10 pr-9" placeholder="권한 이름 또는 설명 검색" />
                    @if(request('search'))
                        <a href="{{ route('admin.permissions.index') }}"
                           class="absolute right-3 top-1/2 -translate-y-1/2 !text-gray-400 hover:!text-gray-600 hover:no-underline dark:hover:!text-gray-300">
                            <x-laravel-admin::admin.icon name="xmark" class="text-sm" />
                        </a>
                    @endif
                </div>

                <x-laravel-admin::admin.action-button type="submit" variant="search" icon="magnifying-glass" class="w-full shrink-0 whitespace-nowrap sm:w-auto">
                    {{ __('검색') }}
                </x-laravel-admin::admin.action-button>
            </x-laravel-admin::admin.filter-bar>

            <div class="mt-6" x-data="permissionDragSort()" x-init="initNativeDrag()">
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

                <x-laravel-admin::admin.table-shell>
                            <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                                <thead class="border-y border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-800/80">
                                    <tr>
                                        <th scope="col" class="w-10 py-3 pr-3 pl-4 text-left text-sm font-semibold text-gray-900 sm:pl-0 dark:text-white">
                                            <span x-show="sortMode === 'drag'" class="text-gray-400">⋮⋮</span>
                                        </th>
                                        <th scope="col" class="py-3 pr-3 pl-3 text-center text-sm font-semibold text-gray-900 dark:text-white">
                                            <button type="button" x-show="sortMode === 'click'"
                                                    @click="sortBy('name')"
                                                    class="inline-flex cursor-pointer items-center justify-center gap-1 text-sm font-semibold text-gray-900 hover:text-indigo-600 dark:text-white dark:hover:text-indigo-300">
                                                <span>{{ __('Permission Name') }}</span>
                                                <x-laravel-admin::admin.icon name="arrow-up" x-show="sortField === 'name' && sortDirection === 'asc'" class="text-xs" />
                                                <x-laravel-admin::admin.icon name="arrow-down" x-show="sortField === 'name' && sortDirection === 'desc'" class="text-xs" />
                                                <x-laravel-admin::admin.icon name="sort" x-show="sortField !== 'name'" class="text-xs text-gray-400" />
                                            </button>
                                            <span x-show="sortMode === 'drag'">{{ __('Permission Name') }}</span>
                                        </th>
                                        <th scope="col" class="hidden px-3 py-3 text-center text-sm font-semibold text-gray-900 md:table-cell dark:text-white">
                                            <button type="button" x-show="sortMode === 'click'"
                                                    @click="sortBy('description')"
                                                    class="inline-flex cursor-pointer items-center justify-center gap-1 text-sm font-semibold text-gray-900 hover:text-indigo-600 dark:text-white dark:hover:text-indigo-300">
                                                <span>{{ __('Permission Description') }}</span>
                                                <x-laravel-admin::admin.icon name="arrow-up" x-show="sortField === 'description' && sortDirection === 'asc'" class="text-xs" />
                                                <x-laravel-admin::admin.icon name="arrow-down" x-show="sortField === 'description' && sortDirection === 'desc'" class="text-xs" />
                                                <x-laravel-admin::admin.icon name="sort" x-show="sortField !== 'description'" class="text-xs text-gray-400" />
                                            </button>
                                            <span x-show="sortMode === 'drag'">{{ __('Permission Description') }}</span>
                                        </th>
                                        <th scope="col" class="relative py-3 pr-4 pl-3 sm:pr-0">
                                            <span class="sr-only">Actions</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="sortable-permissions" class="divide-y divide-gray-200 bg-white dark:divide-gray-800 dark:bg-gray-900">
                                    @forelse ($data as $permission)
                                        <tr data-id="{{ $permission->id }}"
                                            class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-800/80"
                                            :class="sortMode === 'drag' ? 'cursor-move' : 'cursor-default'"
                                            :draggable="sortMode === 'drag'"
                                            @dragstart="startDrag($event)"
                                            @dragover.prevent="dragOver($event)"
                                            @drop.prevent="dropRow($event)"
                                            @dragend="endDrag()">
                                            <td class="py-3 pr-3 pl-4 text-sm sm:pl-0">
                                                <span x-show="sortMode === 'drag'" class="cursor-move text-gray-400">⋮⋮</span>
                                            </td>
                                            <th scope="row" class="py-3 pr-3 pl-3 text-left text-sm">
                                                <div class="font-medium text-gray-900 dark:text-white">{{ $permission->name }}</div>
                                                <div class="mt-0.5 text-xs text-gray-500 md:hidden dark:text-gray-400">{{ $permission->description ?: '설명 없음' }}</div>
                                            </th>
                                            <td class="hidden px-3 py-3 text-center text-sm text-gray-500 md:table-cell dark:text-gray-400">
                                                {{ $permission->description ?: '설명 없음' }}
                                            </td>
                                            <td class="py-3 pr-4 pl-3 text-right text-sm font-medium whitespace-nowrap sm:pr-0">
                                                @can('view', $permission)
                                                    <x-laravel-admin::admin.action-button variant="link" size="sm" :href="route('admin.permissions.show', $permission)" icon="eye" class="h-auto px-2 py-1">
                                                        {{ __('보기') }}
                                                    </x-laravel-admin::admin.action-button>
                                                @endcan
                                                @can('update', $permission)
                                                    <x-laravel-admin::admin.action-button variant="link" size="sm" :href="route('admin.permissions.edit', $permission)" icon="pen-to-square" class="ml-1 h-auto px-2 py-1">
                                                        {{ __('수정') }}
                                                    </x-laravel-admin::admin.action-button>
                                                @endcan
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-3 py-6">
                                                <x-laravel-admin::admin.empty-state>
                                                    @if(request('search'))
                                                        {{ __('No search results found for') }} "{{ request('search') }}".
                                                    @else
                                                        {{ __('No permissions registered.') }}
                                                    @endif
                                                </x-laravel-admin::admin.empty-state>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                </x-laravel-admin::admin.table-shell>
            </div>

            @if($data->hasPages())
                <div class="mt-6 text-sm">
                    {!! $data->withQueryString()->links() !!}
                </div>
            @endif
    </x-laravel-admin::admin.page-section>

    <script>
        function permissionDragSort() {
            return {
                sortMode: 'click', // 'click' or 'drag'
                sortField: '{{ request('sort', 'name') }}',
                sortDirection: '{{ request('direction', 'asc') }}',
                draggedRow: null,
                permissions: @json($data->items()),

                initNativeDrag() {},

                setSortMode(mode) {
                    this.sortMode = mode;
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

                startDrag(event) {
                    if (this.sortMode !== 'drag') {
                        event.preventDefault();
                        return;
                    }

                    this.draggedRow = event.currentTarget;
                    this.draggedRow.classList.add('opacity-40');
                    event.dataTransfer.effectAllowed = 'move';
                    event.dataTransfer.setData('text/plain', this.draggedRow.dataset.id);
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

                    this.updateOrder();
                    this.endDrag();
                },

                endDrag() {
                    if (this.draggedRow) {
                        this.draggedRow.classList.remove('opacity-40');
                    }

                    this.draggedRow = null;
                },

                updateOrder() {
                    const pageOffset = ({{ $data->currentPage() }} - 1) * {{ $data->perPage() }};
                    const tbody = document.getElementById('sortable-permissions');
                    const newOrder = Array.from(tbody.querySelectorAll('tr[data-id]')).map((row, index) => ({
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
