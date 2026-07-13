<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    <title>{{ __('Admin Login') }} - {{ config('app.name', 'Laravel') }}</title>

    <script>
        (function() {
            const theme = window.localStorage?.getItem('theme') || null;
            const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
            const isDark = theme === 'dark' || theme === 'system' && prefersDark;

            document.documentElement.classList.toggle('dark', isDark);
        })();

        window.addEventListener('pageshow', event => {
            if (event.persisted) {
                window.location.reload();
            }
        });
    </script>

    @include('laravel-admin::partials.assets')
</head>
<body class="min-h-screen bg-white font-sans antialiased text-gray-900 dark:bg-gray-950 dark:text-gray-100">
    @php
        $loginRoute = $loginRoute ?? config('laravel-admin.route_name_prefix', 'admin.').'login';
    @endphp

    <main class="flex min-h-screen min-h-dvh items-center justify-center px-4 py-6 sm:px-6 sm:py-10 lg:px-8">
        <div class="w-full max-w-md">
            <section class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-900">
                <div class="px-6 py-6 sm:px-8 sm:py-8">
                    <div class="mb-8 text-center">
                        <div class="mb-5 flex justify-center">
                            <x-laravel-admin::admin.site-logo size="w-16 h-16" class="dark:text-purple-200" />
                        </div>
                        <h1 class="text-2xl font-semibold leading-7 text-gray-900 dark:text-white">
                            {{ __('관리자 로그인') }}
                        </h1>
                    </div>

                    @if ($errors->any())
                        <div class="mb-5 rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 dark:border-red-500/30 dark:bg-red-500/10 dark:text-red-300">
                            <ul class="space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li class="flex gap-2">
                                        <x-laravel-admin::admin.icon name="circle-exclamation" class="mt-0.5 text-xs" />
                                        <span>{{ $error }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @session('status')
                        <div class="mb-5 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 dark:border-green-500/30 dark:bg-green-500/10 dark:text-green-300">
                            {{ $value }}
                        </div>
                    @endsession

                    <form method="POST" action="{{ route($loginRoute) }}" class="space-y-5">
                        @csrf

                        <div>
                            <label for="email" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">
                                {{ __('Email') }}
                            </label>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                autocomplete="username"
                                class="mt-2 h-10 w-full rounded-md border border-gray-300 bg-white px-3 text-sm text-gray-900 shadow-sm outline-none placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                            >
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">
                                {{ __('Password') }}
                            </label>
                            <input
                                id="password"
                                type="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                class="mt-2 h-10 w-full rounded-md border border-gray-300 bg-white px-3 text-sm text-gray-900 shadow-sm outline-none placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                            >
                        </div>

                        <label for="remember_me" class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                            <input
                                id="remember_me"
                                type="checkbox"
                                name="remember"
                                class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-2 focus:ring-indigo-500/20 dark:border-gray-600 dark:bg-gray-800"
                            >
                            <span>{{ __('Remember me') }}</span>
                        </label>

                        <x-laravel-admin::admin.action-button type="submit" icon="right-to-bracket" class="w-full">
                            {{ __('Log in') }}
                        </x-laravel-admin::admin.action-button>
                    </form>
                </div>
            </section>

            <p class="mt-6 text-center text-xs leading-5 text-gray-500 dark:text-gray-400">
                {{ __('허가된 관리자만 접근할 수 있습니다. 무단 접근 및 사용은 제한됩니다.') }}
            </p>
        </div>
    </main>
</body>
</html>
