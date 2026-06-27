<?php

namespace Ssh521\LaravelAdminUi\Contracts;

interface ThemeContract
{
    /**
     * @param  array<string, mixed>  $context
     */
    public function classes(string $key, array $context = []): string;
}
