@php
    $user = $user ?? null;
    $showActions = $showActions ?? true;
    $submitLabel = $submitLabel ?? __('저장하기');
    $inputClass = 'block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm outline-none placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-gray-600 dark:bg-gray-900 dark:text-white';
    $labelClass = 'block text-sm font-medium leading-6 text-gray-900 dark:text-white';
@endphp

<div class="mx-auto grid max-w-4xl grid-cols-1 gap-x-8 text-gray-900 md:grid-cols-12 dark:text-gray-100">
    <div class="my-10 border-b border-gray-900/10 md:col-span-12 dark:border-white/10"></div>

    <div class="md:col-span-4">
        <div class="flex flex-col">
            <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">{{ __('기본 정보') }}</h2>
            <p class="mt-1 text-sm leading-6 text-gray-600 dark:text-gray-400">
                {{ $user ? __('사용자 이름과 로그인 이메일을 관리합니다.') : __('사용자 이름과 로그인 이메일을 입력합니다.') }}
            </p>
        </div>
    </div>

    <div class="md:col-span-8">
        <div class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-6">
            <div class="sm:col-span-3">
                <label for="name" class="{{ $labelClass }}">{{ __('이름') }}</label>
                <div class="mt-2">
                    <input id="name" name="name" type="text" value="{{ old('name', $user?->name) }}" autocomplete="name" placeholder="Enter user name" @required(! $user) class="{{ $inputClass }}">
                </div>
                <x-laravel-admin::admin.input-error-message class="mt-2 text-xs" :messages="$errors->get('name')" />
            </div>

            <div class="sm:col-span-4">
                <label for="email" class="{{ $labelClass }}">{{ __('E-mail') }}</label>
                <div class="mt-2">
                    <input id="email" name="email" type="email" value="{{ old('email', $user?->email) }}" autocomplete="email" placeholder="Enter email address" @required(! $user) class="{{ $inputClass }}">
                </div>
                <x-laravel-admin::admin.input-error-message class="mt-2 text-xs" :messages="$errors->get('email')" />
            </div>
        </div>
    </div>

    <div class="my-10 border-b border-gray-900/10 md:col-span-12 dark:border-white/10"></div>

    <div class="md:col-span-4">
        <div class="flex flex-col">
            <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">{{ __('비밀번호') }}</h2>
            <p class="mt-1 text-sm leading-6 text-gray-600 dark:text-gray-400">
                {{ $user ? __('변경하지 않으려면 비워두세요.') : __('새 사용자 계정의 비밀번호를 설정합니다.') }}
            </p>
        </div>
    </div>

    <div class="md:col-span-8">
        <div class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-6">
            <div class="sm:col-span-3">
                <label for="password" class="{{ $labelClass }}">{{ __('비밀번호') }}</label>
                <div class="mt-2">
                    <input id="password" name="password" type="password" autocomplete="new-password" placeholder="{{ $user ? 'Enter new password' : 'Enter password' }}" @required(! $user) class="{{ $inputClass }}">
                </div>
                <x-laravel-admin::admin.input-error-message class="mt-2 text-xs" :messages="$errors->get('password')" />
            </div>

            <div class="sm:col-span-3">
                <label for="confirm-password" class="{{ $labelClass }}">{{ __('비밀번호 확인') }}</label>
                <div class="mt-2">
                    <input id="confirm-password" name="confirm-password" type="password" autocomplete="new-password" placeholder="{{ $user ? 'Confirm new password' : 'Confirm password' }}" @required(! $user) class="{{ $inputClass }}">
                </div>
                <x-laravel-admin::admin.input-error-message class="mt-2 text-xs" :messages="$errors->get('confirm-password')" />
            </div>
        </div>
    </div>

    <div class="my-10 border-b border-gray-900/10 md:col-span-12 dark:border-white/10"></div>

    <div class="md:col-span-4">
        <div class="flex flex-col">
            <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">{{ __('인증') }}</h2>
            <p class="mt-1 text-sm leading-6 text-gray-600 dark:text-gray-400">
                {{ __('이메일 인증 완료 여부를 지정합니다.') }}
            </p>
        </div>
    </div>

    <div class="md:col-span-8">
        <label for="email_verified" class="flex min-h-12 cursor-pointer items-start gap-3 rounded-md border border-gray-200 bg-white p-4 shadow-sm hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-900 dark:hover:bg-gray-800">
            <input id="email_verified" name="email_verified" type="checkbox" value="1" @checked(old('email_verified', $user?->email_verified_at ? '1' : null) == '1') class="mt-0.5 size-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600 dark:border-gray-600 dark:bg-gray-900">
            <span>
                <span class="block text-sm font-medium text-gray-900 dark:text-white">{{ __('Email Verified') }}</span>
                <span class="block text-sm text-gray-500 dark:text-gray-400">
                    @if ($user?->email_verified_at)
                        {{ __('Verified on') }}: {{ $user->email_verified_at->format('Y-m-d H:i:s') }}
                    @elseif ($user)
                        {{ __('Not Verified') }}
                    @else
                        {{ __('체크하면 이메일 인증이 완료된 사용자로 표시됩니다.') }}
                    @endif
                </span>
            </span>
        </label>
    </div>

    <div class="my-10 border-b border-gray-900/10 md:col-span-12 dark:border-white/10"></div>

    @if($showActions)
        <div class="col-span-full flex items-center justify-end gap-x-3">
            <x-laravel-admin::admin.action-button variant="secondary" :href="route('admin.users.index')">
                {{ __('목록보기') }}
            </x-laravel-admin::admin.action-button>
            <x-laravel-admin::admin.action-button type="submit">
                {{ $submitLabel }}
            </x-laravel-admin::admin.action-button>
        </div>
    @endif
</div>
