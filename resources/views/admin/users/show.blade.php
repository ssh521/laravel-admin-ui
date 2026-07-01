<x-laravel-admin::admin.layouts.admin title="사용자 정보">
    <x-slot name="header">
        <x-laravel-admin::admin.admin-header>
            <x-slot name="navigation">
                <a href="{{ route('admin.index') }}">관리자 홈</a>
                @can('viewAny', Ssh521\LaravelAdmin\Models\User::class)
                    - <a href="{{ route('admin.users.index') }}">회원 목록</a>
                @else
                    - {{ __('회원 목록') }}
                @endcan
                - 상세
            </x-slot>
            <x-slot name="description">
                {{ __('사용자 정보') }}
            </x-slot>
        </x-laravel-admin::admin.admin-header>
    </x-slot>

    <div class="mx-auto w-full max-w-5xl bg-white px-2 py-2 dark:bg-gray-900">
        <div class="min-h-[600px] bg-white px-4 py-6 sm:px-6 lg:px-8 dark:bg-gray-900">
            <div class="mx-auto max-w-4xl sm:flex sm:items-start sm:justify-between">
                <div>
                    <h1 class="text-2xl font-semibold leading-7 text-gray-900 dark:text-white">{{ __('사용자 정보') }}</h1>
                    <p class="mt-2 text-sm leading-6 text-gray-600 dark:text-gray-400">
                        {{ __('사용자 계정의 기본 정보와 이메일 인증 상태를 확인합니다.') }}
                    </p>
                </div>

                <div class="mt-4 flex flex-wrap gap-3 sm:mt-0">
                    <x-laravel-admin::admin.action-button variant="secondary" :href="route('admin.users.index')">
                        {{ __('목록보기') }}
                    </x-laravel-admin::admin.action-button>
                </div>
            </div>

            <x-laravel-admin::admin.session-messages />

            <div class="mx-auto mt-8 max-w-4xl overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-900">
                <div class="border-b border-gray-200 px-4 py-5 sm:px-6 dark:border-gray-700">
                    <div class="flex items-center gap-4">
                        <div class="flex size-12 shrink-0 items-center justify-center rounded-full bg-indigo-50 text-base font-semibold text-indigo-700 ring-1 ring-indigo-600/20 ring-inset dark:bg-indigo-500/10 dark:text-indigo-300 dark:ring-indigo-500/30">
                            {{ mb_substr($user->name, 0, 1) }}
                        </div>
                        <div class="min-w-0">
                            <h2 class="truncate text-base font-semibold leading-6 text-gray-900 dark:text-white">{{ $user->name }}</h2>
                            <p class="mt-1 truncate text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                        </div>
                    </div>
                </div>

                <dl class="divide-y divide-gray-100 dark:divide-gray-800">
                    <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-900 dark:text-white">{{ __('이름') }}</dt>
                        <dd class="mt-1 text-sm text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-300">{{ $user->name }}</dd>
                    </div>
                    <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-900 dark:text-white">{{ __('E-mail') }}</dt>
                        <dd class="mt-1 text-sm text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-300">{{ $user->email }}</dd>
                    </div>
                    <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-900 dark:text-white">{{ __('인증상태') }}</dt>
                        <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">
                            @if ($user->email_verified_at)
                                <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-green-600/20 ring-inset dark:bg-green-500/10 dark:text-green-300 dark:ring-green-500/30">{{ __('Verified') }}</span>
                                <span class="ml-2 text-gray-500 dark:text-gray-400">{{ $user->email_verified_at->format('Y-m-d H:i:s') }}</span>
                            @else
                                <span class="inline-flex items-center rounded-md bg-amber-50 px-2 py-1 text-xs font-medium text-amber-700 ring-1 ring-amber-600/20 ring-inset dark:bg-amber-500/10 dark:text-amber-300 dark:ring-amber-500/30">{{ __('Not Verified') }}</span>
                            @endif
                        </dd>
                    </div>
                    <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-900 dark:text-white">{{ __('등록일') }}</dt>
                        <dd class="mt-1 text-sm text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-300">{{ $user->created_at?->format('Y-m-d H:i:s') }}</dd>
                    </div>
                    <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-900 dark:text-white">{{ __('수정일') }}</dt>
                        <dd class="mt-1 text-sm text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-300">{{ $user->updated_at?->format('Y-m-d H:i:s') }}</dd>
                    </div>
                </dl>

                <div class="flex justify-end border-t border-gray-200 px-4 py-4 sm:px-6 dark:border-gray-700">
                    <div class="flex flex-wrap justify-end gap-3">
                        @can('update', $user)
                            <x-laravel-admin::admin.action-button :href="route('admin.users.edit', $user->id)">
                                {{ __('수정하기') }}
                            </x-laravel-admin::admin.action-button>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-laravel-admin::admin.layouts.admin>
