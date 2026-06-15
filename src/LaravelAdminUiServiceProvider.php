<?php

namespace Ssh521\LaravelAdminUi;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class LaravelAdminUiServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerViewLocations();
        $this->registerPublishes();
    }

    private function registerViewLocations(): void
    {
        $publishedViewsPath = resource_path('views/vendor/laravel-admin');
        $packageViewsPath = __DIR__.'/../resources/views';

        View::addNamespace('laravel-admin', [$publishedViewsPath, $packageViewsPath]);

        Blade::anonymousComponentPath($publishedViewsPath.'/components', 'laravel-admin');
        Blade::anonymousComponentPath($packageViewsPath.'/components', 'laravel-admin');
    }

    private function registerPublishes(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/laravel-admin'),
        ], 'laravel-admin-ui-views');

        $this->publishes([
            __DIR__.'/../resources/views/components' => resource_path('views/vendor/laravel-admin/components'),
        ], 'laravel-admin-ui-components');

        $this->publishes([
            __DIR__.'/../resources/css/admin.css' => resource_path('vendor/laravel-admin/admin.css'),
            __DIR__.'/../resources/js' => resource_path('vendor/laravel-admin'),
            __DIR__.'/../public/images/dtree' => public_path('images/dtree'),
        ], 'laravel-admin-ui-assets');

    }
}
