<x-laravel-admin::admin.layouts.admin title="관리자 계정 관리">
    <x-slot name="header">
        <x-laravel-admin::admin.admin-header>
            <x-slot name="navigation">
                <a href="{{ route('admin.index') }}">관리자 홈</a>
                - <a href="{{ route('admin.admin-users.index') }}">관리자 계정 관리</a>
            </x-slot>
            <x-slot name="description">
                {{ __('관리자 계정 목록') }}
            </x-slot>
        </x-laravel-admin::admin.admin-header>
    </x-slot>

    @php
        $currentSortField = request('sortField', 'created_at');
        $currentSortDirection = request('sortDirection', 'desc') === 'asc' ? 'asc' : 'desc';
        $getNextSortDirection = fn (string $field): string => $currentSortField === $field && $currentSortDirection === 'asc' ? 'desc' : 'asc';
    @endphp

    <div class="w-full bg-white px-2 py-2 dark:bg-gray-900">
        <div class="min-h-[560px] bg-white px-4 py-6 sm:px-6 lg:px-8 dark:bg-gray-900" x-data="{ filtersOpen: false }">
            <div class="sm:flex sm:items-center sm:justify-between">
                <div class="sm:flex-auto">
                    <h1 class="text-2xl font-semibold leading-7 text-gray-900 dark:text-white">{{ __('관리자 계정 목록') }}</h1>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-600 dark:text-gray-400">
                        {{ __('관리자 계정과 역할, 이메일 인증 상태를 확인합니다.') }}
                    </p>
                </div>
                <div class="mt-4 flex gap-2 sm:mt-0 sm:ml-16 sm:flex-none">
                    <x-laravel-admin::admin.action-button :href="route('admin.admin-users.create')" size="sm" icon="plus">
                        {{ __('등록하기') }}
                    </x-laravel-admin::admin.action-button>
                    <x-laravel-admin::admin.action-button
                        type="button"
                        variant="secondary"
                        size="sm"
                        class="sm:hidden"
                        x-bind:aria-expanded="filtersOpen.toString()"
                        @click="filtersOpen = ! filtersOpen"
                    >
                        <span x-text="filtersOpen ? @js(__('검색/필터 닫기')) : @js(__('검색/필터'))"></span>
                    </x-laravel-admin::admin.action-button>
                </div>
            </div>

            <x-laravel-admin::admin.session-messages />

            <x-laravel-admin::admin.filter-bar action="{{ route('admin.admin-users.index') }}" :mobile-toggle="false">
                @if(request('sortField'))
                    <input type="hidden" name="sortField" value="{{ request('sortField') }}">
                @endif
                @if(request('sortDirection'))
                    <input type="hidden" name="sortDirection" value="{{ request('sortDirection') }}">
                @endif
                <label for="admin-user-role" class="sr-only">{{ __('전체 역할') }}</label>
                <div class="w-full shrink-0 sm:w-40">
                    <x-laravel-admin::admin.form-select id="admin-user-role" name="role" class="h-10">
                        <option value="">{{ __('전체 역할') }}</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}" @selected(request('role') === $role->name)>{{ $role->name }}</option>
                        @endforeach
                    </x-laravel-admin::admin.form-select>
                </div>
                <label for="admin-user-search" class="sr-only">{{ __('Search name or email') }}</label>
                <div class="relative min-w-0 flex-1">
                    <x-laravel-admin::admin.form-input
                        id="admin-user-search"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="{{ __('Search name or email') }}"
                        class="w-full h-10 pr-9"
                    />
                    @if(request('search') || request('role'))
                        <a href="{{ route('admin.admin-users.index') }}"
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
                <div class="-mx-4 -my-2 overflow-x-auto sm:min-h-64 sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                            <thead class="border-y border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-800/80">
                                <tr>
                                    <th scope="col" class="py-3 pr-3 pl-4 text-left text-sm font-semibold text-gray-900 sm:pl-0 md:text-center dark:text-white">
                                        <a href="{{ route('admin.admin-users.index', array_merge(request()->query(), ['sortField' => 'name', 'sortDirection' => $getNextSortDirection('name')])) }}"
                                           class="inline-flex items-center justify-start gap-1 !text-gray-900 hover:!text-indigo-600 hover:no-underline md:justify-center dark:!text-white dark:hover:!text-indigo-400">
                                            <span>{{ __('Name') }}</span>
                                            @if($currentSortField === 'name')
                                                <x-laravel-admin::admin.icon name="{{ $currentSortDirection === 'asc' ? 'arrow-up' : 'arrow-down' }}" class="text-xs" />
                                            @else
                                                <x-laravel-admin::admin.icon name="sort" class="text-xs text-gray-400" />
                                            @endif
                                        </a>
                                    </th>
                                    <th scope="col" class="hidden px-3 py-3 text-center text-sm font-semibold text-gray-900 md:table-cell dark:text-white">{{ __('역할 목록') }}</th>
                                    <th scope="col" class="hidden px-3 py-3 text-center text-sm font-semibold text-gray-900 sm:table-cell dark:text-white">{{ __('Verified') }}</th>
                                    <th scope="col" class="relative py-3 pr-4 pl-3 sm:pr-0">
                                        <span class="sr-only">{{ __('Actions') }}</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-800 dark:bg-gray-900">
                                @forelse ($adminUsers as $adminUser)
                                    <tr class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-800/80">
                                        <td class="py-3 pr-3 pl-4 text-sm sm:pl-0">
                                            <div class="flex items-center">
                                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-indigo-50 text-sm font-semibold text-indigo-700 ring-1 ring-indigo-100 dark:bg-indigo-500/10 dark:text-indigo-300 dark:ring-indigo-500/20">
                                                    {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($adminUser->name, 0, 1)) }}
                                                </div>
                                                <div class="ml-3 min-w-0">
                                                    <div class="font-medium text-gray-900 dark:text-white">{{ $adminUser->name }}</div>
                                                    <div class="mt-0.5 truncate text-gray-500 dark:text-gray-400">{{ $adminUser->email }}</div>
                                                    <div class="mt-1.5 flex flex-wrap gap-1 md:hidden">
                                                        @forelse ($adminUser->getRoleNames() as $role)
                                                            <x-laravel-admin::admin.badge variant="info">{{ $role }}</x-laravel-admin::admin.badge>
                                                        @empty
                                                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ __('No roles') }}</span>
                                                        @endforelse
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="hidden px-3 py-3 text-center text-sm text-gray-500 md:table-cell dark:text-gray-400">
                                            <div class="flex flex-wrap justify-center gap-1.5">
                                                @forelse ($adminUser->getRoleNames() as $role)
                                                    <x-laravel-admin::admin.badge variant="info">{{ $role }}</x-laravel-admin::admin.badge>
                                                @empty
                                                    <span>{{ __('No roles') }}</span>
                                                @endforelse
                                            </div>
                                        </td>
                                        <td class="hidden px-3 py-3 text-center text-sm whitespace-nowrap sm:table-cell">
                                            @if ($adminUser->email_verified_at)
                                                <x-laravel-admin::admin.badge variant="success">{{ __('Verified') }}</x-laravel-admin::admin.badge>
                                            @else
                                                <x-laravel-admin::admin.badge variant="warning">{{ __('Not Verified') }}</x-laravel-admin::admin.badge>
                                            @endif
                                        </td>
                                        <td class="py-3 pr-4 pl-3 text-right text-sm font-medium whitespace-nowrap sm:pr-0">
                                            <div class="flex justify-end">
                                                <x-laravel-admin::admin.action-menu>
                                                    <x-laravel-admin::admin.dropdown-link :href="route('admin.admin-users.show', $adminUser->getKey())" class="rounded-lg px-6 py-1 text-left text-base leading-6 !text-gray-950 hover:!bg-blue-500 hover:!text-white hover:!no-underline focus:!bg-blue-500 focus:!text-white dark:!text-gray-100">
                                                        {{ __('보기') }}
                                                    </x-laravel-admin::admin.dropdown-link>
                                                    <x-laravel-admin::admin.dropdown-link :href="route('admin.admin-users.edit', $adminUser->getKey())" class="rounded-lg px-6 py-1 text-left text-base leading-6 !text-gray-950 hover:!bg-blue-500 hover:!text-white hover:!no-underline focus:!bg-blue-500 focus:!text-white dark:!text-gray-100">
                                                        {{ __('수정') }}
                                                    </x-laravel-admin::admin.dropdown-link>
                                                </x-laravel-admin::admin.action-menu>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-3 py-16 text-center text-sm text-gray-500 dark:text-gray-400">{{ __('No admin users found.') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-6 text-sm">
                {{ $adminUsers->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-laravel-admin::admin.layouts.admin>
