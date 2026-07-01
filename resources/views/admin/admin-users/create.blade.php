<x-laravel-admin::admin.layouts.admin title="관리자 계정 등록">
    <x-slot name="header">
        <x-laravel-admin::admin.admin-header>
            <x-slot name="navigation">
                <a href="{{ route('admin.index') }}">관리자 홈</a>
                - <a href="{{ route('admin.admin-users.index') }}">관리자 계정 목록</a>
                - 등록
            </x-slot>
            <x-slot name="description">
                {{ __('관리자 계정 등록') }}
            </x-slot>
        </x-laravel-admin::admin.admin-header>
    </x-slot>

    <div class="mx-auto w-full max-w-5xl bg-white px-2 py-2 dark:bg-gray-900">
        <div class="min-h-[450px] bg-white px-4 py-6 sm:px-6 lg:px-8 dark:bg-gray-900">
            <div class="mx-auto max-w-4xl">
                <h1 class="text-2xl font-semibold leading-7 text-gray-900 dark:text-white">{{ __('관리자 계정 정보 등록') }}</h1>
                <p class="mt-2 text-sm leading-6 text-gray-600 dark:text-gray-400">
                    {{ __('새 관리자 계정의 기본 정보, 비밀번호, 권한을 설정합니다.') }}
                </p>
            </div>

            <form action="{{ route('admin.admin-users.store') }}" method="POST">
                @csrf

                @include('laravel-admin::admin.admin-users.partials.form', [
                    'adminUser' => null,
                    'roles' => $roles,
                    'submitLabel' => __('등록하기'),
                ])
            </form>
        </div>
    </div>
</x-laravel-admin::admin.layouts.admin>
