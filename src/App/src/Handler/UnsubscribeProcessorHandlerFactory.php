<?php

declare(strict_types=1);

namespace App\Handler;

use Psr\Container\ContainerInterface;

class UnsubscribeProcessorHandlerFactory
{
    public function __invoke(ContainerInterface $container) : UnsubscribeProcessorHandler
    {
        return new UnsubscribeProcessorHandler();
    }
}
