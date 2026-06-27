<?php

use Ssh521\LaravelAdminUi\Themes\TailwindTheme;

return [
    'theme' => env('LARAVEL_ADMIN_UI_THEME', 'tailwind'),

    'themes' => [
        'tailwind' => TailwindTheme::class,
    ],
];
