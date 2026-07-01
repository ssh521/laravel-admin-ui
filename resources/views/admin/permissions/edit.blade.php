<x-laravel-admin::admin.layouts.admin title="권한 수정">
    <x-slot name="header">
        <x-laravel-admin::admin.admin-header>
            <x-slot name="navigation">
                <a href="{{ route('admin.index') }}">{{ __('관리자 홈') }}</a>
                - <a href="{{ route('admin.permissions.index') }}">{{ __('권한 목록') }}</a>
                - {{ __('수정') }}
            </x-slot>
            <x-slot name="description">
                {{ __('권한 수정') }}
            </x-slot>
        </x-laravel-admin::admin.admin-header>
    </x-slot>

    <div class="mx-auto w-full max-w-5xl bg-white px-2 py-2 dark:bg-gray-900">
        <div class="min-h-[600px] bg-white px-4 py-6 sm:px-6 lg:px-8 dark:bg-gray-900">
            <div class="mx-auto max-w-4xl">
                <h1 class="text-2xl font-semibold leading-7 text-gray-900 dark:text-white">{{ __('권한 정보 수정') }}</h1>
                <p class="mt-2 text-sm leading-6 text-gray-600 dark:text-gray-400">
                    {{ __('권한의 이름과 설명을 수정합니다.') }}
                </p>
            </div>

            <form id="permission-edit-form" action="{{ route('admin.permissions.update', $permission) }}" method="POST">
                @csrf
                @method('PUT')

                @include('laravel-admin::admin.permissions.partials.form', [
                    'permission' => $permission,
                    'submitLabel' => __('수정하기'),
                    'showActions' => false,
                ])
            </form>

            <div class="mx-auto flex w-full max-w-4xl flex-row items-center justify-between gap-3 px-2">
                <div class="flex shrink-0 justify-start">
                    @can('delete', $permission)
                        <form action="{{ route('admin.permissions.destroy', $permission) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <x-laravel-admin::admin.action-button type="submit" variant="danger" icon="trash-can" onclick="return confirm('{{ __('정말 삭제하시겠습니까?') }}')">
                                {{ __('삭제하기') }}
                            </x-laravel-admin::admin.action-button>
                        </form>
                    @endcan
                </div>

                <div class="flex shrink-0 flex-nowrap justify-end gap-3">
                    <x-laravel-admin::admin.action-button variant="secondary" :href="route('admin.permissions.index')">
                        {{ __('목록보기') }}
                    </x-laravel-admin::admin.action-button>
                    <x-laravel-admin::admin.action-button type="submit" form="permission-edit-form">
                        {{ __('수정하기') }}
                    </x-laravel-admin::admin.action-button>
                </div>
            </div>
        </div>
    </div>
</x-laravel-admin::admin.layouts.admin>
