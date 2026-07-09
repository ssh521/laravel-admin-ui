@props(['title' => 'Page Title'])

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ? $title . ' - ' : '' }}{{ config('app.name', 'Laravel') }}</title>

    <!-- Dark mode FOUC prevention -->
    <script>
        (function() {
            const applyTheme = () => {
                let theme = null;

                try {
                    theme = window.localStorage?.getItem('theme') || null;
                } catch (error) {
                }

                const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                const isDark = theme === 'dark' || theme === 'system' && prefersDark;

                document.documentElement.classList.toggle('dark', isDark);
            };

            applyTheme();
            window.matchMedia?.('(prefers-color-scheme: dark)').addEventListener('change', applyTheme);
            document.addEventListener('livewire:navigated', applyTheme);
        })();
    </script>

    <!-- Fonts -->
    <!-- <link rel="preconnect" href="https://fonts.bunny.net"> -->
    <!-- <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" /> -->

    <!-- Scripts -->
    @include('laravel-admin::partials.assets')

    <!-- Styles -->
    @livewireStyles
</head>
<body class="h-full min-h-screen bg-white font-sans antialiased md:bg-[#E7E7D6] dark:bg-gray-950">
    <x-laravel-admin::admin.banner />

    <div x-data="{
            isMobileMenuOpen: false,
            isDesktop: false,
            sidebarWidth: 256,
            sidebarMinWidth: 160,
            sidebarMaxWidth: 420,
            isResizingSidebar: false,
            keydownHandler: null,
            sidebarResizeMoveHandler: null,
            sidebarResizeEndHandler: null,
            init() {
                try {
                    this.isDesktop = window.localStorage?.getItem('adminSidebarOpen') === 'true';
                    this.sidebarWidth = this.clampSidebarWidth(parseInt(window.localStorage?.getItem('adminSidebarWidth') || this.sidebarWidth, 10));
                } catch (error) {
                    this.isDesktop = false;
                }

                this.$watch('isDesktop', value => {
                    try {
                        window.localStorage?.setItem('adminSidebarOpen', value);
                    } catch (error) {
                    }
                });

                this.keydownHandler = event => {
                    if ((event.ctrlKey || event.metaKey) && event.key.toLowerCase() === 'b') {
                        event.preventDefault();
                        this.isDesktop = !this.isDesktop;
                    }

                    if (event.key === 'Escape' && this.isMobileMenuOpen) {
                        this.isMobileMenuOpen = false;
                    }
                };

                document.addEventListener('keydown', this.keydownHandler);
            },
            destroy() {
                if (this.keydownHandler) {
                    document.removeEventListener('keydown', this.keydownHandler);
                }

                this.stopSidebarResize(false);
            },
            clampSidebarWidth(width) {
                const maxWidth = Math.min(this.sidebarMaxWidth, Math.max(this.sidebarMinWidth, window.innerWidth - 360));

                return Math.min(Math.max(width || this.sidebarWidth, this.sidebarMinWidth), maxWidth);
            },
            saveSidebarWidth() {
                try {
                    window.localStorage?.setItem('adminSidebarWidth', this.sidebarWidth);
                } catch (error) {
                }
            },
            resizeSidebarTo(width) {
                this.sidebarWidth = this.clampSidebarWidth(width);
            },
            startSidebarResize(event) {
                if (! this.isDesktop) {
                    return;
                }

                this.isResizingSidebar = true;
                document.body.classList.add('cursor-col-resize', 'select-none');

                this.sidebarResizeMoveHandler = event => {
                    this.resizeSidebarTo(event.clientX);
                };

                this.sidebarResizeEndHandler = () => {
                    this.stopSidebarResize();
                };

                document.addEventListener('pointermove', this.sidebarResizeMoveHandler);
                document.addEventListener('pointerup', this.sidebarResizeEndHandler, { once: true });
            },
            stopSidebarResize(shouldSave = true) {
                if (this.sidebarResizeMoveHandler) {
                    document.removeEventListener('pointermove', this.sidebarResizeMoveHandler);
                    this.sidebarResizeMoveHandler = null;
                }

                if (this.sidebarResizeEndHandler) {
                    document.removeEventListener('pointerup', this.sidebarResizeEndHandler);
                    this.sidebarResizeEndHandler = null;
                }

                if (this.isResizingSidebar) {
                    document.body.classList.remove('cursor-col-resize', 'select-none');
                    this.isResizingSidebar = false;
                }

                if (shouldSave) {
                    this.saveSidebarWidth();
                }
            }
        }">

        <livewire:admin.left-menu-mobile />
        <livewire:admin.header-nav />

        <div class="min-h-screen flex pt-16 bg-white md:bg-[#E7E7D6] dark:bg-gray-950">

            <!-- 왼쪽 사이드바 -->
            <div x-show="isDesktop" class="admin-sidebar-surface hidden shrink-0 lg:block lg:min-h-[calc(100dvh-4rem)] shadow-lg border-r border-gray-200 dark:border-gray-700"
                :style="`width: ${sidebarWidth}px;`">
                <!-- 관리자 메뉴 네비게이션 -->
                <nav class="h-full overflow-y-auto">
                    <livewire:admin.left-menu />
                </nav>
            </div>

            <div
                x-show="isDesktop"
                x-on:pointerdown.prevent="startSidebarResize($event)"
                x-on:keydown.arrow-left.prevent="resizeSidebarTo(sidebarWidth - 16); saveSidebarWidth()"
                x-on:keydown.arrow-right.prevent="resizeSidebarTo(sidebarWidth + 16); saveSidebarWidth()"
                class="group relative hidden w-3 shrink-0 cursor-col-resize items-stretch justify-center bg-gray-100/70 transition hover:bg-indigo-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-[-2px] focus-visible:outline-indigo-500 lg:flex lg:min-h-[calc(100dvh-4rem)] dark:bg-gray-800/70 dark:hover:bg-indigo-950/40"
                role="separator"
                aria-orientation="vertical"
                aria-label="{{ __('왼쪽 메뉴 폭 조절') }}"
                tabindex="0"
                title="{{ __('왼쪽 메뉴 폭 조절') }}">
                <div class="h-full w-0.5 bg-gray-300 transition group-hover:w-1 group-hover:bg-indigo-500 dark:bg-gray-600 dark:group-hover:bg-indigo-400"
                    :class="{ 'w-1 bg-indigo-500 dark:bg-indigo-400': isResizingSidebar }"></div>
                <div class="pointer-events-none absolute top-1/2 flex h-9 w-4 -translate-y-1/2 items-center justify-center rounded bg-white/85 shadow-sm ring-1 ring-gray-300 transition group-hover:ring-indigo-400 dark:bg-gray-900/85 dark:ring-gray-600 dark:group-hover:ring-indigo-400">
                    <span class="h-5 w-0.5 rounded-full bg-gray-400 dark:bg-gray-500"></span>
                    <span class="ml-0.5 h-5 w-0.5 rounded-full bg-gray-400 dark:bg-gray-500"></span>
                </div>
            </div>

            <!-- 메인 콘텐츠 영역 -->
            <div class="min-w-0 flex-1 flex flex-col md:mt-2 mx-0 md:mx-4 lg:mx-6">

                <!-- Page Heading -->
                @if (isset($header))
                <header class="hidden md:block px-2 sm:px-0">
                    <div class="mb-3">
                        {{ $header }}
                    </div>
                    <hr class="border-[#663601] dark:border-gray-700 mb-4">
                </header>
                @else
                @endif


                <!-- Page Content -->
                <main class="mb-2 border-[0px] border-gray-200 bg-white p-[0px] md:bg-transparent dark:border-gray-700 dark:bg-gray-950 dark:md:bg-transparent">
                    <div id="page-content" class="border-[0px] border-gray-200 bg-white md:bg-transparent dark:border-gray-700 dark:bg-gray-950 dark:md:bg-transparent">
                        {{ $slot }}
                    </div>
                </main>

            </div>
        </div>
    </div>

    <x-laravel-admin::admin.client-notification />

    @if (class_exists(\Ssh521\LaravelBroadcastNotification\LaravelBroadcastNotificationServiceProvider::class)
        && view()->exists('laravel-broadcast-notification::components.public.toast'))
        @include('laravel-broadcast-notification::components.public.toast')

        @php
            $broadcastNotificationAsset = public_path('vendor/laravel-broadcast-notification/js/listener.js');
            $broadcastNotificationProvider = new \ReflectionClass(\Ssh521\LaravelBroadcastNotification\LaravelBroadcastNotificationServiceProvider::class);
            $broadcastNotificationSource = dirname($broadcastNotificationProvider->getFileName(), 2).'/resources/js/listener.js';
        @endphp

        @if (file_exists($broadcastNotificationAsset))
            <script src="{{ asset('vendor/laravel-broadcast-notification/js/listener.js') }}"></script>
        @elseif (file_exists($broadcastNotificationSource))
            <script>
                {!! file_get_contents($broadcastNotificationSource) !!}
            </script>
        @endif
    @endif

    @livewireScripts
</body>
</html>
