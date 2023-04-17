<?php

declare(strict_types=1);

namespace App\Handler;

use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

use function assert;

class SubscribeConfirmationHandlerFactory
{
    public function __invoke(ContainerInterface $container): SubscribeConfirmationHandler
    {
        $template = $container->get(TemplateRendererInterface::class);
        assert($template instanceof TemplateRendererInterface);

        return new SubscribeConfirmationHandler($template);
    }
}
