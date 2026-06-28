<x-laravel-admin::admin.page-section
    title="{{ __('회원 목록') }}"
    description="{{ $search ? __('":keyword" 검색 결과를 확인합니다.', ['keyword' => $search]) : __('사이트 회원 계정을 조회하고 상세 정보를 확인합니다.') }}"
>
    <x-slot name="actions">
        @can('create', Ssh521\LaravelAdmin\Models\User::class)
            <x-laravel-admin::admin.action-button :href="route('admin.users.create')" size="sm" icon="plus">
                {{ __('등록하기') }}
            </x-laravel-admin::admin.action-button>
        @endcan
    </x-slot>

    <x-laravel-admin::admin.session-messages />

    <x-laravel-admin::admin.filter-bar>
        <label for="user-search" class="sr-only">{{ __('회원 검색') }}</label>
        <div class="relative min-w-0 flex-1">
            <x-laravel-admin::admin.form-input
                id="user-search"
                wire:model.live.debounce.300ms="search"
                class="h-10 pr-9"
                placeholder="이름 또는 이메일 검색"
            />
            @if($search)
                <button
                    type="button"
                    wire:click="$set('search', '')"
                    class="absolute right-3 top-1/2 -translate-y-1/2 cursor-pointer text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                >
                    <x-laravel-admin::admin.icon name="xmark" class="text-sm" />
                    <span class="sr-only">{{ __('검색 초기화') }}</span>
                </button>
            @endif
        </div>

        <x-laravel-admin::admin.action-button type="button" variant="search" icon="magnifying-glass" class="w-full sm:w-auto">
            {{ __('검색') }}
        </x-laravel-admin::admin.action-button>
    </x-laravel-admin::admin.filter-bar>

    <x-laravel-admin::admin.table-shell class="mt-6">
        <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
            <thead>
                <tr>
                    <th scope="col" class="py-3.5 pr-3 pl-4 text-left text-sm font-semibold text-gray-900 sm:pl-0 dark:text-white">{{ __('이름') }}</th>
                    <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 md:table-cell dark:text-white">{{ __('이메일') }}</th>
                    <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell dark:text-white">{{ __('이메일 인증') }}</th>
                    <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell dark:text-white">{{ __('가입일') }}</th>
                    <th scope="col" class="relative py-3.5 pr-4 pl-3 sm:pr-0">
                        <span class="sr-only">{{ __('Actions') }}</span>
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-800 dark:bg-gray-900">
                @forelse ($users as $user)
                    <tr class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-800/80">
                        <td class="py-4 pr-3 pl-4 text-sm sm:pl-0">
                            <div class="flex items-center gap-3">
                                <x-laravel-admin::admin.avatar :name="$user->name" size="sm" />
                                <div class="min-w-0">
                                    <div class="font-medium text-gray-900 dark:text-white">
                                        @can('view', $user)
                                            <x-laravel-admin::admin.action-button
                                                type="button"
                                                variant="link"
                                                size="sm"
                                                wire:click="showUserDetailModal({{ $user->id }})"
                                                class="h-auto px-0 py-0"
                                            >
                                                {{ $user->name }}
                                            </x-laravel-admin::admin.action-button>
                                        @else
                                            {{ $user->name }}
                                        @endcan
                                    </div>
                                    <div class="mt-1 truncate text-gray-500 md:hidden dark:text-gray-400">{{ $user->email }}</div>
                                </div>
                            </div>
                            <div class="mt-2 sm:hidden">
                                @if($user->email_verified_at)
                                    <x-laravel-admin::admin.badge variant="success">{{ __('인증됨') }}</x-laravel-admin::admin.badge>
                                @else
                                    <x-laravel-admin::admin.badge variant="warning">{{ __('미인증') }}</x-laravel-admin::admin.badge>
                                @endif
                            </div>
                        </td>
                        <td class="hidden whitespace-nowrap px-3 py-4 text-sm text-gray-600 md:table-cell dark:text-gray-300">
                            @can('view', $user)
                                <x-laravel-admin::admin.action-button variant="link" size="sm" :href="route('admin.users.show', $user)" class="h-auto px-0 py-0 text-gray-700 dark:text-gray-300">
                                    {{ $user->email }}
                                </x-laravel-admin::admin.action-button>
                            @else
                                {{ $user->email }}
                            @endcan
                        </td>
                        <td class="hidden whitespace-nowrap px-3 py-4 text-sm sm:table-cell">
                            @if($user->email_verified_at)
                                <x-laravel-admin::admin.badge variant="success">{{ __('인증됨') }}</x-laravel-admin::admin.badge>
                            @else
                                <x-laravel-admin::admin.badge variant="warning">{{ __('미인증') }}</x-laravel-admin::admin.badge>
                            @endif
                        </td>
                        <td class="hidden whitespace-nowrap px-3 py-4 text-sm text-gray-500 lg:table-cell dark:text-gray-400">
                            {{ $user->created_at?->format('Y-m-d H:i') }}
                        </td>
                        <td class="whitespace-nowrap py-4 pr-4 pl-3 text-right text-sm font-medium sm:pr-0">
                            @can('view', $user)
                                <x-laravel-admin::admin.action-button variant="link" size="sm" :href="route('admin.users.show', $user)" icon="eye" class="h-auto px-2 py-1">
                                    {{ __('상세보기') }}
                                </x-laravel-admin::admin.action-button>
                            @endcan
                            @can('update', $user)
                                <x-laravel-admin::admin.action-button variant="link" size="sm" :href="route('admin.users.edit', $user)" icon="pen-to-square" class="ml-1 h-auto px-2 py-1">
                                    {{ __('수정') }}
                                </x-laravel-admin::admin.action-button>
                            @endcan
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

    <livewire:admin.users.user-detail-modal />
</x-laravel-admin::admin.page-section>
