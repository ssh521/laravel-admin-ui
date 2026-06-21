@php
    $isProfile = $isProfile ?? false;
    $labelClass = 'block text-sm font-medium leading-6 text-gray-900 dark:text-white';
    $helpClass = 'mt-1 text-xs leading-5 text-gray-500 dark:text-gray-400';
    $roleIds = $adminUser?->roles->pluck('id')->all() ?? [];
    $showActions = $showActions ?? true;
@endphp

<div class="mx-auto grid max-w-4xl grid-cols-1 gap-x-8 text-gray-900 md:grid-cols-12 dark:text-gray-100">

    <div class="md:col-span-12 dark:border-white/10 border-b border-gray-900/10 my-10"></div>

    <div class="md:col-span-4">
        <div class="flex flex-col">
            <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">{{ __('기본 정보') }}</h2>
            <p class="mt-1 text-sm leading-6 text-gray-600 dark:text-gray-400">
                {{ __('관리자 계정의 이름과 로그인 이메일을 입력합니다.') }}
            </p>
        </div>
    </div>

    <div class="md:col-span-8">
        <div class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-6">
            <div class="sm:col-span-3">
                <label for="name" class="{{ $labelClass }}">{{ __('이름') }}</label>
                <div class="mt-2">
                    <x-laravel-admin::admin.form-input id="name" name="name" value="{{ old('name', $adminUser?->name) }}" autocomplete="name" />
                </div>
                <x-laravel-admin::admin.input-error-message class="mt-2 text-xs" :messages="$errors->get('name')" />
            </div>

            <div class="sm:col-span-4">
                <label for="email" class="{{ $labelClass }}">{{ __('E-mail') }}</label>
                <div class="mt-2">
                    <x-laravel-admin::admin.form-input id="email" name="email" type="email" value="{{ $isProfile ? $adminUser?->email : old('email', $adminUser?->email) }}" autocomplete="email" class="{{ $isProfile ? 'bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400' : '' }}" :disabled="$isProfile" />
                </div>
                @if ($isProfile)
                    <p class="{{ $helpClass }}">{{ __('프로필 화면에서는 이메일을 변경할 수 없습니다.') }}</p>
                @endif
                <x-laravel-admin::admin.input-error-message class="mt-2 text-xs" :messages="$errors->get('email')" />
            </div>
        </div>
    </div>

    <div class="md:col-span-12 dark:border-white/10 border-b border-gray-900/10 my-10"></div>

    <div class="md:col-span-4">
        <div class="flex flex-col">
            <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">{{ __('비밀번호') }}</h2>
            <p class="mt-1 text-sm leading-6 text-gray-600 dark:text-gray-400">
                {{ $adminUser ? __('변경하지 않으려면 비워두세요.') : __('새 관리자 계정의 비밀번호를 설정합니다.') }}
            </p>
        </div>
    </div>

    <div class="md:col-span-8">
        <div class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-6">
            <div class="sm:col-span-3">
                <label for="password" class="{{ $labelClass }}">{{ __('비밀번호') }}</label>
                <div class="mt-2">
                    <x-laravel-admin::admin.form-input id="password" name="password" type="password" autocomplete="new-password" />
                </div>
                <x-laravel-admin::admin.input-error-message class="mt-2 text-xs" :messages="$errors->get('password')" />
            </div>

            <div class="sm:col-span-3">
                <label for="confirm-password" class="{{ $labelClass }}">{{ __('비밀번호 확인') }}</label>
                <div class="mt-2">
                    <x-laravel-admin::admin.form-input id="confirm-password" name="confirm-password" type="password" autocomplete="new-password" />
                </div>
                <x-laravel-admin::admin.input-error-message class="mt-2 text-xs" :messages="$errors->get('confirm-password')" />
            </div>
        </div>
    </div>

    <div class="md:col-span-12 dark:border-white/10 border-b border-gray-900/10 my-10"></div>

    <div class="md:col-span-4">
        <div class="flex flex-col">
            <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">{{ __('권한 및 상태') }}</h2>
            <p class="mt-1 text-sm leading-6 text-gray-600 dark:text-gray-400">
                {{ __('이메일 인증 여부와 관리자 역할을 지정합니다.') }}
            </p>
        </div>
    </div>

    <div class="min-w-0 md:col-span-8">
        <div class="flex flex-col gap-8">
            <fieldset>
                <legend class="{{ $labelClass }}">{{ __('인증') }}</legend>
                <div class="mt-3">
                    <x-laravel-admin::admin.checkbox-row for="email_verified" title="{{ __('Email Verified') }}" description="{{ __('체크하면 이메일 인증이 완료된 관리자 계정으로 표시됩니다.') }}" class="{{ $isProfile ? 'cursor-not-allowed opacity-70' : '' }}">
                        <input id="email_verified" name="email_verified" type="checkbox" value="1" @checked($isProfile ? (bool) $adminUser?->email_verified_at : old('email_verified', $adminUser?->email_verified_at ? '1' : null) == '1') @disabled($isProfile) class="mt-0.5 size-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600 dark:border-gray-600 dark:bg-gray-900">
                    </x-laravel-admin::admin.checkbox-row>
                </div>
            </fieldset>

            <fieldset>
                <legend class="{{ $labelClass }}">{{ __('역할') }}</legend>
                <div class="mt-3 grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($roles as $role)
                        <x-laravel-admin::admin.checkbox-row for="role_{{ $role->id }}" title="{{ $role->name }}" class="items-center px-4 py-3 text-sm font-medium {{ $isProfile ? 'cursor-not-allowed opacity-70' : '' }}">
                            <input id="role_{{ $role->id }}" name="roles[]" type="checkbox" value="{{ $role->id }}" @checked(in_array($role->id, $isProfile ? $roleIds : old('roles', $roleIds))) @disabled($isProfile) class="size-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600 dark:border-gray-600 dark:bg-gray-900">
                        </x-laravel-admin::admin.checkbox-row>
                    @endforeach
                </div>
                <x-laravel-admin::admin.input-error-message class="col-span-full mt-1 text-xs" :messages="$errors->get('roles')" />
            </fieldset>
        </div>
    </div>

    <div class="md:col-span-12 dark:border-white/10 border-b border-gray-900/10 my-10"></div>

    @if($showActions)
        <div class="col-span-full flex items-center justify-end gap-x-3">
            @unless ($isProfile)
                <a href="{{ route('admin.admin-users.index') }}" class="inline-flex h-10 items-center justify-center rounded-md border border-gray-300 bg-white px-4 text-sm font-semibold !text-gray-700 shadow-sm hover:bg-gray-50 hover:no-underline dark:border-gray-600 dark:bg-gray-800 dark:!text-gray-100 dark:hover:bg-gray-700">
                    {{ __('취소') }}
                </a>
            @endunless
            <button type="submit" class="inline-flex h-10 cursor-pointer items-center justify-center rounded-md bg-indigo-600 px-4 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:bg-indigo-500 dark:hover:bg-indigo-400">
                {{ $submitLabel }}
            </button>
        </div>
    @endif
</div>
