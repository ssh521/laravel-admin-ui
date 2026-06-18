<x-laravel-admin::admin.layouts.admin title="관리자 계정 관리">
    <x-slot name="header">
        <x-laravel-admin::admin.admin-header>
            <x-slot name="navigation">
                <a href="{{ route('admin.index') }}">관리자 홈</a>
            </x-slot>
            <x-slot name="description">
                {{ __('관리자 계정 목록') }}
            </x-slot>
        </x-laravel-admin::admin.admin-header>
    </x-slot>

    <div class="w-full bg-white px-2 py-2 dark:bg-gray-900">
        <div class="min-h-[560px] bg-white px-4 py-6 sm:px-6 lg:px-8 dark:bg-gray-900">
            <div class="sm:flex sm:items-center sm:justify-between">
                <div class="sm:flex-auto">
                    <h1 class="text-2xl font-semibold leading-7 text-gray-900 dark:text-white">{{ __('관리자 계정 목록') }}</h1>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-600 dark:text-gray-400">
                        {{ __('관리자 계정과 역할, 이메일 인증 상태를 확인합니다.') }}
                    </p>
                </div>
                <div class="mt-4 flex gap-2 sm:mt-0 sm:ml-16 sm:flex-none">
                    <a href="{{ route('admin.admin-users.create') }}" class="inline-flex h-9 items-center justify-center rounded-md bg-indigo-600 px-3 text-sm font-semibold !text-white shadow-sm hover:bg-indigo-500 hover:no-underline focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:bg-indigo-500 dark:hover:bg-indigo-400">
                        <x-laravel-admin::admin.icon name="plus" class="mr-2 text-xs" />
                        {{ __('등록하기') }}
                    </a>
                </div>
            </div>

            <x-laravel-admin::admin.session-messages />

            <form method="GET" action="{{ route('admin.admin-users.index') }}" class="mt-6 grid gap-3 rounded-lg border border-gray-200 bg-gray-50 p-4 sm:grid-cols-[minmax(0,180px)_minmax(0,1fr)_auto] sm:items-center dark:border-gray-700 dark:bg-gray-800/70">
                <label for="admin-user-role" class="sr-only">{{ __('전체 역할') }}</label>
                <select id="admin-user-role" name="role" class="h-10 w-full rounded-md border border-gray-300 bg-white px-3 text-sm text-gray-900 shadow-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-gray-600 dark:bg-gray-900 dark:text-white">
                    <option value="">{{ __('전체 역할') }}</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}" @selected(request('role') === $role->name)>{{ $role->name }}</option>
                    @endforeach
                </select>
                <label for="admin-user-search" class="sr-only">{{ __('Search name or email') }}</label>
                <input
                    id="admin-user-search"
                    name="search"
                    type="text"
                    value="{{ request('search') }}"
                    placeholder="{{ __('Search name or email') }}"
                    class="h-10 w-full rounded-md border border-gray-300 bg-white px-3 text-sm text-gray-900 shadow-sm outline-none placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-gray-600 dark:bg-gray-900 dark:text-white"
                >
                <button type="submit" class="inline-flex h-10 cursor-pointer items-center justify-center rounded-md bg-gray-900 px-4 text-sm font-semibold text-white shadow-sm hover:bg-gray-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-900 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-200">
                    <x-laravel-admin::admin.icon name="magnifying-glass" class="mr-2 text-xs" />
                    {{ __('검색') }}
                </button>
            </form>

            <div class="mt-6 flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                            <thead>
                                <tr>
                                    <th scope="col" class="py-3.5 pr-3 pl-4 text-left text-sm font-semibold text-gray-900 sm:pl-0 dark:text-white">{{ __('Name') }}</th>
                                    <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 md:table-cell dark:text-white">{{ __('역할 목록') }}</th>
                                    <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell dark:text-white">{{ __('Verified') }}</th>
                                    <th scope="col" class="relative py-3.5 pr-4 pl-3 sm:pr-0">
                                        <span class="sr-only">{{ __('Actions') }}</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-800 dark:bg-gray-900">
                                @forelse ($adminUsers as $adminUser)
                                    <tr class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-800/80">
                                        <td class="py-4 pr-3 pl-4 text-sm sm:pl-0">
                                            <div class="flex items-center">
                                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-indigo-50 text-sm font-semibold text-indigo-700 ring-1 ring-indigo-100 dark:bg-indigo-500/10 dark:text-indigo-300 dark:ring-indigo-500/20">
                                                    {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($adminUser->name, 0, 1)) }}
                                                </div>
                                                <div class="ml-4 min-w-0">
                                                    <div class="font-medium text-gray-900 dark:text-white">{{ $adminUser->name }}</div>
                                                    <div class="mt-1 truncate text-gray-500 dark:text-gray-400">{{ $adminUser->email }}</div>
                                                    <div class="mt-2 flex flex-wrap gap-1 md:hidden">
                                                        @forelse ($adminUser->getRoleNames() as $role)
                                                            <span class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-700 ring-1 ring-gray-500/10 ring-inset dark:bg-gray-800 dark:text-gray-300 dark:ring-gray-700">{{ $role }}</span>
                                                        @empty
                                                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ __('No roles') }}</span>
                                                        @endforelse
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="hidden px-3 py-4 text-sm text-gray-500 md:table-cell dark:text-gray-400">
                                            <div class="flex flex-wrap gap-1.5">
                                                @forelse ($adminUser->getRoleNames() as $role)
                                                    <span class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-700 ring-1 ring-gray-500/10 ring-inset dark:bg-gray-800 dark:text-gray-300 dark:ring-gray-700">{{ $role }}</span>
                                                @empty
                                                    <span>{{ __('No roles') }}</span>
                                                @endforelse
                                            </div>
                                        </td>
                                        <td class="hidden px-3 py-4 text-sm whitespace-nowrap sm:table-cell">
                                            @if ($adminUser->email_verified_at)
                                                <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-green-600/20 ring-inset dark:bg-green-500/10 dark:text-green-300 dark:ring-green-500/20">{{ __('Verified') }}</span>
                                            @else
                                                <span class="inline-flex items-center rounded-md bg-amber-50 px-2 py-1 text-xs font-medium text-amber-700 ring-1 ring-amber-600/20 ring-inset dark:bg-amber-500/10 dark:text-amber-300 dark:ring-amber-500/20">{{ __('Not Verified') }}</span>
                                            @endif
                                        </td>
                                        <td class="py-4 pr-4 pl-3 text-right text-sm font-medium whitespace-nowrap sm:pr-0">
                                            <a href="{{ route('admin.admin-users.show', $adminUser->getKey()) }}" class="inline-flex items-center rounded-md px-2 py-1 text-sm font-semibold !text-indigo-600 hover:bg-indigo-50 hover:no-underline dark:!text-indigo-300 dark:hover:bg-indigo-500/10">
                                                <x-laravel-admin::admin.icon name="eye" class="mr-1.5 text-xs" />
                                                {{ __('보기') }}
                                            </a>
                                            <a href="{{ route('admin.admin-users.edit', $adminUser->getKey()) }}" class="ml-1 inline-flex items-center rounded-md px-2 py-1 text-sm font-semibold !text-indigo-600 hover:bg-indigo-50 hover:no-underline dark:!text-indigo-300 dark:hover:bg-indigo-500/10">
                                                <x-laravel-admin::admin.icon name="pen-to-square" class="mr-1.5 text-xs" />
                                                {{ __('수정') }}
                                            </a>
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
