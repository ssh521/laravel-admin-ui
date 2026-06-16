<x-laravel-admin::admin.layouts.admin title="메뉴 카테고리 수정">
    <x-slot name="header">
        <x-laravel-admin::admin.admin-header>
            <x-slot name="navigation">
                <a href="{{ route('home') }}">HOME</a>
                - <a href="{{ route('admin.index') }}">관리자 홈</a>
                - <a href="{{ route('admin.menu-categories.index') }}">메뉴 카테고리 관리</a>
            </x-slot>
            <x-slot name="description">{{ __('메뉴 카테고리 수정') }}</x-slot>
        </x-laravel-admin::admin.admin-header>
    </x-slot>

    <div class="mx-auto w-full max-w-5xl bg-white px-2 py-2 dark:bg-gray-900">
        <div class="min-h-[600px] bg-white px-4 py-6 sm:px-6 lg:px-8 dark:bg-gray-900">
            <div class="mx-auto max-w-4xl">
                <h1 class="text-2xl font-semibold leading-7 text-gray-900 dark:text-white">{{ __('메뉴 카테고리 정보 수정') }}</h1>
                <p class="mt-2 text-sm leading-6 text-gray-600 dark:text-gray-400">
                    {{ __('메뉴 카테고리의 이름, 정렬 순서, 활성 상태를 수정합니다.') }}
                </p>
            </div>

            <x-laravel-admin::admin.session-messages />

            <form id="menu-category-edit-form" action="{{ route('admin.menu-categories.update', $menuCategory) }}" method="POST">
                @csrf
                @method('PUT')

                @include('laravel-admin::admin.menu-categories.partials.form', [
                    'menuCategory' => $menuCategory,
                    'submitLabel' => __('수정하기'),
                    'showActions' => false,
                ])
            </form>

            <div class="mx-auto flex w-full max-w-4xl flex-col gap-3 px-2 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex justify-start">
                    @can('delete', $menuCategory)
                        <form action="{{ route('admin.menu-categories.destroy', $menuCategory) }}" method="POST" onsubmit="return confirm('{{ __('정말 삭제하시겠습니까?') }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex h-10 cursor-pointer items-center justify-center rounded-md border border-red-200 bg-white px-4 text-sm font-semibold text-red-700 shadow-sm hover:bg-red-50 dark:border-red-500/30 dark:bg-gray-900 dark:text-red-300 dark:hover:bg-red-500/10">
                                <i class="fa-regular fa-trash-can mr-2 text-xs" aria-hidden="true"></i>
                                {{ __('삭제하기') }}
                            </button>
                        </form>
                    @endcan
                </div>

                <div class="flex flex-wrap justify-end gap-3">
                    <a href="{{ route('admin.menu-categories.roles', $menuCategory) }}" class="inline-flex h-10 items-center justify-center rounded-md border border-gray-300 bg-white px-4 text-sm font-semibold !text-gray-700 shadow-sm hover:bg-gray-50 hover:no-underline dark:border-gray-600 dark:bg-gray-800 dark:!text-gray-100 dark:hover:bg-gray-700">
                        {{ __('권한 관리') }}
                    </a>
                    <a href="{{ route('admin.menu-categories.index') }}" class="inline-flex h-10 items-center justify-center rounded-md border border-gray-300 bg-white px-4 text-sm font-semibold !text-gray-700 shadow-sm hover:bg-gray-50 hover:no-underline dark:border-gray-600 dark:bg-gray-800 dark:!text-gray-100 dark:hover:bg-gray-700">
                        {{ __('목록보기') }}
                    </a>
                    <button type="submit" form="menu-category-edit-form" class="inline-flex h-10 cursor-pointer items-center justify-center rounded-md bg-indigo-600 px-4 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 dark:bg-indigo-500 dark:hover:bg-indigo-400">
                        {{ __('수정하기') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-laravel-admin::admin.layouts.admin>
