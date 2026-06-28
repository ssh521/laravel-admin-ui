<?php

namespace Ssh521\LaravelAdminUi\Contracts;

interface StyleClassResolver
{
    /**
     * @param  array<string, mixed>  $context
     */
    public function classes(string $key, array $context = []): string;
}
