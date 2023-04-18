<?php

declare(strict_types=1);

namespace App;

use App\Command\NotifyEmailSubscribersCommand;
use App\Command\NotifyEmailSubscribersCommandFactory;
use App\Command\NotifyMobileSubscribersCommand;
use App\Command\NotifyMobileSubscribersCommandFactory;
use App\Factory\SendGridFactory;
use App\Factory\TwilioRestClientFactory;
use App\Repository\UserRepository;
use App\Repository\UserRepositoryFactory;
use SendGrid;
use Twilio\Rest\Client;

/**
 * The configuration provider for the App module
 *
 * @see https://docs.laminas.dev/laminas-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies(): array
    {
        return [
            'invokables' => [
                Handler\PingHandler::class => Handler\PingHandler::class,
            ],
            'factories'  => [
                Client::class                                 => TwilioRestClientFactory::class,
                Handler\SubscribeConfirmationHandler::class   => Handler\SubscribeConfirmationHandlerFactory::class,
                Handler\SubscribeFormHandler::class           => Handler\SubscribeFormHandlerFactory::class,
                Handler\SubscribeProcessorHandler::class      => Handler\SubscribeProcessorHandlerFactory::class,
                Handler\UnsubscribeConfirmationHandler::class => Handler\UnsubscribeConfirmationHandlerFactory::class,
                Handler\UnsubscribeFormHandler::class         => Handler\UnsubscribeFormHandlerFactory::class,
                Handler\UnsubscribeProcessorHandler::class    => Handler\UnsubscribeProcessorHandlerFactory::class,
                NotifyEmailSubscribersCommand::class          => NotifyEmailSubscribersCommandFactory::class,
                NotifyMobileSubscribersCommand::class         => NotifyMobileSubscribersCommandFactory::class,
                SendGrid::class                               => SendGridFactory::class,
                UserRepository::class                         => UserRepositoryFactory::class,
            ],
        ];
    }

    /**
     * Returns the templates configuration
     */
    public function getTemplates(): array
    {
        return [
            'paths' => [
                'app'          => [__DIR__ . '/../templates/app'],
                'error'        => [__DIR__ . '/../templates/error'],
                'layout'       => [__DIR__ . '/../templates/layout'],
                'static-pages' => [__DIR__ . '/../templates/static-pages'],
            ],
        ];
    }
}
