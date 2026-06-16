<x-laravel-admin::admin.layouts.admin title="역할 상세">
    <x-slot name="header">
        <x-laravel-admin::admin.admin-header>
            <x-slot name="navigation">
                <a href="{{ route('home') }}">HOME</a>
                - <a href="{{ route('admin.index') }}">관리자 홈</a>
                - <a href="{{ route('admin.roles.index') }}">역할 관리</a>
            </x-slot>
            <x-slot name="description">
                {{ __('역할 상세') }}
            </x-slot>
        </x-laravel-admin::admin.admin-header>
    </x-slot>

    <div class="mx-auto w-full max-w-5xl bg-white px-2 py-2 dark:bg-gray-900">
        <div class="min-h-[560px] bg-white px-4 py-6 sm:px-6 lg:px-8 dark:bg-gray-900">
            <div class="mx-auto max-w-4xl">
                <div class="sm:flex sm:items-start sm:justify-between">
                    <div class="sm:flex-auto">
                        <h1 class="text-2xl font-semibold leading-7 text-gray-900 dark:text-white">{{ __('역할 정보') }}</h1>
                        <p class="mt-2 text-sm leading-6 text-gray-600 dark:text-gray-400">
                            {{ __('역할의 기본 정보와 연결된 권한을 확인합니다.') }}
                        </p>
                    </div>
                    <div class="mt-4 flex gap-2 sm:mt-0 sm:ml-6">
                        <a href="{{ route('admin.roles.index') }}" class="inline-flex h-9 items-center justify-center rounded-md border border-gray-300 bg-white px-3 text-sm font-semibold !text-gray-700 shadow-sm hover:bg-gray-50 hover:no-underline dark:border-gray-600 dark:bg-gray-800 dark:!text-gray-100 dark:hover:bg-gray-700">
                            <i class="fa-solid fa-list mr-2 text-xs" aria-hidden="true"></i>
                            {{ __('목록보기') }}
                        </a>
                    </div>
                </div>
            </div>

            <x-laravel-admin::admin.session-messages />

            <div class="mx-auto mt-8 max-w-4xl overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-900">
                <div class="border-b border-gray-200 px-4 py-5 sm:px-6 dark:border-gray-700">
                    <div class="min-w-0">
                        <h2 class="truncate text-base font-semibold leading-7 text-gray-900 dark:text-white">{{ $role->name }}</h2>
                        <p class="truncate text-sm leading-6 text-gray-500 dark:text-gray-400">
                            {{ $role->permissions->count() }} {{ __('permissions') }}
                        </p>
                    </div>
                </div>

                <div class="px-4 py-6 sm:px-6">
                    <dl class="grid grid-cols-1 sm:grid-cols-2">
                        <div class="border-t border-gray-100 px-0 py-5 sm:col-span-1 sm:px-0 dark:border-gray-800">
                            <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('Role Name') }}</dt>
                            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:mt-2 dark:text-gray-300">{{ $role->name }}</dd>
                        </div>

                        <div class="border-t border-gray-100 px-0 py-5 sm:col-span-1 sm:px-0 dark:border-gray-800">
                            <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('Description') }}</dt>
                            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:mt-2 dark:text-gray-300">{{ $role->description ?: __('설명이 없습니다.') }}</dd>
                        </div>

                        <div class="border-t border-gray-100 px-0 py-5 sm:col-span-1 sm:px-0 dark:border-gray-800">
                            <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('Created At') }}</dt>
                            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:mt-2 dark:text-gray-300">{{ $role->created_at->format('Y-m-d H:i:s') }}</dd>
                        </div>

                        <div class="border-t border-gray-100 px-0 py-5 sm:col-span-1 sm:px-0 dark:border-gray-800">
                            <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('Updated At') }}</dt>
                            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:mt-2 dark:text-gray-300">{{ $role->updated_at->format('Y-m-d H:i:s') }}</dd>
                        </div>

                        <div class="border-t border-gray-100 px-0 py-5 sm:col-span-2 sm:px-0 dark:border-gray-800">
                            <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('할당된 권한') }}</dt>
                            <dd class="mt-2">
                                @if($role->permissions->count() > 0)
                                    <div class="flex flex-wrap gap-1.5">
                                        @foreach($role->permissions as $permission)
                                            <span class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-700 ring-1 ring-gray-500/10 ring-inset dark:bg-gray-800 dark:text-gray-300 dark:ring-gray-700">
                                                {{ $permission->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('이 역할에 할당된 권한이 없습니다.') }}</p>
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>

                <div class="border-t border-gray-200 bg-gray-50 px-4 py-4 sm:px-6 dark:border-gray-700 dark:bg-gray-800/70">
                    <div class="flex justify-end">
                        <div class="flex flex-wrap justify-end gap-2">
                            @can('update', $role)
                                <a href="{{ route('admin.roles.edit', $role) }}" class="inline-flex h-10 items-center justify-center rounded-md bg-indigo-600 px-4 text-sm font-semibold !text-white shadow-sm hover:bg-indigo-500 hover:no-underline dark:bg-indigo-500 dark:hover:bg-indigo-400">
                                    {{ __('수정하기') }}
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-laravel-admin::admin.layouts.admin>
