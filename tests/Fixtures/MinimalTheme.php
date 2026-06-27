<?php

namespace Ssh521\LaravelAdminUi\Tests\Fixtures;

use Ssh521\LaravelAdminUi\Contracts\ThemeContract;

class MinimalTheme implements ThemeContract
{
    /**
     * @param  array<string, mixed>  $context
     */
    public function classes(string $key, array $context = []): string
    {
        return match ($key) {
            'action-button.base' => 'custom-button',
            'action-button.size' => 'custom-size',
            'action-button.variant' => 'custom-primary',
            default => '',
        };
    }
}
