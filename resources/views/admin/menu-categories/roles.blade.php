<x-laravel-admin::admin.layouts.admin title="메뉴 카테고리 역할 관리">
    <x-slot name="header">
        <x-laravel-admin::admin.admin-header>
            <x-slot name="navigation">
                <a href="{{ route('admin.index') }}">관리자 홈</a>
                - <a href="{{ route('admin.menu-categories.index') }}">메뉴 카테고리 목록</a>
                - 권한
            </x-slot>
            <x-slot name="description">
                {{ __('메뉴 카테고리 역할 관리') }}
            </x-slot>
        </x-laravel-admin::admin.admin-header>
    </x-slot>

    <div class="mx-auto w-full max-w-5xl bg-white px-2 py-2 dark:bg-gray-900">
        <div class="min-h-[600px] bg-white px-4 py-6 sm:px-6 lg:px-8 dark:bg-gray-900">
            <div class="mx-auto max-w-4xl">
                <div class="sm:flex sm:items-start sm:justify-between">
                    <div class="sm:flex-auto">
                        <h1 class="text-2xl font-semibold leading-7 text-gray-900 dark:text-white">{{ __('역할 관리') }} - [{{ $menuCategory->name }}]</h1>
                        <p class="mt-2 text-sm leading-6 text-gray-600 dark:text-gray-400">
                            {{ __('메뉴 카테고리에 접근을 허용할 역할을 선택합니다.') }}
                        </p>
                    </div>
                    <div class="mt-4 sm:mt-0 sm:ml-6">
                        <x-laravel-admin::admin.action-button variant="secondary" :href="route('admin.menu-categories.show', $menuCategory)">
                            {{ __('카테고리로 돌아가기') }}
                        </x-laravel-admin::admin.action-button>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="mx-auto mt-6 max-w-4xl rounded-md bg-green-50 p-4 text-sm text-green-800 dark:bg-green-500/10 dark:text-green-300" role="alert">
                    <span class="font-medium">성공</span> {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.menu-categories.roles.update', $menuCategory) }}" method="POST">
                @csrf

                <div class="mx-auto grid max-w-4xl grid-cols-1 gap-x-8 text-gray-900 md:grid-cols-12 dark:text-gray-100">
                    <div class="col-span-full h-6 sm:h-10"></div>

                    <div class="md:col-span-4">
                        <div class="flex flex-col">
                            <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">{{ __('허용 역할') }}</h2>
                            <p class="mt-1 text-sm leading-6 text-gray-600 dark:text-gray-400">
                                {{ __('선택한 역할만 이 카테고리의 메뉴를 사용할 수 있습니다.') }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-6 min-w-0 md:col-span-8 md:mt-0">
                        <fieldset>
                            <legend class="sr-only">{{ __('허용 역할 선택') }}</legend>
                            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3">
                                @foreach($roles as $role)
                                    <x-laravel-admin::admin.checkbox-row for="role_{{ $role->id }}" title="{{ $role->name }}" class="items-center px-4 py-3 text-sm font-medium">
                                        <input id="role_{{ $role->id }}" name="roles[]" type="checkbox" value="{{ $role->id }}" @checked(in_array($role->id, $allowedRoleIds)) class="size-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600 dark:border-gray-600 dark:bg-gray-900">
                                    </x-laravel-admin::admin.checkbox-row>
                                @endforeach
                            </div>
                        </fieldset>
                    </div>

                    <div class="mt-8 mb-6 border-b border-gray-900/10 md:col-span-12 sm:my-10 dark:border-white/10"></div>

                    <div class="col-span-full flex items-center justify-end gap-x-3">
                        <x-laravel-admin::admin.action-button variant="secondary" :href="route('admin.menu-categories.show', $menuCategory)">
                            {{ __('취소') }}
                        </x-laravel-admin::admin.action-button>
                        <x-laravel-admin::admin.action-button type="submit">
                            {{ __('저장하기') }}
                        </x-laravel-admin::admin.action-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-laravel-admin::admin.layouts.admin>
