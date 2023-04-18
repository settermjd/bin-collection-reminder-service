<?php

declare(strict_types=1);

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

use App\Command\NotifyEmailSubscribersCommand;
use App\Command\NotifyMobileSubscribersCommand;
use App\Repository\UserRepository;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Application;
use Twilio\Rest\Client;

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

(function () {
    /** @var ContainerInterface $container */
    $container = require 'config/container.php';

    $application = new Application();
    $application->setName('Bin Collection Notifier');
    $application->setVersion('1.0.0');
    $application->setAutoExit(false);

    $application->addCommands([
        $container->get(NotifyMobileSubscribersCommand::class),
        $container->get(NotifyEmailSubscribersCommand::class),
    ]);

    $application->run();
})();