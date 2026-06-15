<x-laravel-admin::admin.layouts.admin title="사용자 수정">
    <x-slot name="header">
        <x-laravel-admin::admin.admin-header>
            <x-slot name="navigation">
                <a href="{{ route('home') }}">HOME</a>
                - <a href="{{ route('admin.index') }}">관리자 홈</a>
                @can('viewAny', Ssh521\LaravelAdmin\Models\User::class)
                    - <a href="{{ route('admin.users.index') }}">회원 리스트</a>
                @endcan
            </x-slot>
            <x-slot name="description">
                {{ __('Edit User') }}
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
                <h1 class="text-2xl font-semibold leading-7 text-gray-900 dark:text-white">{{ __('User Information') }}</h1>
                <p class="mt-2 text-sm leading-6 text-gray-600 dark:text-gray-400">
                    {{ __('사용자 계정의 기본 정보, 비밀번호, 이메일 인증 상태를 수정합니다.') }}
                </p>
            </div>

            <x-laravel-admin::admin.session-messages />

            <form id="user-edit-form" action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mx-auto grid max-w-4xl grid-cols-1 gap-x-8 text-gray-900 md:grid-cols-12 dark:text-gray-100">
                    <div class="my-10 border-b border-gray-900/10 md:col-span-12 dark:border-white/10"></div>

                    <div class="md:col-span-4">
                        <div class="flex flex-col">
                            <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">{{ __('기본 정보') }}</h2>
                            <p class="mt-1 text-sm leading-6 text-gray-600 dark:text-gray-400">
                                {{ __('사용자 이름과 로그인 이메일을 관리합니다.') }}
                            </p>
                        </div>
                    </div>

                    <div class="md:col-span-8">
                        <div class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-6">
                            <div class="sm:col-span-3">
                                <label for="name" class="{{ $labelClass }}">{{ __('이름') }}</label>
                                <div class="mt-2">
                                    <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" autocomplete="name" placeholder="Enter user name" class="{{ $inputClass }}">
                                </div>
                                <x-laravel-admin::admin.input-error-message class="mt-2 text-xs" :messages="$errors->get('name')" />
                            </div>

                            <div class="sm:col-span-4">
                                <label for="email" class="{{ $labelClass }}">{{ __('E-mail') }}</label>
                                <div class="mt-2">
                                    <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" autocomplete="email" placeholder="Enter email address" class="{{ $inputClass }}">
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
                                {{ __('변경하지 않으려면 비워두세요.') }}
                            </p>
                        </div>
                    </div>

                    <div class="md:col-span-8">
                        <div class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-6">
                            <div class="sm:col-span-3">
                                <label for="password" class="{{ $labelClass }}">{{ __('비밀번호') }}</label>
                                <div class="mt-2">
                                    <input id="password" name="password" type="password" autocomplete="new-password" placeholder="Enter new password" class="{{ $inputClass }}">
                                </div>
                                <x-laravel-admin::admin.input-error-message class="mt-2 text-xs" :messages="$errors->get('password')" />
                            </div>

                            <div class="sm:col-span-3">
                                <label for="confirm-password" class="{{ $labelClass }}">{{ __('비밀번호 확인') }}</label>
                                <div class="mt-2">
                                    <input id="confirm-password" name="confirm-password" type="password" autocomplete="new-password" placeholder="Confirm new password" class="{{ $inputClass }}">
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
                            <input id="email_verified" name="email_verified" type="checkbox" value="1" @checked(old('email_verified', $user->email_verified_at ? '1' : null) == '1') class="mt-0.5 size-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600 dark:border-gray-600 dark:bg-gray-900">
                            <span>
                                <span class="block text-sm font-medium text-gray-900 dark:text-white">{{ __('Email Verified') }}</span>
                                <span class="block text-sm text-gray-500 dark:text-gray-400">
                                    @if ($user->email_verified_at)
                                        {{ __('Verified on') }}: {{ $user->email_verified_at->format('Y-m-d H:i:s') }}
                                    @else
                                        {{ __('Not Verified') }}
                                    @endif
                                </span>
                            </span>
                        </label>
                    </div>

                    <div class="my-10 border-b border-gray-900/10 md:col-span-12 dark:border-white/10"></div>
                </div>
            </form>

            <div class="mx-auto mt-6 flex w-full max-w-4xl flex-col gap-3 px-2 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex justify-start">
                    @if($user->id != auth()->user()->id)
                        @can('delete', $user)
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('{{ __('정말 삭제하시겠습니까?') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex h-10 cursor-pointer items-center justify-center rounded-md border border-red-200 bg-white px-4 text-sm font-semibold text-red-700 shadow-sm hover:bg-red-50 dark:border-red-500/30 dark:bg-gray-900 dark:text-red-300 dark:hover:bg-red-500/10">
                                    <i class="fa-regular fa-trash-can mr-2 text-xs" aria-hidden="true"></i>
                                    {{ __('삭제하기') }}
                                </button>
                            </form>
                        @endcan
                    @endif
                </div>

                <div class="flex flex-wrap justify-end gap-3">
                    <a href="{{ route('admin.users.index') }}" class="inline-flex h-10 items-center justify-center rounded-md border border-gray-300 bg-white px-4 text-sm font-semibold !text-gray-700 shadow-sm hover:bg-gray-50 hover:no-underline dark:border-gray-600 dark:bg-gray-800 dark:!text-gray-100 dark:hover:bg-gray-700">
                        {{ __('목록보기') }}
                    </a>
                    <button type="submit" form="user-edit-form" class="inline-flex h-10 cursor-pointer items-center justify-center rounded-md bg-indigo-600 px-4 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 dark:bg-indigo-500 dark:hover:bg-indigo-400">
                        {{ __('수정하기') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-laravel-admin::admin.layouts.admin>
