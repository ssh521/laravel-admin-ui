<x-laravel-admin::admin.layouts.admin title="관리자 홈">

    <x-slot name="header">

        <x-laravel-admin::admin.admin-header>
                <x-slot name="navigation">
                    <a href="{{ route('admin.index') }}">관리자 홈</a>
                </x-slot>
                <x-slot name="description">
                    {{ __('Dashboard') }}
                </x-slot>
        </x-laravel-admin::admin.admin-header>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                <!-- 통계 카드들 -->
                @can('viewStatistics', 'admin')
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-indigo-100 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-indigo-800">총 관리자</h3>
                        <p class="text-3xl font-bold text-indigo-600">{{ $stats['total_admin_users'] ?? 0 }}</p>
                    </div>

                    <div class="bg-green-100 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-green-800">총 역할</h3>
                        <p class="text-3xl font-bold text-green-600">{{ $stats['total_roles'] ?? 0 }}</p>
                    </div>

                    <div class="bg-yellow-100 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-yellow-800">총 권한</h3>
                        <p class="text-3xl font-bold text-yellow-600">{{ $stats['total_permissions'] ?? 0 }}</p>
                    </div>

                    <div class="bg-purple-100 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-purple-800">총 메뉴 카테고리</h3>
                        <p class="text-3xl font-bold text-purple-600">{{ $stats['total_menu_categories'] ?? 0 }}</p>
                    </div>
                </div>
                @endcan

                <!-- 관리 메뉴들 -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                    @can('manageUsers', 'admin')
                    <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                        <h3 class="text-lg font-semibold mb-4">관리자 계정</h3>
                        <p class="text-gray-600 mb-4">관리자 로그인 계정을 관리합니다.</p>
                        <x-laravel-admin::admin.action-button :href="route('admin.admin-users.index')">
                            관리하기
                        </x-laravel-admin::admin.action-button>
                    </div>

                    @if (Route::has('admin.users.index'))
                        <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                            <h3 class="text-lg font-semibold mb-4">사용자 관리</h3>
                            <p class="text-gray-600 mb-4">시스템 사용자들을 관리합니다.</p>
                            <x-laravel-admin::admin.action-button :href="route('admin.users.index')">
                                관리하기
                            </x-laravel-admin::admin.action-button>
                        </div>
                    @endif
                    @endcan

                    @can('manageRoles', 'admin')
                    <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                        <h3 class="text-lg font-semibold mb-4">역할 관리</h3>
                        <p class="text-gray-600 mb-4">사용자 역할을 관리합니다.</p>
                        <x-laravel-admin::admin.action-button :href="route('admin.roles.index')">
                            관리하기
                        </x-laravel-admin::admin.action-button>
                    </div>
                    @endcan

                    @can('managePermissions', 'admin')
                    <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                        <h3 class="text-lg font-semibold mb-4">권한 관리</h3>
                        <p class="text-gray-600 mb-4">시스템 권한을 관리합니다.</p>
                        <x-laravel-admin::admin.action-button :href="route('admin.permissions.index')">
                            관리하기
                        </x-laravel-admin::admin.action-button>
                    </div>
                    @endcan

                    @can('manageMenus', 'admin')
                    <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                        <h3 class="text-lg font-semibold mb-4">메뉴 관리</h3>
                        <p class="text-gray-600 mb-4">시스템 메뉴를 관리합니다.</p>
                        <x-laravel-admin::admin.action-button :href="route('admin.menu-categories.index')">
                            관리하기
                        </x-laravel-admin::admin.action-button>
                    </div>
                    @endcan

                    @can('viewLogs', 'admin')
                    <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                        <h3 class="text-lg font-semibold mb-4">시스템 로그</h3>
                        <p class="text-gray-600 mb-4">시스템 로그를 확인합니다.</p>
                        <x-laravel-admin::admin.action-button href="#" variant="secondary">
                            확인하기
                        </x-laravel-admin::admin.action-button>
                    </div>
                    @endcan

                    @can('manageSettings', 'admin')
                    <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                        <h3 class="text-lg font-semibold mb-4">시스템 설정</h3>
                        <p class="text-gray-600 mb-4">시스템 설정을 관리합니다.</p>
                        <x-laravel-admin::admin.action-button href="#" variant="secondary">
                            설정하기
                        </x-laravel-admin::admin.action-button>
                    </div>
                    @endcan

                </div>

            </div>
        </div>
    </div>

</x-laravel-admin::admin.layouts.admin>
