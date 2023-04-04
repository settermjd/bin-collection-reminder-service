<?php

declare(strict_types=1);

namespace App\Handler;

use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

class SubscribeConfirmationHandlerFactory
{
    public function __invoke(ContainerInterface $container) : SubscribeConfirmationHandler
    {
        $template = $container->has(TemplateRendererInterface::class)
            ? $container->get(TemplateRendererInterface::class)
            : null;
        assert($template instanceof TemplateRendererInterface || null === $template);

        return new SubscribeConfirmationHandler($template);
    }
}
