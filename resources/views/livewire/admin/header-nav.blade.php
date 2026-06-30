<header x-data="{
        isVisible: true,
        lastScrollY: 0,
        scrollThreshold: 100,
        scrollTimeout: null,
        init() {
            this.lastScrollY = window.scrollY;

            window.addEventListener('scroll', () => {
                const currentScrollY = window.scrollY;

                // 스크롤 방향 감지
                if (currentScrollY > this.lastScrollY && currentScrollY > this.scrollThreshold) {
                    // 아래로 스크롤하고 임계값 이상 스크롤된 경우 헤더 숨김
                    this.isVisible = false;
                } else if (currentScrollY < this.lastScrollY) {
                    // 위로 스크롤하는 경우 헤더 표시
                    this.isVisible = true;
                }

                // 스크롤이 멈춘 후 일정 시간 후에 헤더 표시 (선택사항)
                clearTimeout(this.scrollTimeout);
                this.scrollTimeout = setTimeout(() => {
                    if (currentScrollY > this.scrollThreshold) {
                        this.isVisible = true;
                    }
                }, 2000);

                this.lastScrollY = currentScrollY;
            });
        }
    }" x-show="isVisible" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="transform -translate-y-full" x-transition:enter-end="transform translate-y-0"
    x-transition:leave="transition ease-in duration-300" x-transition:leave-start="transform translate-y-0"
    x-transition:leave-end="transform -translate-y-full"
    class="fixed top-0 left-0 w-full z-50 bg-white dark:bg-[#000000] border-b border-gray-400 dark:border-gray-800 shadow-lg flex items-center h-16 px-4">

    <!-- 햄버거 버튼 -->
    <button class="block lg:hidden mr-0 p-2 rounded-full hover:bg-purple-100 dark:hover:bg-purple-800 transition"
        @click="isMobileMenuOpen = !isMobileMenuOpen;">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-700 dark:text-purple-300" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    <!-- 햄버거 버튼 -->
    <button
        class="hidden lg:block mr-2 p-2 rounded-full hover:bg-purple-100 dark:hover:bg-purple-800 transition relative group"
        @click="isDesktop = !isDesktop" title="사이드바 토글 (Ctrl+B)">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-700 dark:text-purple-300" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>

        <!-- 단축키 안내 툴팁 -->
        <div
            class="absolute top-full left-1/2 transform -translate-x-1/2 -mt-2 px-2 py-1 bg-gray-900 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap z-50">
            Ctrl+B
            <div
                class="absolute bottom-full left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-4 border-r-4 border-b-4 border-transparent border-b-gray-900">
            </div>
        </div>
    </button>

    <!-- 로고 -->
    <a href="{{ route('admin.index') }}" class="flex items-center gap-2" style="text-decoration: none;">
        <x-laravel-admin::admin.site-logo class="w-[22px] -mb-1 dark:text-purple-200" />
        <span class="text-md lg:text-xl font-bold text-purple-700 dark:text-purple-200 tracking-tight">관리자 메뉴</span>
    </a>

    <x-laravel-admin::admin.dark-mode-toggle class="ml-0" />

    <div class="flex-1">
        @include('laravel-admin::livewire.admin.partials.header-menu-search')
    </div>

    <!-- 우측: 드롭다운 메뉴 -->
    <div class="flex items-center gap-4">
        @if (class_exists(\Ssh521\LaravelBroadcastNotification\LaravelBroadcastNotificationServiceProvider::class))
            <x-laravel-broadcast-notification::admin.dropdown />
        @endif

        @php
            $user = Auth::user();
            $hasJetstream = class_exists(\Laravel\Jetstream\Jetstream::class);
            $hasTeamRoutes = Route::has('teams.show');
            $canCreateTeamsRoute = Route::has('teams.create');
            $hasTeamFeatures = $user && $hasJetstream && $hasTeamRoutes && \Laravel\Jetstream\Jetstream::hasTeamFeatures() && $user->currentTeam;
            $newTeamModel = $hasTeamFeatures ? \Laravel\Jetstream\Jetstream::newTeamModel() : null;
            $managesProfilePhotos = $user && $hasJetstream && \Laravel\Jetstream\Jetstream::managesProfilePhotos();
            $hasApiFeatures = $hasJetstream && \Laravel\Jetstream\Jetstream::hasApiFeatures() && Route::has('api-tokens.index');
            $adminProfileRoute = config('laravel-admin.route_name_prefix', 'admin.').'profile.show';
            $profileRoute = Route::has($adminProfileRoute)
                ? $adminProfileRoute
                : (Route::has('profile.show') ? 'profile.show' : null);
            $adminLogoutRoute = config('laravel-admin.route_name_prefix', 'admin.').'logout';
            $logoutRoute = Route::has($adminLogoutRoute)
                ? $adminLogoutRoute
                : (Route::has('logout') ? 'logout' : null);
        @endphp

        <!-- Teams Dropdown -->
        @if ($hasTeamFeatures)
        <div class="ms-3 relative">
            <x-laravel-admin::admin.dropdown
                align="right"
                width="60"
                contentClasses="overflow-hidden rounded-lg border border-gray-200 bg-white py-1 shadow-xl dark:border-gray-700 dark:bg-gray-900">
                <x-slot name="trigger">
                    <span class="inline-flex rounded-md">
                        <button type="button"
                            class="inline-flex items-center rounded-md border border-gray-200 bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-700 shadow-sm transition hover:border-indigo-300 hover:text-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 dark:hover:border-indigo-500 dark:hover:text-indigo-300 dark:focus:ring-offset-gray-900">
                            {{ $user->currentTeam->name }}
                            <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                            </svg>
                        </button>
                    </span>
                </x-slot>
                <x-slot name="content">
                    <div class="w-60">
                        <!-- Team Management -->
                        <div class="block px-4 py-2 text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                            {{ __('Manage Team') }}
                        </div>
                        <!-- Team Settings -->
                        <x-laravel-admin::admin.dropdown-link href="{{ route('teams.show', $user->currentTeam->id) }}">
                            {{ __('Team Settings') }}
                        </x-laravel-admin::admin.dropdown-link>
                        @if ($canCreateTeamsRoute)
                        @can('create', $newTeamModel)
                        <x-laravel-admin::admin.dropdown-link href="{{ route('teams.create') }}">
                            {{ __('Create New Team') }}
                        </x-laravel-admin::admin.dropdown-link>
                        @endcan
                        @endif
                        <!-- Team Switcher -->
                        @if ($user->allTeams()->count() > 1)
                        <div class="border-t border-gray-200 dark:border-gray-700"></div>
                        <div class="block px-4 py-2 text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                            {{ __('Switch Teams') }}
                        </div>
                        @foreach ($user->allTeams() as $team)
                        <x-laravel-admin::admin.switchable-team :team="$team" />
                        @endforeach
                        @endif
                    </div>
                </x-slot>
            </x-laravel-admin::admin.dropdown>
        </div>
        @endif

        <!-- Settings Dropdown -->
        <div class="ms-3 relative">
            <x-laravel-admin::admin.dropdown
                align="right"
                width="48"
                contentClasses="overflow-hidden rounded-lg border border-gray-200 bg-white py-1 shadow-xl dark:border-gray-700 dark:bg-gray-900">
                <x-slot name="trigger">
                    @if ($managesProfilePhotos)
                    <button
                        class="flex rounded-full border border-gray-200 bg-white p-0.5 text-sm shadow-sm transition hover:border-indigo-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:border-gray-700 dark:bg-gray-900 dark:hover:border-indigo-500 dark:focus:ring-offset-gray-900">
                        <img class="size-8 rounded-full object-cover" src="{{ $user->profile_photo_url }}"
                            alt="{{ $user->name }}" />
                    </button>
                    @else
                    <span class="inline-flex rounded-md">
                        <button type="button"
                            class="inline-flex max-w-44 items-center gap-2 rounded-md border border-gray-200 bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-700 shadow-sm transition hover:border-indigo-300 hover:text-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 dark:hover:border-indigo-500 dark:hover:text-indigo-300 dark:focus:ring-offset-gray-900">
                            <span class="inline-flex size-6 shrink-0 items-center justify-center rounded-full bg-gray-100 text-xs font-semibold text-gray-600 dark:bg-gray-800 dark:text-gray-300">
                                {{ mb_substr($user?->name ?? __('Admin'), 0, 1) }}
                            </span>
                            <span class="truncate">
                            {{ $user?->name ?? __('Admin') }}
                            </span>
                            <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>
                    </span>
                    @endif
                </x-slot>

                <x-slot name="content">

                    <!-- Admin Management -->
                    <div class="block px-4 py-2 text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                        {{ __('Admin Management') }}
                    </div>


                    @if(auth()->user())
                    <x-laravel-admin::admin.dropdown-link href="{{ route('admin.index') }}" :active="request()->routeIs('admin.index')" class="!text-gray-700 hover:!bg-gray-50 hover:!text-indigo-700 dark:!text-gray-300 dark:hover:!bg-gray-800 dark:hover:!text-indigo-300">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="w-4 h-4 mr-2 inline -mt-1">
                            <circle cx="12" cy="12" r="3" />
                            <path
                                d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09a1.65 1.65 0 0 0-1-1.51 1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09a1.65 1.65 0 0 0 1.51-1 1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33h.09A1.65 1.65 0 0 0 11 3.09V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51h.09a1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82v.09a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z" />
                        </svg>
                        {{ __('관리자 홈') }}
                    </x-laravel-admin::admin.dropdown-link>
                    @endif

                    <div class="border-t border-gray-200 dark:border-gray-700"></div>

                    <!-- Account Management -->
                    <div class="block px-4 py-2 text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                        {{ __('Manage Account') }}
                    </div>

                    @if ($profileRoute)
                    <x-laravel-admin::admin.dropdown-link href="{{ route($profileRoute) }}" class="!text-gray-700 hover:!bg-gray-50 hover:!text-indigo-700 dark:!text-gray-300 dark:hover:!bg-gray-800 dark:hover:!text-indigo-300">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="w-4 h-4 mr-2 inline -mt-1">
                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>{{ __('Profile') }}
                    </x-laravel-admin::admin.dropdown-link>
                    @endif
                    @if ($hasApiFeatures)
                    <x-laravel-admin::admin.dropdown-link href="{{ route('api-tokens.index') }}" class="!text-gray-700 hover:!bg-gray-50 hover:!text-indigo-700 dark:!text-gray-300 dark:hover:!bg-gray-800 dark:hover:!text-indigo-300">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="w-4 h-4 mr-2  inline -mt-1">
                            <path d="M16 4h2v16H4V6h2M15 3H9v20"></path>
                        </svg>{{ __('API Tokens') }}
                    </x-laravel-admin::admin.dropdown-link>
                    @endif

                    <div class="border-t border-gray-200 dark:border-gray-700"></div>

                    <!-- Authentication -->
                    @if ($logoutRoute)
                    <form method="POST" action="{{ route($logoutRoute) }}" x-data>
                        @csrf
                        <x-laravel-admin::admin.dropdown-link href="{{ route($logoutRoute) }}" class="!text-red-600 hover:!bg-red-50 hover:!text-red-700 dark:!text-red-400 dark:hover:!bg-red-950/40 dark:hover:!text-red-300" @click.prevent="$root.submit();">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="w-4 h-4 mr-2 inline -mt-1">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                <polyline points="16,17 21,12 16,7"></polyline>
                                <line x1="21" y1="12" x2="9" y2="12"></line>
                            </svg>
                            {{ __('Log Out') }}
                        </x-laravel-admin::admin.dropdown-link>
                    </form>
                    @endif


                </x-slot>
            </x-laravel-admin::admin.dropdown>
        </div>
    </div>
</header>
