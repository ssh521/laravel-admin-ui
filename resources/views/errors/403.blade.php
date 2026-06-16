<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ __('접근 권한이 없습니다') }} - {{ config('app.name', 'Laravel') }}</title>

    <script>
        (function() {
            const applyTheme = () => {
                let theme = null;

                try {
                    theme = window.localStorage?.getItem('theme') || null;
                } catch (error) {
                }

                const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                const isDark = theme === 'dark' || theme === 'system' && prefersDark || (!theme && prefersDark);

                document.documentElement.classList.toggle('dark', isDark);
            };

            applyTheme();
            window.matchMedia?.('(prefers-color-scheme: dark)').addEventListener('change', applyTheme);
        })();
    </script>

    @include('laravel-admin::partials.assets')
</head>
<body class="h-full bg-[#E7E7D6] font-sans antialiased text-gray-950 dark:bg-gray-950 dark:text-white">
    <main class="flex min-h-full items-center justify-center px-4 py-10 sm:px-6 lg:px-8">
        <section class="w-full max-w-2xl overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800 sm:px-8">
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-md bg-amber-50 text-amber-700 ring-1 ring-amber-200 dark:bg-amber-500/10 dark:text-amber-300 dark:ring-amber-500/25">
                        <i class="fa-solid fa-lock text-lg" aria-hidden="true"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-amber-700 dark:text-amber-300">403 Forbidden</p>
                        <h1 class="mt-1 text-2xl font-bold tracking-normal text-gray-950 dark:text-white">
                            {{ __('접근 권한이 없습니다.') }}
                        </h1>
                    </div>
                </div>
            </div>

            <div class="px-6 py-6 sm:px-8">
                <p class="text-base leading-7 text-gray-700 dark:text-gray-300">
                    {{ __('현재 계정으로는 이 페이지에 접근할 수 없습니다. 필요한 권한이 있는지 확인하거나 관리자에게 권한 부여를 요청해 주세요.') }}
                </p>

                <dl class="mt-6 grid grid-cols-1 gap-3 text-sm sm:grid-cols-2">
                    <div class="rounded-md border border-gray-200 bg-gray-50 px-4 py-3 dark:border-gray-800 dark:bg-gray-800/70">
                        <dt class="font-semibold text-gray-900 dark:text-white">{{ __('상태 코드') }}</dt>
                        <dd class="mt-1 text-gray-600 dark:text-gray-400">403</dd>
                    </div>
                    <div class="rounded-md border border-gray-200 bg-gray-50 px-4 py-3 dark:border-gray-800 dark:bg-gray-800/70">
                        <dt class="font-semibold text-gray-900 dark:text-white">{{ __('가능한 원인') }}</dt>
                        <dd class="mt-1 text-gray-600 dark:text-gray-400">{{ __('역할 또는 권한 부족') }}</dd>
                    </div>
                </dl>

                <div class="mt-8 flex flex-col gap-3 border-t border-gray-200 pt-6 dark:border-gray-800 sm:flex-row sm:justify-end">
                    <a href="{{ url()->previous() }}" class="inline-flex h-10 items-center justify-center rounded-md border border-gray-300 bg-white px-4 text-sm font-semibold !text-gray-700 shadow-sm hover:bg-gray-50 hover:no-underline focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:border-gray-600 dark:bg-gray-800 dark:!text-gray-100 dark:hover:bg-gray-700">
                        <i class="fa-solid fa-arrow-left mr-2 text-xs" aria-hidden="true"></i>
                        {{ __('이전 페이지') }}
                    </a>
                    <a href="{{ url('/') }}" class="inline-flex h-10 items-center justify-center rounded-md bg-indigo-600 px-4 text-sm font-semibold !text-white shadow-sm hover:bg-indigo-500 hover:no-underline focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:bg-indigo-500 dark:hover:bg-indigo-400">
                        <i class="fa-solid fa-house mr-2 text-xs" aria-hidden="true"></i>
                        {{ __('홈으로 이동') }}
                    </a>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
