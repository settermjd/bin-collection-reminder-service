<?php

declare(strict_types=1);

namespace App\Handler;

use Laminas\OpenStreetMap\OpenStreetMap;
use Mezzio\Helper\UrlHelper;
use Psr\Container\ContainerInterface;

class SubscribeProcessorHandlerFactory
{
    public function __invoke(ContainerInterface $container) : SubscribeProcessorHandler
    {
        return new SubscribeProcessorHandler(
            $container->get(UrlHelper::class),
            $container->get(OpenStreetMap::class),
        );
    }
}
