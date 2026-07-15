<?php

namespace Ssh521\LaravelAdminUi\Support;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

final class AdminRequestContext
{
    public const ATTRIBUTE = 'laravel-admin.is-admin-request';

    public static function mark(Request $request, bool $isAdminRequest): void
    {
        $request->attributes->set(self::ATTRIBUTE, $isAdminRequest);
    }

    public static function isAdmin(Request $request): bool
    {
        $marked = $request->attributes->get(self::ATTRIBUTE);

        if (is_bool($marked)) {
            return $marked;
        }

        $routeNamePrefix = (string) config('laravel-admin.route_name_prefix', 'admin.');

        if ($routeNamePrefix !== '' && $request->routeIs($routeNamePrefix.'*')) {
            return true;
        }

        if (self::isAdminPath('/'.$request->path())) {
            return true;
        }

        if (! $request->hasHeader('X-Livewire')) {
            return false;
        }

        $referer = $request->headers->get('referer');

        if (! is_string($referer) || parse_url($referer, PHP_URL_HOST) !== $request->getHost()) {
            return false;
        }

        $refererPath = parse_url($referer, PHP_URL_PATH);

        return is_string($refererPath) && self::isAdminPath($refererPath);
    }

    public static function loginRoute(Request $request): ?string
    {
        $adminLoginRoute = config('laravel-admin.route_name_prefix', 'admin.').'login';
        $preferredRoutes = self::isAdmin($request)
            ? [$adminLoginRoute, 'login']
            : ['login', $adminLoginRoute];

        foreach ($preferredRoutes as $route) {
            if (Route::has($route)) {
                return $route;
            }
        }

        return null;
    }

    private static function isAdminPath(string $path): bool
    {
        $path = trim($path, '/');
        $adminPrefix = trim((string) config('laravel-admin.route_prefix', 'admin'), '/');

        return $adminPrefix !== ''
            && ($path === $adminPrefix || str_starts_with($path, $adminPrefix.'/'));
    }
}
