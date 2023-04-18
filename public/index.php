<?php

declare(strict_types=1);

// Delegate static file requests back to the PHP built-in webserver
use Mezzio\Application;
use Psr\Container\ContainerInterface;

if (PHP_SAPI === 'cli-server' && $_SERVER['SCRIPT_FILENAME'] !== __FILE__) {
    return false;
}

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

/**
 * Load the project's environment variables
 */
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
$dotenv->required([
    'SENDGRID_API_KEY',
    'SEND_FROM_EMAIL_ADDRESS',
    'TWILIO_ACCOUNT_SID',
    'TWILIO_AUTH_TOKEN',
    'TWILIO_PHONE_NUMBER',
]);

/**
 * Self-called anonymous function that creates its own scope and keeps the global namespace clean.
 */
(function () {
    /** @var ContainerInterface $container */
    $container = require 'config/container.php';

    /** @var Application $app */
    $app = $container->get(Application::class);
    $factory = $container->get(\Mezzio\MiddlewareFactory::class);

    // Execute programmatic/declarative middleware pipeline and routing
    // configuration statements
    (require 'config/pipeline.php')($app, $factory, $container);
    (require 'config/routes.php')($app, $factory, $container);

    $app->run();
})();
