<?php

namespace Ssh521\LaravelAdminUi;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Ssh521\LaravelAdminUi\Contracts\ThemeContract;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class LaravelAdminUiServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-admin-ui.php', 'laravel-admin-ui');

        $this->app->singleton(ThemeManager::class);
        $this->app->bind(ThemeContract::class, fn ($app) => $app->make(ThemeManager::class)->current());
    }

    public function boot(): void
    {
        $this->registerViewLocations();
        $this->registerErrorRenderer();
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

    private function registerErrorRenderer(): void
    {
        $this->app->afterResolving(ExceptionHandler::class, function ($handler) {
            if (! method_exists($handler, 'renderable')) {
                return;
            }

            $handler->renderable(function (Throwable $e, $request) {
                if ($request->expectsJson()) {
                    return null;
                }

                if (! $e instanceof HttpExceptionInterface || $e->getStatusCode() !== 403) {
                    return null;
                }

                if (file_exists(resource_path('views/errors/403.blade.php'))) {
                    return null;
                }

                return response()->view(
                    'laravel-admin::errors.403',
                    [],
                    403,
                    $e->getHeaders()
                );
            });
        });
    }

    private function registerPublishes(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $views = [
            __DIR__.'/../resources/views' => resource_path('views/vendor/laravel-admin'),
        ];

        $components = [
            __DIR__.'/../resources/views/components' => resource_path('views/vendor/laravel-admin/components'),
        ];

        $assets = [
            __DIR__.'/../resources/css/admin.css' => resource_path('vendor/laravel-admin/admin.css'),
            __DIR__.'/../resources/js' => resource_path('vendor/laravel-admin'),
            __DIR__.'/../public/images/dtree' => public_path('images/dtree'),
        ];

        $this->publishes([
            __DIR__.'/../config/laravel-admin-ui.php' => config_path('laravel-admin-ui.php'),
        ], 'laravel-admin-ui-config');

        $this->publishes($views, 'laravel-admin-ui-views');
        $this->publishes($components, 'laravel-admin-ui-components');
        $this->publishes($assets, 'laravel-admin-ui-assets');
    }
}
