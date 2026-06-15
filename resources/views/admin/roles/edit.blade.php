<x-laravel-admin::admin.layouts.admin title="역할 수정">
    <x-slot name="header">
        <x-laravel-admin::admin.admin-header>
            <x-slot name="navigation">
                <a href="{{ route('home') }}">HOME</a>
                - <a href="{{ route('admin.index') }}">Admin Home</a>
            </x-slot>
            <x-slot name="description">
                {{ __('Edit Role') }}
            </x-slot>
        </x-laravel-admin::admin.admin-header>
    </x-slot>

    @php
        $inputClass = 'block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm outline-none placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-gray-600 dark:bg-gray-900 dark:text-white';
        $labelClass = 'block text-sm font-medium leading-6 text-gray-900 dark:text-white';
    @endphp

    <div class="mx-auto w-full max-w-5xl bg-white px-2 py-2 dark:bg-gray-900">
        <div class="min-h-[600px] bg-white px-4 py-6 sm:px-6 lg:px-8 dark:bg-gray-900">
            <div class="mx-auto max-w-4xl">
                <h1 class="text-2xl font-semibold leading-7 text-gray-900 dark:text-white">{{ __('Role Information') }}</h1>
                <p class="mt-2 text-sm leading-6 text-gray-600 dark:text-gray-400">
                    {{ __('역할의 기본 정보와 연결된 권한을 수정합니다.') }}
                </p>
            </div>

            <form id="role-edit-form" action="{{ route('admin.roles.update', $role) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mx-auto grid max-w-4xl grid-cols-1 gap-x-8 text-gray-900 md:grid-cols-12 dark:text-gray-100">
                    <div class="my-10 border-b border-gray-900/10 md:col-span-12 dark:border-white/10"></div>

                    <div class="md:col-span-4">
                        <div class="flex flex-col">
                            <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">{{ __('기본 정보') }}</h2>
                            <p class="mt-1 text-sm leading-6 text-gray-600 dark:text-gray-400">
                                {{ __('관리자 권한 그룹을 식별할 수 있는 이름을 관리합니다.') }}
                            </p>
                        </div>
                    </div>

                    <div class="md:col-span-8">
                        <div class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-6">
                            <div class="sm:col-span-3">
                                <label for="name" class="{{ $labelClass }}">{{ __('Role Name') }}</label>
                                <div class="mt-2">
                                    <input id="name" name="name" type="text" value="{{ old('name', $role->name) }}" autocomplete="name" placeholder="{{ __('Enter role name') }}" class="{{ $inputClass }}">
                                </div>
                                @if ($errors->has('name'))
                                    <x-laravel-admin::admin.input-error-message class="mt-2 text-xs" :messages="['역할명을 입력해 주세요!']" />
                                @endif
                            </div>

                            <div class="sm:col-span-5">
                                <label for="description" class="{{ $labelClass }}">{{ __('Description') }}</label>
                                <div class="mt-2">
                                    <textarea id="description" name="description" rows="4" placeholder="{{ __('Enter role description') }}" class="{{ $inputClass }}">{{ old('description', $role->description ?? '') }}</textarea>
                                </div>
                                <x-laravel-admin::admin.input-error-message class="mt-2 text-xs" :messages="$errors->get('description')" />
                            </div>
                        </div>
                    </div>

                    <div class="my-10 border-b border-gray-900/10 md:col-span-12 dark:border-white/10"></div>

                    <div class="md:col-span-4">
                        <div class="flex flex-col">
                            <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">{{ __('권한') }}</h2>
                            <p class="mt-1 text-sm leading-6 text-gray-600 dark:text-gray-400">
                                {{ __('이 역할에 부여할 권한을 선택합니다.') }}
                            </p>
                        </div>
                    </div>

                    <div class="min-w-0 md:col-span-8">
                        <fieldset>
                            <legend class="sr-only">{{ __('권한') }}</legend>
                            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3">
                                @foreach($permissions as $permission)
                                    <label for="permission_{{ $permission->id }}" title="{{ $permission->name }}" class="flex min-h-12 cursor-pointer items-center gap-3 rounded-md border border-gray-200 bg-white px-4 py-3 text-sm font-medium text-gray-900 shadow-sm hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:hover:bg-gray-800">
                                        <input id="permission_{{ $permission->id }}" name="permissions[]" type="checkbox"
                                               value="{{ $permission->id }}"
                                               @checked(in_array($permission->id, old('permissions', $rolePermissions ?? [])))
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

                    <div class="my-10 border-b border-gray-900/10 md:col-span-12 dark:border-white/10"></div>

                </div>
            </form>

            <div class="mx-auto mt-6 flex w-full max-w-4xl flex-col gap-3 px-2 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex justify-start">
                    @can('delete', $role)
                        <form action="{{ route('admin.roles.destroy', $role) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    onclick="return confirm('{{ __('정말 삭제하시겠습니까?') }}')"
                                    class="inline-flex h-10 cursor-pointer items-center justify-center rounded-md border border-red-200 bg-white px-4 text-sm font-semibold text-red-700 shadow-sm hover:bg-red-50 dark:border-red-500/30 dark:bg-gray-900 dark:text-red-300 dark:hover:bg-red-500/10">
                                <i class="fa-regular fa-trash-can mr-2 text-xs" aria-hidden="true"></i>
                                {{ __('Delete Role') }}
                            </button>
                        </form>
                    @endcan
                </div>

                <div class="flex flex-wrap justify-end gap-3">
                    <a href="{{ route('admin.roles.index') }}" class="inline-flex h-10 items-center justify-center rounded-md border border-gray-300 bg-white px-4 text-sm font-semibold !text-gray-700 shadow-sm hover:bg-gray-50 hover:no-underline dark:border-gray-600 dark:bg-gray-800 dark:!text-gray-100 dark:hover:bg-gray-700">
                        {{ __('목록보기') }}
                    </a>
                    <button type="submit" form="role-edit-form" class="inline-flex h-10 cursor-pointer items-center justify-center rounded-md bg-indigo-600 px-4 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 dark:bg-indigo-500 dark:hover:bg-indigo-400">
                        {{ __('수정하기') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-laravel-admin::admin.layouts.admin>
