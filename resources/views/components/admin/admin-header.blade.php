<div class="grid grid-cols-[1fr_auto_1fr] items-end">
    @php
        $adminIndexRoute = config('laravel-admin.route_name_prefix', 'admin.').'index';
        $adminPrefix = trim(config('laravel-admin.route_prefix', 'admin'), '/');
        $adminHomeUrl = Route::has($adminIndexRoute) ? route($adminIndexRoute) : url($adminPrefix);
    @endphp

    <div class="flex items-end">
        <h2 class="text-sm leading-tight">
            {{ $navigation }}
        </h2>
    </div>
    <div class="flex items-center justify-center">
        <a href="{{ $adminHomeUrl }}"><x-laravel-admin::admin.site-logo size="w-16 h-16" class="dark:text-purple-200" /></a>
    </div>
    <div class="flex items-end justify-end">
        <h2 class="text-sm leading-tight">
            {{ $description }}
        </h2>
    </div>
</div>
