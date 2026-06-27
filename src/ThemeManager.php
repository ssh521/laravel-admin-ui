<?php

namespace Ssh521\LaravelAdminUi;

use Illuminate\Contracts\Container\Container;
use InvalidArgumentException;
use Ssh521\LaravelAdminUi\Contracts\ThemeContract;

class ThemeManager
{
    public function __construct(private readonly Container $container) {}

    public function current(): ThemeContract
    {
        $theme = config('laravel-admin-ui.theme', 'tailwind');
        $themes = config('laravel-admin-ui.themes', []);
        $themeName = is_string($theme) ? $theme : 'tailwind';
        $themeClass = isset($themes[$themeName]) ? $themes[$themeName] : $themeName;

        if (! is_string($themeClass) || ! class_exists($themeClass)) {
            throw new InvalidArgumentException("Laravel Admin UI theme [{$themeName}] is not registered.");
        }

        $instance = $this->container->make($themeClass);

        if (! $instance instanceof ThemeContract) {
            throw new InvalidArgumentException("Laravel Admin UI theme [{$themeClass}] must implement ".ThemeContract::class.'.');
        }

        return $instance;
    }

    /**
     * @param  array<string, mixed>  $context
     */
    public function classes(string $key, array $context = []): string
    {
        return $this->current()->classes($key, $context);
    }
}
