<?php

use Composer\Autoload\ClassLoader;

$autoloaders = [
    __DIR__.'/../vendor/autoload.php',
    __DIR__.'/../../../../adminTest/vendor/autoload.php',
];

foreach ($autoloaders as $autoload) {
    if (file_exists($autoload)) {
        $loader = require $autoload;

        if ($loader instanceof ClassLoader) {
            $loader->addPsr4('Ssh521\\LaravelAdminUi\\Tests\\', __DIR__);
        }

        return;
    }
}

throw new RuntimeException('Composer autoload file was not found. Run composer install before running tests.');
