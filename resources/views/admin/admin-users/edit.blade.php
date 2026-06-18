<x-laravel-admin::admin.layouts.admin title="관리자 계정 수정">
    <x-slot name="header">
        <x-laravel-admin::admin.admin-header>
            <x-slot name="navigation">
                <a href="{{ route('admin.index') }}">관리자 홈</a>
                - <a href="{{ route('admin.admin-users.index') }}">관리자 계정</a>
            </x-slot>
            <x-slot name="description">
                {{ __('관리자 계정 수정') }}
            </x-slot>
        </x-laravel-admin::admin.admin-header>
    </x-slot>

    <div class="mx-auto w-full max-w-5xl bg-white px-2 py-2 dark:bg-gray-900">
        <div class="min-h-[450px] bg-white px-4 py-6 sm:px-6 lg:px-8 dark:bg-gray-900">
            <div class="mx-auto max-w-4xl">
                <h1 class="text-2xl font-semibold leading-7 text-gray-900 dark:text-white">{{ __('관리자 계정 정보 수정') }}</h1>
                <p class="mt-2 text-sm leading-6 text-gray-600 dark:text-gray-400">
                    {{ __('관리자 계정의 기본 정보, 비밀번호, 권한을 수정합니다.') }}
                </p>
            </div>

            @php
                $isProfile = $isProfile ?? false;
                $formRoute = $isProfile
                    ? route(config('laravel-admin.route_name_prefix', 'admin.').'profile.update')
                    : route('admin.admin-users.update', $adminUser->getKey());
            @endphp

            <form id="admin-user-edit-form" action="{{ $formRoute }}" method="POST">
                @csrf
                @method('PUT')

                @include('laravel-admin::admin.admin-users.partials.form', [
                    'adminUser' => $adminUser,
                    'roles' => $roles,
                    'isProfile' => $isProfile,
                    'submitLabel' => __('수정하기'),
                    'showActions' => $isProfile,
                ])
            </form>

            @unless ($isProfile)
                <div class="mx-auto flex w-full max-w-4xl flex-col gap-3 px-2 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex justify-start">
                        <form action="{{ route('admin.admin-users.destroy', $adminUser->getKey()) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure you want to delete this admin user?') }}');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex h-10 cursor-pointer items-center justify-center rounded-md border border-red-200 bg-white px-4 text-sm font-semibold text-red-700 shadow-sm hover:bg-red-50 dark:border-red-500/30 dark:bg-gray-900 dark:text-red-300 dark:hover:bg-red-500/10">
                                <i class="fa-regular fa-trash-can mr-2 text-xs" aria-hidden="true"></i>
                                {{ __('삭제하기') }}
                            </button>
                        </form>
                    </div>

                    <div class="flex flex-wrap justify-end gap-3">
                        <a href="{{ route('admin.admin-users.index') }}" class="inline-flex h-10 items-center justify-center rounded-md border border-gray-300 bg-white px-4 text-sm font-semibold !text-gray-700 shadow-sm hover:bg-gray-50 hover:no-underline dark:border-gray-600 dark:bg-gray-800 dark:!text-gray-100 dark:hover:bg-gray-700">
                            {{ __('취소') }}
                        </a>
                        <button type="submit" form="admin-user-edit-form" class="inline-flex h-10 cursor-pointer items-center justify-center rounded-md bg-indigo-600 px-4 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 dark:bg-indigo-500 dark:hover:bg-indigo-400">
                            {{ __('수정하기') }}
                        </button>
                    </div>
                </div>
            @endunless

        </div>
    </div>

    @if ($isProfile && session('success'))
        <script>
            window.addEventListener('load', () => {
                window.dispatchEvent(new CustomEvent('notification:show', {
                    detail: {
                        message: @js(session('success')),
                        type: 'success',
                    },
                }));
            });
        </script>
    @endif
</x-laravel-admin::admin.layouts.admin>
