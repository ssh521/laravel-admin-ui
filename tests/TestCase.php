<?php

namespace Ssh521\LaravelAdminUi\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Ssh521\LaravelAdminUi\LaravelAdminUiServiceProvider;

abstract class TestCase extends Orchestra
{
    /**
     * @param  mixed  $app
     * @return array<int, class-string>
     */
    protected function getPackageProviders($app): array
    {
        return [
            LaravelAdminUiServiceProvider::class,
        ];
    }
}
