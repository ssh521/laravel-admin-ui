<x-laravel-admin::admin.layouts.admin title="사용자 관리">
    <x-slot name="header">
        <x-laravel-admin::admin.admin-header>
            <x-slot name="navigation">
                <a href="{{ route('admin.index') }}">{{ __('관리자 홈') }}</a>
                - <a href="{{ route('admin.users.index') }}">{{ __('회원 관리') }}</a>
            </x-slot>
            <x-slot name="description">
                {{ __('회원 목록') }}
            </x-slot>
        </x-laravel-admin::admin.admin-header>
    </x-slot>

    @php
        $users = $data;
        $search = request('search');
        $pageDescription = $search
            ? __('":keyword" 검색 결과를 확인합니다.', ['keyword' => $search])
            : __('사이트 회원 계정을 조회하고 상세 정보를 확인합니다.');
        $currentSortField = request('sortField', 'created_at');
        $currentSortDirection = request('sortDirection', 'desc') === 'asc' ? 'asc' : 'desc';
        $getNextSortDirection = fn (string $field): string => $currentSortField === $field && $currentSortDirection === 'asc' ? 'desc' : 'asc';
        $sortLinkClass = 'inline-flex items-center justify-start gap-1 !text-gray-900 hover:!text-indigo-600 hover:no-underline md:justify-center dark:!text-white dark:hover:!text-indigo-400';
    @endphp

    <x-laravel-admin::admin.page-section
        title="{{ __('회원 목록') }}"
        description="{{ $pageDescription }}"
        x-data="{ filtersOpen: false }"
    >
        <x-slot name="actions">
            @can('create', Ssh521\LaravelAdmin\Models\User::class)
                <x-laravel-admin::admin.action-button :href="route('admin.users.create')" size="sm" icon="plus">
                    {{ __('등록하기') }}
                </x-laravel-admin::admin.action-button>
            @endcan
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
        </x-slot>

        <x-laravel-admin::admin.session-messages />

        <x-laravel-admin::admin.filter-bar action="{{ route('admin.users.index') }}" :mobile-toggle="false">
            @if(request('sortField'))
                <input type="hidden" name="sortField" value="{{ request('sortField') }}">
            @endif
            @if(request('sortDirection'))
                <input type="hidden" name="sortDirection" value="{{ request('sortDirection') }}">
            @endif
            <label for="user-search" class="sr-only">{{ __('회원 검색') }}</label>
            <div class="relative min-w-0 flex-1">
                <x-laravel-admin::admin.form-input id="user-search" name="search" value="{{ $search }}" class="w-full h-10 pr-9" placeholder="이름 또는 이메일 검색" />
                @if($search)
                    <a href="{{ route('admin.users.index') }}"
                       class="absolute right-3 top-1/2 -translate-y-1/2 !text-gray-400 hover:!text-gray-600 hover:no-underline dark:hover:!text-gray-300">
                        <x-laravel-admin::admin.icon name="xmark" class="text-sm" />
                    </a>
                @endif
            </div>

            <x-laravel-admin::admin.action-button type="submit" variant="search" icon="magnifying-glass" class="w-full shrink-0 whitespace-nowrap sm:w-auto">
                {{ __('검색') }}
            </x-laravel-admin::admin.action-button>
        </x-laravel-admin::admin.filter-bar>

        <x-laravel-admin::admin.table-shell class="mt-6">
            <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                <thead class="border-y border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-800/80">
                    <tr>
                        <th scope="col" class="py-3 pr-3 pl-4 text-left text-sm font-semibold text-gray-900 sm:pl-0 md:text-center dark:text-white">
                            <a href="{{ route('admin.users.index', array_merge(request()->query(), ['sortField' => 'name', 'sortDirection' => $getNextSortDirection('name')])) }}" class="{{ $sortLinkClass }}">
                                <span>{{ __('이름') }}</span>
                                @if($currentSortField === 'name')
                                    <x-laravel-admin::admin.icon name="{{ $currentSortDirection === 'asc' ? 'arrow-up' : 'arrow-down' }}" class="text-xs" />
                                @else
                                    <x-laravel-admin::admin.icon name="sort" class="text-xs text-gray-400" />
                                @endif
                            </a>
                        </th>
                        <th scope="col" class="hidden px-3 py-3 text-center text-sm font-semibold text-gray-900 md:table-cell dark:text-white">
                            <a href="{{ route('admin.users.index', array_merge(request()->query(), ['sortField' => 'email', 'sortDirection' => $getNextSortDirection('email')])) }}" class="{{ $sortLinkClass }}">
                                <span>{{ __('이메일') }}</span>
                                @if($currentSortField === 'email')
                                    <x-laravel-admin::admin.icon name="{{ $currentSortDirection === 'asc' ? 'arrow-up' : 'arrow-down' }}" class="text-xs" />
                                @else
                                    <x-laravel-admin::admin.icon name="sort" class="text-xs text-gray-400" />
                                @endif
                            </a>
                        </th>
                        <th scope="col" class="px-3 py-3 text-center text-sm font-semibold whitespace-nowrap text-gray-900 dark:text-white">{{ __('메일 인증') }}</th>
                        <th scope="col" class="hidden px-3 py-3 text-center text-sm font-semibold text-gray-900 lg:table-cell dark:text-white">
                            <a href="{{ route('admin.users.index', array_merge(request()->query(), ['sortField' => 'created_at', 'sortDirection' => $getNextSortDirection('created_at')])) }}" class="{{ $sortLinkClass }}">
                                <span>{{ __('가입일') }}</span>
                                @if($currentSortField === 'created_at')
                                    <x-laravel-admin::admin.icon name="{{ $currentSortDirection === 'asc' ? 'arrow-up' : 'arrow-down' }}" class="text-xs" />
                                @else
                                    <x-laravel-admin::admin.icon name="sort" class="text-xs text-gray-400" />
                                @endif
                            </a>
                        </th>
                        <th scope="col" class="relative py-3 pr-4 pl-3 sm:pr-0">
                            <span class="sr-only">{{ __('Actions') }}</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-800 dark:bg-gray-900">
                    @forelse ($users as $user)
                        <tr class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-800/80">
                            <td class="py-3 pr-3 pl-4 text-sm sm:pl-0">
                                <div class="flex items-center gap-3">
                                    <x-laravel-admin::admin.avatar :name="$user->name" size="sm" />
                                    <div class="min-w-0">
                                        <div class="font-medium text-gray-900 dark:text-white">
                                            @can('view', $user)
                                                <x-laravel-admin::admin.action-button
                                                    type="button"
                                                    variant="link"
                                                    size="sm"
                                                    x-on:click="Livewire.dispatch('admin:modal-stack:push', { id: 'user-show-{{ $user->id }}-' + Date.now(), component: 'admin.users.user-show-modal', params: { userId: {{ $user->id }} }, title: '사용자 상세 정보', size: 'lg', width: 680, height: 480, minHeight: 420 })"
                                                    class="h-auto px-0 py-0"
                                                >
                                                    {{ $user->name }}
                                                </x-laravel-admin::admin.action-button>
                                            @else
                                                {{ $user->name }}
                                            @endcan
                                        </div>
                                        <div class="mt-0.5 truncate text-gray-500 md:hidden dark:text-gray-400">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="hidden whitespace-nowrap px-3 py-3 text-center text-sm text-gray-600 md:table-cell dark:text-gray-300">
                                @can('view', $user)
                                    <x-laravel-admin::admin.action-button variant="link" size="sm" :href="route('admin.users.show', $user)" class="h-auto px-0 py-0 text-gray-700 dark:text-gray-300">
                                        {{ $user->email }}
                                    </x-laravel-admin::admin.action-button>
                                @else
                                    {{ $user->email }}
                                @endcan
                            </td>
                            <td class="whitespace-nowrap px-3 py-3 text-center text-sm">
                                @if($user->email_verified_at)
                                    <x-laravel-admin::admin.badge variant="success">{{ __('인증됨') }}</x-laravel-admin::admin.badge>
                                @else
                                    <x-laravel-admin::admin.badge variant="warning">{{ __('미인증') }}</x-laravel-admin::admin.badge>
                                @endif
                            </td>
                            <td class="hidden whitespace-nowrap px-3 py-3 text-center text-sm text-gray-500 lg:table-cell dark:text-gray-400">
                                {{ $user->created_at?->format('Y-m-d H:i') }}
                            </td>
                            <td class="whitespace-nowrap py-3 pr-4 pl-3 text-right text-sm font-medium sm:pr-0">
                                <div class="flex justify-end">
                                    <x-laravel-admin::admin.action-menu>
                                        @can('view', $user)
                                            <x-laravel-admin::admin.dropdown-link :href="route('admin.users.show', $user)">
                                                {{ __('보기') }}
                                            </x-laravel-admin::admin.dropdown-link>
                                        @endcan
                                        @can('update', $user)
                                            <x-laravel-admin::admin.dropdown-link :href="route('admin.users.edit', $user)">
                                                {{ __('수정') }}
                                            </x-laravel-admin::admin.dropdown-link>
                                            <div aria-hidden="true" class="my-1 border-t border-gray-200 dark:border-gray-700"></div>
                                            <button
                                                type="button"
                                                x-on:click="Livewire.dispatch('admin:modal-stack:push', { id: 'user-edit-{{ $user->id }}-' + Date.now(), component: 'admin.users.user-edit-modal', params: { userId: {{ $user->id }} }, title: '사용자 수정', size: 'md' })"
                                                class="block w-full cursor-pointer appearance-none rounded-lg border-0 bg-transparent px-6 py-1 text-left text-base leading-6 !text-gray-950 hover:!bg-blue-500 hover:!text-white hover:!no-underline focus:!bg-blue-500 focus:!text-white focus:outline-none dark:!text-gray-100"
                                            >
                                                {{ __('모달수정') }}
                                            </button>
                                        @endcan
                                    </x-laravel-admin::admin.action-menu>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-3 py-6">
                                <x-laravel-admin::admin.empty-state>
                                    @if($search)
                                        {{ __('":keyword"에 대한 검색 결과가 없습니다.', ['keyword' => $search]) }}
                                    @else
                                        {{ __('등록된 회원이 없습니다.') }}
                                    @endif
                                </x-laravel-admin::admin.empty-state>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </x-laravel-admin::admin.table-shell>

        @if($users->hasPages())
            <div class="mt-6 text-sm">
                {!! $users->appends(request()->query())->links() !!}
            </div>
        @endif
    </x-laravel-admin::admin.page-section>

    <livewire:admin.modal-stack />
</x-laravel-admin::admin.layouts.admin>
