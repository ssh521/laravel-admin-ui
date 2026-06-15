<x-laravel-admin::admin.layouts.admin title="역할 등록">
    <x-slot name="header">
        <x-laravel-admin::admin.admin-header>
            <x-slot name="navigation">
                <a href="{{ route('home') }}">HOME</a>
                - <a href="{{ route('admin.index') }}">Admin Home</a>
            </x-slot>
            <x-slot name="description">
                {{ __('Create New Role') }}
            </x-slot>
        </x-laravel-admin::admin.admin-header>
    </x-slot>

    @php
        $inputClass = 'block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm outline-none placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-gray-600 dark:bg-gray-900 dark:text-white';
        $labelClass = 'block text-sm font-medium leading-6 text-gray-900 dark:text-white';
    @endphp

    <div class="w-full bg-white px-2 py-2 dark:bg-gray-900">
        <div class="min-h-[600px] bg-white px-4 py-6 sm:px-6 lg:px-8 dark:bg-gray-900">
            <div class="mx-auto max-w-4xl">
                <h1 class="text-2xl font-semibold leading-7 text-gray-900 dark:text-white">{{ __('Role Information') }}</h1>
                <p class="mt-2 text-sm leading-6 text-gray-600 dark:text-gray-400">
                    {{ __('새 역할의 이름, 설명, 연결할 권한을 설정합니다.') }}
                </p>
            </div>

            <form action="{{ route('admin.roles.store') }}" method="POST" class="mt-8">
                @csrf

                <div class="mx-auto max-w-4xl text-gray-900 dark:text-gray-100">
                    <div class="border-b border-gray-900/10 pb-10 dark:border-white/10">
                        <div class="grid grid-cols-1 gap-x-8 gap-y-8 md:grid-cols-3">
                            <div>
                                <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">{{ __('기본 정보') }}</h2>
                                <p class="mt-1 text-sm leading-6 text-gray-600 dark:text-gray-400">
                                    {{ __('관리자 권한 그룹을 식별할 수 있는 이름을 입력합니다.') }}
                                </p>
                            </div>

                            <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-6 md:col-span-2 sm:grid-cols-6">
                                <div class="sm:col-span-3">
                                    <label for="name" class="{{ $labelClass }}">{{ __('Role Name') }}</label>
                                    <div class="mt-2">
                                        <input id="name" name="name" type="text" value="{{ old('name') }}" autocomplete="name" placeholder="{{ __('Enter role name') }}" class="{{ $inputClass }}">
                                    </div>
                                    @if ($errors->has('name'))
                                        <x-laravel-admin::admin.input-error-message class="mt-2 text-xs" :messages="['Please enter a role name!']" />
                                    @endif
                                </div>

                                <div class="sm:col-span-5">
                                    <label for="description" class="{{ $labelClass }}">{{ __('Description') }}</label>
                                    <div class="mt-2">
                                        <textarea id="description" name="description" rows="4" placeholder="{{ __('Enter role description') }}" class="{{ $inputClass }}">{{ old('description') }}</textarea>
                                    </div>
                                    <x-laravel-admin::admin.input-error-message class="mt-2 text-xs" :messages="$errors->get('description')" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="border-b border-gray-900/10 py-10 dark:border-white/10">
                        <div class="space-y-6">
                            <div class="max-w-2xl">
                                <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">{{ __('권한') }}</h2>
                                <p class="mt-1 text-sm leading-6 text-gray-600 dark:text-gray-400">
                                    {{ __('이 역할에 부여할 권한을 선택합니다.') }}
                                </p>
                            </div>

                            <div class="w-full">
                                <fieldset>
                                    <legend class="sr-only">{{ __('권한') }}</legend>
                                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                                        @foreach($permissions as $permission)
                                            <label for="permission_{{ $permission->id }}" title="{{ $permission->name }}" class="flex min-h-12 cursor-pointer items-center gap-3 rounded-md border border-gray-200 bg-white px-4 py-3 text-sm font-medium text-gray-900 shadow-sm hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:hover:bg-gray-800">
                                                <input id="permission_{{ $permission->id }}" name="permissions[]" type="checkbox"
                                                       value="{{ $permission->id }}" @checked(in_array($permission->id, old('permissions', [])))
                                                       class="size-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600 dark:border-gray-600 dark:bg-gray-900">
                                                <span class="min-w-0 truncate">{{ $permission->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                    @if ($errors->has('permissions'))
                                        <x-laravel-admin::admin.input-error-message class="mt-2 text-xs" :messages="['Please select at least one permission!']" />
                                    @endif
                                </fieldset>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-end gap-x-3">
                        <a href="{{ route('admin.roles.index') }}" class="inline-flex h-10 items-center justify-center rounded-md border border-gray-300 bg-white px-4 text-sm font-semibold !text-gray-700 shadow-sm hover:bg-gray-50 hover:no-underline dark:border-gray-600 dark:bg-gray-800 dark:!text-gray-100 dark:hover:bg-gray-700">
                            {{ __('목록보기') }}
                        </a>
                        <button type="submit" class="inline-flex h-10 cursor-pointer items-center justify-center rounded-md bg-indigo-600 px-4 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:bg-indigo-500 dark:hover:bg-indigo-400">
                            {{ __('등록하기') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-laravel-admin::admin.layouts.admin>
