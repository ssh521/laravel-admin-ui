<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    <title>{{ __('세션이 만료되었습니다') }} - {{ config('app.name', 'Laravel') }}</title>

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
        })();
    </script>

    @include('laravel-admin::partials.assets')
</head>
<body class="h-full bg-[#E7E7D6] font-sans antialiased text-gray-950 dark:bg-gray-950 dark:text-white">
    @php
        $adminLoginRoute = config('laravel-admin.route_name_prefix', 'admin.').'login';
        $loginRoute = \Illuminate\Support\Facades\Route::has($adminLoginRoute)
            ? $adminLoginRoute
            : (\Illuminate\Support\Facades\Route::has('login') ? 'login' : null);
    @endphp

    <main class="flex min-h-full items-center justify-center px-4 py-10 sm:px-6 lg:px-8">
        <section class="w-full max-w-2xl overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800 sm:px-8">
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-indigo-700 ring-1 ring-indigo-200 dark:bg-indigo-500/10 dark:text-indigo-300 dark:ring-indigo-500/25">
                        <x-laravel-admin::admin.icon name="key" class="text-lg" />
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-indigo-700 dark:text-indigo-300">419 Page Expired</p>
                        <h1 class="mt-1 text-2xl font-bold tracking-normal text-gray-950 dark:text-white">
                            {{ __('세션이 만료되었습니다.') }}
                        </h1>
                    </div>
                </div>
            </div>

            <div class="px-6 py-6 sm:px-8">
                <p class="text-base leading-7 text-gray-700 dark:text-gray-300">
                    {{ __('오랫동안 사용하지 않았거나 보안 토큰이 갱신되어 요청을 처리할 수 없습니다. 다시 로그인한 뒤 작업을 계속해 주세요.') }}
                </p>

                <dl class="mt-6 grid grid-cols-1 gap-3 text-sm sm:grid-cols-2">
                    <div class="rounded-md border border-gray-200 bg-gray-50 px-4 py-3 dark:border-gray-800 dark:bg-gray-800/70">
                        <dt class="font-semibold text-gray-900 dark:text-white">{{ __('상태 코드') }}</dt>
                        <dd class="mt-1 text-gray-600 dark:text-gray-400">419</dd>
                    </div>
                    <div class="rounded-md border border-gray-200 bg-gray-50 px-4 py-3 dark:border-gray-800 dark:bg-gray-800/70">
                        <dt class="font-semibold text-gray-900 dark:text-white">{{ __('가능한 원인') }}</dt>
                        <dd class="mt-1 text-gray-600 dark:text-gray-400">{{ __('세션 만료 또는 CSRF 토큰 만료') }}</dd>
                    </div>
                </dl>

                <div class="mt-8 flex flex-col gap-3 border-t border-gray-200 pt-6 dark:border-gray-800 sm:flex-row sm:justify-end">
                    <a href="{{ url()->current() }}" class="inline-flex h-10 items-center justify-center rounded-md border border-gray-300 bg-white px-4 text-sm font-semibold !text-gray-700 shadow-sm hover:bg-gray-50 hover:no-underline focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:border-gray-600 dark:bg-gray-800 dark:!text-gray-100 dark:hover:bg-gray-700">
                        <x-laravel-admin::admin.icon name="arrow-left" class="mr-2 text-xs" />
                        {{ __('다시 시도') }}
                    </a>
                    @if ($loginRoute)
                        <a href="{{ route($loginRoute) }}" class="inline-flex h-10 items-center justify-center rounded-md bg-indigo-600 px-4 text-sm font-semibold !text-white shadow-sm hover:bg-indigo-500 hover:no-underline focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:bg-indigo-500 dark:hover:bg-indigo-400">
                            <x-laravel-admin::admin.icon name="right-to-bracket" class="mr-2 text-xs" />
                            {{ __('로그인 화면으로 이동') }}
                        </a>
                    @else
                        <a href="{{ url('/') }}" class="inline-flex h-10 items-center justify-center rounded-md bg-indigo-600 px-4 text-sm font-semibold !text-white shadow-sm hover:bg-indigo-500 hover:no-underline focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:bg-indigo-500 dark:hover:bg-indigo-400">
                            <x-laravel-admin::admin.icon name="house" class="mr-2 text-xs" />
                            {{ __('홈으로 이동') }}
                        </a>
                    @endif
                </div>
            </div>
        </section>
    </main>
</body>
</html>
