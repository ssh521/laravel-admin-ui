<x-laravel-admin::admin.layouts.admin title="메뉴 카테고리 수정">
    <x-slot name="header">
        <x-laravel-admin::admin.admin-header>
            <x-slot name="navigation">
                <a href="{{ route('admin.index') }}">관리자 홈</a>
                - <a href="{{ route('admin.menu-categories.index') }}">메뉴 카테고리 목록</a>
                - 수정
            </x-slot>
            <x-slot name="description">{{ __('메뉴 카테고리 수정') }}</x-slot>
        </x-laravel-admin::admin.admin-header>
    </x-slot>

    <div class="mx-auto w-full max-w-5xl bg-white px-2 py-2 dark:bg-gray-900">
        <div class="min-h-[600px] bg-white px-4 py-6 sm:px-6 lg:px-8 dark:bg-gray-900">
            <div class="mx-auto max-w-4xl">
                <h1 class="text-2xl font-semibold leading-7 text-gray-900 dark:text-white">{{ __('메뉴 카테고리 정보 수정') }}</h1>
                <p class="mt-2 text-sm leading-6 text-gray-600 dark:text-gray-400">
                    {{ __('메뉴 카테고리의 이름과 활성 상태를 수정합니다.') }}
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

            <div class="mx-auto flex w-full max-w-4xl flex-row items-center justify-between gap-2 px-2 sm:gap-3"
                data-menu-category-edit-actions>
                <div class="flex shrink-0 justify-start">
                    @can('delete', $menuCategory)
                        <form action="{{ route('admin.menu-categories.destroy', $menuCategory) }}" method="POST" onsubmit="return confirm('{{ __('정말 삭제하시겠습니까?') }}')">
                            @csrf
                            @method('DELETE')
                            <x-laravel-admin::admin.action-button type="submit" variant="danger" icon="trash-can"
                                aria-label="{{ __('삭제하기') }}" title="{{ __('삭제하기') }}">
                                <span class="hidden sm:inline">{{ __('삭제하기') }}</span>
                            </x-laravel-admin::admin.action-button>
                        </form>
                    @endcan
                </div>

                <div class="flex min-w-0 shrink-0 flex-nowrap justify-end gap-2 sm:gap-3">
                    <x-laravel-admin::admin.action-button variant="secondary" :href="route('admin.menu-categories.roles', $menuCategory)"
                        icon="lock" aria-label="{{ __('권한 관리') }}" title="{{ __('권한 관리') }}">
                        <span class="hidden sm:inline">{{ __('권한 관리') }}</span>
                    </x-laravel-admin::admin.action-button>
                    <x-laravel-admin::admin.action-button variant="secondary" :href="route('admin.menu-categories.index')"
                        icon="list" aria-label="{{ __('목록보기') }}" title="{{ __('목록보기') }}">
                        <span class="hidden sm:inline">{{ __('목록보기') }}</span>
                    </x-laravel-admin::admin.action-button>
                    <x-laravel-admin::admin.action-button type="submit" form="menu-category-edit-form" icon="pen-to-square"
                        aria-label="{{ __('수정하기') }}" title="{{ __('수정하기') }}">
                        <span class="sm:hidden">{{ __('수정') }}</span>
                        <span class="hidden sm:inline">{{ __('수정하기') }}</span>
                    </x-laravel-admin::admin.action-button>
                </div>
            </div>
        </div>
    </div>
</x-laravel-admin::admin.layouts.admin>
