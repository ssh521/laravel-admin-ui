<x-laravel-admin::admin.layouts.admin title="관리자 홈">
    <x-slot name="header">
        <x-laravel-admin::admin.admin-header>
            <x-slot name="navigation">
                <a href="{{ route('admin.index') }}">관리자 홈</a>
            </x-slot>
            <x-slot name="description">
                관리자 대시보드
            </x-slot>
        </x-laravel-admin::admin.admin-header>
    </x-slot>

    <x-laravel-admin::admin.page-section>
        @can('viewStatistics', 'admin')
            <div class="mb-8 grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
                <x-laravel-admin::admin.stat
                    label="총 관리자"
                    :value="$stats['total_admin_users'] ?? 0"
                    class="border-t-4 border-t-indigo-500 bg-gradient-to-br from-indigo-50 to-white dark:border-t-indigo-400 dark:from-indigo-500/15 dark:to-gray-900"
                />
                <x-laravel-admin::admin.stat
                    label="총 역할"
                    :value="$stats['total_roles'] ?? 0"
                    class="border-t-4 border-t-green-500 bg-gradient-to-br from-green-50 to-white dark:border-t-green-400 dark:from-green-500/15 dark:to-gray-900"
                />
                <x-laravel-admin::admin.stat
                    label="총 권한"
                    :value="$stats['total_permissions'] ?? 0"
                    class="border-t-4 border-t-amber-500 bg-gradient-to-br from-amber-50 to-white dark:border-t-amber-400 dark:from-amber-500/15 dark:to-gray-900"
                />
                <x-laravel-admin::admin.stat
                    label="총 메뉴 카테고리"
                    :value="$stats['total_menu_categories'] ?? 0"
                    class="border-t-4 border-t-purple-500 bg-gradient-to-br from-purple-50 to-white dark:border-t-purple-400 dark:from-purple-500/15 dark:to-gray-900"
                />
            </div>
        @endcan

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            @can('manageUsers', 'admin')
                <x-laravel-admin::admin.card
                    title="관리자 계정"
                    description="관리자 로그인 계정을 관리합니다."
                    class="h-full transition-shadow hover:shadow-md"
                >
                    <x-laravel-admin::admin.action-button :href="route('admin.admin-users.index')">
                        관리하기
                    </x-laravel-admin::admin.action-button>
                </x-laravel-admin::admin.card>

                @if (Route::has('admin.users.index'))
                    <x-laravel-admin::admin.card
                        title="사용자 관리"
                        description="시스템 사용자들을 관리합니다."
                        class="h-full transition-shadow hover:shadow-md"
                    >
                        <x-laravel-admin::admin.action-button :href="route('admin.users.index')">
                            관리하기
                        </x-laravel-admin::admin.action-button>
                    </x-laravel-admin::admin.card>
                @endif
            @endcan

            @can('manageRoles', 'admin')
                <x-laravel-admin::admin.card
                    title="역할 관리"
                    description="사용자 역할을 관리합니다."
                    class="h-full transition-shadow hover:shadow-md"
                >
                    <x-laravel-admin::admin.action-button :href="route('admin.roles.index')">
                        관리하기
                    </x-laravel-admin::admin.action-button>
                </x-laravel-admin::admin.card>
            @endcan

            @can('managePermissions', 'admin')
                <x-laravel-admin::admin.card
                    title="권한 관리"
                    description="시스템 권한을 관리합니다."
                    class="h-full transition-shadow hover:shadow-md"
                >
                    <x-laravel-admin::admin.action-button :href="route('admin.permissions.index')">
                        관리하기
                    </x-laravel-admin::admin.action-button>
                </x-laravel-admin::admin.card>
            @endcan

            @can('manageMenus', 'admin')
                <x-laravel-admin::admin.card
                    title="메뉴 관리"
                    description="시스템 메뉴를 관리합니다."
                    class="h-full transition-shadow hover:shadow-md"
                >
                    <x-laravel-admin::admin.action-button :href="route('admin.menu-categories.index')">
                        관리하기
                    </x-laravel-admin::admin.action-button>
                </x-laravel-admin::admin.card>
            @endcan
        </div>
    </x-laravel-admin::admin.page-section>
</x-laravel-admin::admin.layouts.admin>
