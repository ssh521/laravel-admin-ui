<?php

namespace Ssh521\LaravelAdminUi;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Ssh521\LaravelAdminUi\Contracts\StyleClassResolver;
use Ssh521\LaravelAdminUi\Styles\YaverstyleClassResolver;
use Ssh521\LaravelAdminUi\Support\AdminRequestContext;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class LaravelAdminUiServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-admin-ui.php', 'laravel-admin-ui');

        $this->app->singleton(StyleClassResolver::class, YaverstyleClassResolver::class);
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

                $status = match (true) {
                    $e instanceof TokenMismatchException => 419,
                    $e instanceof HttpExceptionInterface => $e->getStatusCode(),
                    default => null,
                };

                if (! in_array($status, [403, 419], true)) {
                    return null;
                }

                if (file_exists(resource_path("views/errors/{$status}.blade.php"))) {
                    return null;
                }

                $viewData = $status === 419
                    ? $this->sessionExpiredViewData($request)
                    : [];

                return response()->view(
                    "laravel-admin::errors.{$status}",
                    $viewData,
                    $status,
                    $e instanceof HttpExceptionInterface ? $e->getHeaders() : []
                );
            });
        });
    }

    /**
     * @return array{isAdminSession: bool, loginRoute: string|null}
     */
    private function sessionExpiredViewData(Request $request): array
    {
        $isAdminSession = AdminRequestContext::isAdmin($request);

        return [
            'isAdminSession' => $isAdminSession,
            'loginRoute' => AdminRequestContext::loginRoute($request),
        ];
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

        $maintenanceView = [
            __DIR__.'/../resources/views/errors/503.blade.php' => resource_path('views/errors/503.blade.php'),
        ];

        $this->publishes([
            __DIR__.'/../config/laravel-admin-ui.php' => config_path('laravel-admin-ui.php'),
        ], 'laravel-admin-ui-config');

        $this->publishes($views, 'laravel-admin-ui-views');
        $this->publishes($components, 'laravel-admin-ui-components');
        $this->publishes($assets, 'laravel-admin-ui-assets');
        $this->publishes($maintenanceView, 'laravel-admin-ui-maintenance-view');
    }
}
