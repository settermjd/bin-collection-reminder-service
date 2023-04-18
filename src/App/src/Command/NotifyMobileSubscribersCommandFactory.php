<?php

declare(strict_types=1);

namespace App\Command;

use App\Repository\UserRepository;
use Psr\Container\ContainerInterface;
use Twilio\Rest\Client;

class NotifyMobileSubscribersCommandFactory
{
    public function __invoke(ContainerInterface $container): NotifyMobileSubscribersCommand
    {
        return new NotifyMobileSubscribersCommand(
            $container->get(UserRepository::class),
            $container->get(Client::class),
        );
    }
}
