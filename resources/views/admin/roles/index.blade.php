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

                    <x-laravel-admin::admin.action-button
                        type="button"
                        variant="secondary"
                        size="sm"
                        icon="folder-open"
                        onclick="Livewire.dispatch('admin:modal-stack:push', { id: 'menu-category-manager-' + Date.now(), component: 'admin.menu-categories.manager-modal', title: '메뉴 카테고리 관리', size: 'lg', width: 720, height: 620 })"
                    >
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
                                                onclick="Livewire.dispatch('admin:modal-stack:push', { id: 'role-show-{{ $role->id }}-' + Date.now(), component: 'admin.roles.role-show-modal', params: { roleId: {{ Js::from($role->id) }} }, title: '역할 상세 정보', size: 'lg', width: 720, height: 620 })"
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

    <livewire:admin.modal-stack />

</x-laravel-admin::admin.layouts.admin>
