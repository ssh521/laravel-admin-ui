<x-laravel-admin::admin.layouts.admin title="메뉴 등록">
    <x-slot name="header">
        <x-laravel-admin::admin.admin-header>
            <x-slot name="navigation">
                <a href="{{ route('admin.index') }}">관리자 홈</a>
                - <a href="{{ route('admin.menus.index') }}">메뉴 관리</a>
            </x-slot>
            <x-slot name="description">{{ __('메뉴 등록') }}</x-slot>
        </x-laravel-admin::admin.admin-header>
    </x-slot>

    <div class="mx-auto w-full max-w-5xl bg-white px-2 py-2 dark:bg-gray-900">
        <div class="min-h-[600px] bg-white px-4 py-6 sm:px-6 lg:px-8 dark:bg-gray-900">
            <div class="mx-auto max-w-4xl">
                <h1 class="text-2xl font-semibold leading-7 text-gray-900 dark:text-white">{{ __('메뉴 정보 등록') }}</h1>
                <p class="mt-2 text-sm leading-6 text-gray-600 dark:text-gray-400">
                    {{ __('새 메뉴의 기본 정보, 연결 경로, 표시 상태를 설정합니다.') }}
                </p>
            </div>

            <x-laravel-admin::admin.session-messages />

            <form action="{{ route('admin.menus.store') }}" method="POST">
                @csrf

                @include('laravel-admin::admin.menus.partials.form', [
                    'menu' => null,
                    'categories' => $categories,
                    'parentMenus' => $parentMenus,
                    'submitLabel' => __('등록하기'),
                ])
            </form>
        </div>
    </div>
</x-laravel-admin::admin.layouts.admin>
