<?php

declare(strict_types=1);

namespace App\Handler;

use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

class UnsubscribeConfirmationHandlerFactory
{
    public function __invoke(ContainerInterface $container) : UnsubscribeConfirmationHandler
    {
        $template = $container->has(TemplateRendererInterface::class)
            ? $container->get(TemplateRendererInterface::class)
            : null;
        assert($template instanceof TemplateRendererInterface || null === $template);

        return new UnsubscribeConfirmationHandler($template);
    }
}
