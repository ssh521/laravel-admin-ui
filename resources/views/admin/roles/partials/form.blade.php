@php
    $role = $role ?? null;
    $rolePermissions = $rolePermissions ?? [];
    $showActions = $showActions ?? true;
    $submitLabel = $submitLabel ?? __('저장하기');
    $labelClass = 'block text-sm font-medium leading-6 text-gray-900 dark:text-white';
@endphp

<div class="mx-auto grid max-w-4xl grid-cols-1 gap-x-8 text-gray-900 md:grid-cols-12 dark:text-gray-100">
    <div class="my-10 border-b border-gray-900/10 md:col-span-12 dark:border-white/10"></div>

    <div class="md:col-span-4">
        <div class="flex flex-col">
            <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">{{ __('기본 정보') }}</h2>
            <p class="mt-1 text-sm leading-6 text-gray-600 dark:text-gray-400">
                {{ $role ? __('관리자 권한 그룹을 식별할 수 있는 이름을 관리합니다.') : __('관리자 권한 그룹을 식별할 수 있는 이름을 입력합니다.') }}
            </p>
        </div>
    </div>

    <div class="md:col-span-8">
        <div class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-6">
            <div class="sm:col-span-3">
                <label for="name" class="{{ $labelClass }}">{{ __('Role Name') }}</label>
                <div class="mt-2">
                    <x-laravel-admin::admin.form-input id="name" name="name" value="{{ old('name', $role?->name) }}" autocomplete="name" placeholder="{{ __('Enter role name') }}" />
                </div>
                @if ($errors->has('name'))
                    <x-laravel-admin::admin.input-error-message class="mt-2 text-xs" :messages="[$role ? '역할명을 입력해 주세요!' : 'Please enter a role name!']" />
                @endif
            </div>

            <div class="sm:col-span-5">
                <label for="description" class="{{ $labelClass }}">{{ __('Description') }}</label>
                <div class="mt-2">
                    <x-laravel-admin::admin.form-textarea id="description" name="description" rows="4" placeholder="{{ __('Enter role description') }}">{{ old('description', $role->description ?? '') }}</x-laravel-admin::admin.form-textarea>
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
            @php
                $resolvePermissionGroup = static function (string $permissionName): string {
                    if (str_starts_with($permissionName, 'menu-category-')) {
                        return 'Menu Category';
                    }

                    if (str_starts_with($permissionName, 'super-admin-')) {
                        return 'Super Admin';
                    }

                    $prefix = explode('-', $permissionName, 2)[0] ?? $permissionName;

                    return [
                        'admin' => 'Admin Dashboard',
                        'role' => 'Role',
                        'permission' => 'Permission',
                        'user' => 'User',
                        'menu' => 'Menu',
                    ][$prefix] ?? '기타';
                };

                $permissionGroups = collect($permissions)->groupBy(fn ($permission) => $resolvePermissionGroup($permission->name));
            @endphp
            <div class="space-y-5">
                @foreach($permissionGroups as $groupName => $groupPermissions)
                    <div>
                        <div class="mb-2 flex items-center justify-between gap-3">
                            <span class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ $groupName }}</span>
                            <span class="text-xs text-gray-400 dark:text-gray-500">{{ $groupPermissions->count() }}개</span>
                        </div>
                        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach($groupPermissions as $permission)
                                <x-laravel-admin::admin.checkbox-row for="permission_{{ $permission->id }}" title="{{ $permission->name }}" class="group relative items-center px-4 py-3 text-sm font-medium hover:z-20 focus-within:z-20">
                                    <input id="permission_{{ $permission->id }}" name="permissions[]" type="checkbox"
                                           value="{{ $permission->id }}" @checked(in_array($permission->id, old('permissions', $role ? $rolePermissions : [])))
                                           class="size-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600 dark:border-gray-600 dark:bg-gray-900">
                                    <span class="pointer-events-none absolute left-10 top-full z-30 mt-1 hidden max-w-72 rounded-md border border-gray-200 bg-white px-2 py-1 text-xs font-medium leading-5 text-gray-900 shadow-lg group-hover:block group-focus-within:block dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                                        {{ $permission->name }}
                                    </span>
                                </x-laravel-admin::admin.checkbox-row>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
            @if ($errors->has('permissions'))
                <x-laravel-admin::admin.input-error-message class="mt-2 text-xs" :messages="['Please select at least one permission!']" />
            @endif
        </fieldset>
    </div>

    <div class="my-10 border-b border-gray-900/10 md:col-span-12 dark:border-white/10"></div>

    @if($showActions)
        <div class="col-span-full flex items-center justify-end gap-x-3">
            <a href="{{ route('admin.roles.index') }}" class="inline-flex h-10 items-center justify-center rounded-md border border-gray-300 bg-white px-4 text-sm font-semibold !text-gray-700 shadow-sm hover:bg-gray-50 hover:no-underline dark:border-gray-600 dark:bg-gray-800 dark:!text-gray-100 dark:hover:bg-gray-700">
                {{ __('목록보기') }}
            </a>
            <button type="submit" class="inline-flex h-10 cursor-pointer items-center justify-center rounded-md bg-indigo-600 px-4 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:bg-indigo-500 dark:hover:bg-indigo-400">
                {{ $submitLabel }}
            </button>
        </div>
    @endif
</div>
