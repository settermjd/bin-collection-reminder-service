<?php

declare(strict_types=1);

namespace App\Command;

use App\Repository\UserRepository;
use Psr\Container\ContainerInterface;
use SendGrid;

class NotifyEmailSubscribersCommandFactory
{
    public function __invoke(ContainerInterface $container): NotifyEmailSubscribersCommand
    {
        return new NotifyEmailSubscribersCommand(
            $container->get(UserRepository::class),
            $container->get(SendGrid::class),
        );
    }
}
