<?php

declare(strict_types=1);

namespace App\Handler;

use Doctrine\ORM\EntityManager;
use Mezzio\Helper\UrlHelper;
use Psr\Container\ContainerInterface;

class UnsubscribeProcessorHandlerFactory
{
    public function __invoke(ContainerInterface $container): UnsubscribeProcessorHandler
    {
        return new UnsubscribeProcessorHandler(
            $container->get(UrlHelper::class),
            $container->get(EntityManager::class),
        );
    }
}
