<?php

declare(strict_types=1);

namespace App\Handler;

use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

use function assert;

class UnsubscribeFormHandlerFactory
{
    public function __invoke(ContainerInterface $container): UnsubscribeFormHandler
    {
        $template = $container->has(TemplateRendererInterface::class)
            ? $container->get(TemplateRendererInterface::class)
            : null;
        assert($template instanceof TemplateRendererInterface || null === $template);

        return new UnsubscribeFormHandler($template);
    }
}
