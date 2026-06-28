<x-laravel-admin::admin.layouts.admin title="관리자 계정 정보">
    <x-slot name="header">
        <x-laravel-admin::admin.admin-header>
            <x-slot name="navigation">
                <a href="{{ route('admin.index') }}">관리자 홈</a>
                - <a href="{{ route('admin.admin-users.index') }}">관리자 계정</a>
            </x-slot>
            <x-slot name="description">
                {{ __('관리자 계정 정보') }}
            </x-slot>
        </x-laravel-admin::admin.admin-header>
    </x-slot>

    <div class="mx-auto w-full max-w-5xl bg-white px-2 py-2 dark:bg-gray-900">
        <div class="min-h-[450px] bg-white px-4 py-6 sm:px-6 lg:px-8 dark:bg-gray-900">
            <div class="mx-auto max-w-4xl">
                <div class="sm:flex sm:items-start sm:justify-between">
                    <div class="sm:flex-auto">
                        <h1 class="text-2xl font-semibold leading-7 text-gray-900 dark:text-white">{{ __('관리자 계정 정보') }}</h1>
                        <p class="mt-2 text-sm leading-6 text-gray-600 dark:text-gray-400">
                            {{ __('관리자 계정의 기본 정보, 권한, 상태 정보를 확인합니다.') }}
                        </p>
                    </div>
                    <div class="mt-4 flex gap-2 sm:mt-0 sm:ml-6">
                        <x-laravel-admin::admin.action-button variant="secondary" size="sm" :href="route('admin.admin-users.index')" icon="list">
                            {{ __('목록보기') }}
                        </x-laravel-admin::admin.action-button>
                    </div>
                </div>
            </div>

            <div class="mx-auto mt-8 max-w-4xl overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-900">
                <div class="border-b border-gray-200 px-4 py-5 sm:px-6 dark:border-gray-700">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-indigo-50 text-base font-semibold text-indigo-700 ring-1 ring-indigo-100 dark:bg-indigo-500/10 dark:text-indigo-300 dark:ring-indigo-500/20">
                            {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($adminUser->name, 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <h2 class="truncate text-base font-semibold leading-7 text-gray-900 dark:text-white">{{ $adminUser->name }}</h2>
                            <p class="truncate text-sm leading-6 text-gray-500 dark:text-gray-400">{{ $adminUser->email }}</p>
                        </div>
                    </div>
                </div>

                <div class="px-4 py-6 sm:px-6">
                    <dl class="grid grid-cols-1 sm:grid-cols-2">
                        <div class="border-t border-gray-100 px-0 py-5 sm:col-span-1 sm:px-0 dark:border-gray-800">
                            <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('이름') }}</dt>
                            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:mt-2 dark:text-gray-300">{{ $adminUser->name }}</dd>
                        </div>
                        <div class="border-t border-gray-100 px-0 py-5 sm:col-span-1 sm:px-0 dark:border-gray-800">
                            <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('E-mail') }}</dt>
                            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:mt-2 dark:text-gray-300">{{ $adminUser->email }}</dd>
                        </div>
                        <div class="border-t border-gray-100 px-0 py-5 sm:col-span-1 sm:px-0 dark:border-gray-800">
                            <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('인증상태') }}</dt>
                            <dd class="mt-1 text-sm leading-6 sm:mt-2">
                                @if ($adminUser->email_verified_at)
                                    <x-laravel-admin::admin.badge variant="success">{{ __('Verified') }}</x-laravel-admin::admin.badge>
                                    <span class="ml-2 text-gray-500 dark:text-gray-400">{{ $adminUser->email_verified_at->format('Y-m-d H:i:s') }}</span>
                                @else
                                    <x-laravel-admin::admin.badge variant="warning">{{ __('Not Verified') }}</x-laravel-admin::admin.badge>
                                @endif
                            </dd>
                        </div>
                        <div class="border-t border-gray-100 px-0 py-5 sm:col-span-1 sm:px-0 dark:border-gray-800">
                            <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('역할') }}</dt>
                            <dd class="mt-1 flex flex-wrap gap-1.5 text-sm leading-6 sm:mt-2">
                                @forelse ($adminUser->getRoleNames() as $role)
                                    <x-laravel-admin::admin.badge>{{ $role }}</x-laravel-admin::admin.badge>
                                @empty
                                    <span class="text-gray-500 dark:text-gray-400">{{ __('No roles assigned') }}</span>
                                @endforelse
                            </dd>
                        </div>
                        <div class="border-t border-gray-100 px-0 py-5 sm:col-span-1 sm:px-0 dark:border-gray-800">
                            <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('등록일') }}</dt>
                            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:mt-2 dark:text-gray-300">{{ $adminUser->created_at?->format('Y-m-d H:i:s') }}</dd>
                        </div>
                        <div class="border-t border-gray-100 px-0 py-5 sm:col-span-1 sm:px-0 dark:border-gray-800">
                            <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('수정일') }}</dt>
                            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:mt-2 dark:text-gray-300">{{ $adminUser->updated_at?->format('Y-m-d H:i:s') }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="border-t border-gray-200 bg-gray-50 px-4 py-4 sm:px-6 dark:border-gray-700 dark:bg-gray-800/70">
                    <div class="flex flex-wrap justify-end gap-2">
                        <x-laravel-admin::admin.action-button :href="route('admin.admin-users.edit', $adminUser->getKey())">
                            {{ __('수정하기') }}
                        </x-laravel-admin::admin.action-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-laravel-admin::admin.layouts.admin>
