<x-laravel-admin::admin.layouts.admin title="사용자 수정">
    <x-slot name="header">
        <x-laravel-admin::admin.admin-header>
            <x-slot name="navigation">
                <a href="{{ route('admin.index') }}">관리자 홈</a>
                @can('viewAny', Ssh521\LaravelAdmin\Models\User::class)
                    - <a href="{{ route('admin.users.index') }}">회원 목록</a>
                @else
                    - {{ __('회원 목록') }}
                @endcan
                - 수정
            </x-slot>
            <x-slot name="description">
                {{ __('회원 정보 수정') }}
            </x-slot>
        </x-laravel-admin::admin.admin-header>
    </x-slot>

    <div class="mx-auto w-full max-w-5xl bg-white px-2 py-2 dark:bg-gray-900">
        <div class="min-h-[600px] bg-white px-4 py-6 sm:px-6 lg:px-8 dark:bg-gray-900">
            <div class="mx-auto max-w-4xl">
                <h1 class="text-2xl font-semibold leading-7 text-gray-900 dark:text-white">{{ __('회원 정보 수정') }}</h1>
                <p class="mt-2 text-sm leading-6 text-gray-600 dark:text-gray-400">
                    {{ __('사용자 계정의 기본 정보, 비밀번호, 이메일 인증 상태를 수정합니다.') }}
                </p>
            </div>

            <x-laravel-admin::admin.session-messages />

            <form id="user-edit-form" action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                @include('laravel-admin::admin.users.partials.form', [
                    'user' => $user,
                    'submitLabel' => __('수정하기'),
                    'showActions' => false,
                ])
            </form>

            <div class="mx-auto flex w-full max-w-4xl flex-row items-center justify-between gap-3 px-2">
                <div class="flex shrink-0 justify-start">
                    @can('delete', $user)
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('{{ __('정말 삭제하시겠습니까?') }}')">
                            @csrf
                            @method('DELETE')
                            <x-laravel-admin::admin.action-button type="submit" variant="danger" icon="trash-can">
                                {{ __('삭제하기') }}
                            </x-laravel-admin::admin.action-button>
                        </form>
                    @endcan
                </div>

                <div class="flex shrink-0 flex-nowrap justify-end gap-3">
                    <x-laravel-admin::admin.action-button variant="secondary" :href="route('admin.users.index')">
                        {{ __('목록보기') }}
                    </x-laravel-admin::admin.action-button>
                    <x-laravel-admin::admin.action-button type="submit" form="user-edit-form">
                        {{ __('수정하기') }}
                    </x-laravel-admin::admin.action-button>
                </div>
            </div>
        </div>
    </div>
</x-laravel-admin::admin.layouts.admin>
