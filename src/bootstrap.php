<?php
declare(strict_types=1);

// Config
$config = new ArrayObject(require(__DIR__ . '/../config.php'));

// Build DI container
$container = \PurpleHexagon\Factories\ContainerFactory::make($config);

if (php_sapi_name() == "cli") {
    $console = $container->get(\PurpleHexagon\Services\Console::class);
    // Handle CLI
    $console->run();
} else {
    $http = $container->get(\PurpleHexagon\Services\Http::class);
    // Handle HTTP
    $http->serve();
}
