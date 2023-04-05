<?php

declare(strict_types=1);

namespace App\Handler;

use Laminas\Diactoros\Response\RedirectResponse;
use Mezzio\Helper\UrlHelper;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class SubscribeProcessorHandler implements MiddlewareInterface
{
    private UrlHelper $helper;

    public function __construct(UrlHelper $helper)
    {
        $this->helper = $helper;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        return new RedirectResponse(
            $this->helper->generate('subscribe.confirmation')
        );
    }
}
