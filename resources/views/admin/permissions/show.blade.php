<x-laravel-admin::admin.layouts.admin title="권한 상세">
    <x-slot name="header">
        <x-laravel-admin::admin.admin-header>
            <x-slot name="navigation">
                <a href="{{ route('admin.index') }}">관리자 홈</a>
                - <a href="{{ route('admin.permissions.index') }}">권한 목록</a>
                - 상세
            </x-slot>
            <x-slot name="description">
                {{ __('권한 상세') }}
            </x-slot>
        </x-laravel-admin::admin.admin-header>
    </x-slot>

    <div class="mx-auto w-full max-w-5xl bg-white px-2 py-2 dark:bg-gray-900">
        <div class="min-h-[560px] bg-white px-4 py-6 sm:px-6 lg:px-8 dark:bg-gray-900">
            <div class="mx-auto max-w-4xl">
                <div class="sm:flex sm:items-start sm:justify-between">
                    <div class="sm:flex-auto">
                        <h1 class="text-2xl font-semibold leading-7 text-gray-900 dark:text-white">{{ __('권한 정보') }}</h1>
                        <p class="mt-2 text-sm leading-6 text-gray-600 dark:text-gray-400">
                            {{ __('권한의 기본 정보와 연결된 역할을 확인합니다.') }}
                        </p>
                    </div>
                    <div class="mt-4 flex gap-2 sm:mt-0 sm:ml-6">
                        <x-laravel-admin::admin.action-button variant="secondary" size="sm" :href="route('admin.permissions.index')" icon="list">
                            {{ __('목록보기') }}
                        </x-laravel-admin::admin.action-button>
                    </div>
                </div>
            </div>

            <x-laravel-admin::admin.session-messages />

            <div class="mx-auto mt-8 max-w-4xl overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-900">
                <div class="border-b border-gray-200 px-4 py-5 sm:px-6 dark:border-gray-700">
                    <div class="min-w-0">
                        <h2 class="truncate text-base font-semibold leading-7 text-gray-900 dark:text-white">{{ $permission->name }}</h2>
                        <p class="truncate text-sm leading-6 text-gray-500 dark:text-gray-400">
                            {{ $permission->roles?->count() ?? 0 }} {{ __('roles') }}
                        </p>
                    </div>
                </div>

                <div class="px-4 py-6 sm:px-6">
                    <div class="space-y-8">
                        <section>
                            <div class="mb-4">
                                <h3 class="text-sm font-semibold leading-6 text-gray-900 dark:text-white">{{ __('기본 정보') }}</h3>
                                <p class="mt-1 text-sm leading-6 text-gray-500 dark:text-gray-400">{{ __('권한 이름과 설명입니다.') }}</p>
                            </div>
                            <dl class="grid grid-cols-1 border-t border-gray-100 sm:grid-cols-2 dark:border-gray-800">
                                <div class="px-0 py-4 sm:px-0 sm:py-5">
                                    <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('Permission Name') }}</dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:mt-2 dark:text-gray-300">{{ $permission->name }}</dd>
                                </div>
                                <div class="border-t border-gray-100 px-0 py-4 sm:border-t-0 sm:px-0 sm:py-5 dark:border-gray-800">
                                    <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('Description') }}</dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:mt-2 dark:text-gray-300">{{ $permission->description ?: __('설명이 없습니다.') }}</dd>
                                </div>
                            </dl>
                        </section>

                        <section class="border-t border-gray-200 pt-6 dark:border-gray-700">
                            <div class="mb-4">
                                <h3 class="text-sm font-semibold leading-6 text-gray-900 dark:text-white">{{ __('연결된 역할') }}</h3>
                                <p class="mt-1 text-sm leading-6 text-gray-500 dark:text-gray-400">{{ __('이 권한을 사용하는 역할입니다.') }}</p>
                            </div>
                            <dl class="border-t border-gray-100 dark:border-gray-800">
                                <div class="px-0 py-4 sm:px-0 sm:py-5">
                                    <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('할당된 역할') }}</dt>
                                    <dd class="mt-2">
                                        @if($permission->roles && $permission->roles->count() > 0)
                                            <div class="flex flex-wrap gap-1.5">
                                                @foreach($permission->roles as $role)
                                                    <x-laravel-admin::admin.badge>{{ $role->name }}</x-laravel-admin::admin.badge>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('이 권한이 할당된 역할이 없습니다.') }}</p>
                                        @endif
                                    </dd>
                                </div>
                            </dl>
                        </section>

                        <section class="border-t border-gray-200 pt-6 dark:border-gray-700">
                            <div class="mb-4">
                                <h3 class="text-sm font-semibold leading-6 text-gray-900 dark:text-white">{{ __('기록') }}</h3>
                                <p class="mt-1 text-sm leading-6 text-gray-500 dark:text-gray-400">{{ __('권한 생성과 마지막 수정 시각입니다.') }}</p>
                            </div>
                            <dl class="grid grid-cols-1 border-t border-gray-100 sm:grid-cols-2 dark:border-gray-800">
                                <div class="px-0 py-4 sm:px-0 sm:py-5">
                                    <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('Created At') }}</dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:mt-2 dark:text-gray-300">{{ $permission->created_at->format('Y-m-d H:i:s') }}</dd>
                                </div>
                                <div class="border-t border-gray-100 px-0 py-4 sm:border-t-0 sm:px-0 sm:py-5 dark:border-gray-800">
                                    <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('Updated At') }}</dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:mt-2 dark:text-gray-300">{{ $permission->updated_at->format('Y-m-d H:i:s') }}</dd>
                                </div>
                            </dl>
                        </section>
                    </div>
                </div>

                <div class="border-t border-gray-200 bg-gray-50 px-4 py-4 sm:px-6 dark:border-gray-700 dark:bg-gray-800/70">
                    <div class="flex justify-end">
                        <div class="flex flex-wrap justify-end gap-2">
                            @can('update', $permission)
                                <x-laravel-admin::admin.action-button :href="route('admin.permissions.edit', $permission)">
                                    {{ __('수정하기') }}
                                </x-laravel-admin::admin.action-button>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-laravel-admin::admin.layouts.admin>
