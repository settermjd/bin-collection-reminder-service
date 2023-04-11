<?php

declare(strict_types=1);

namespace App\Handler;

use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Flash\FlashMessageMiddleware;
use Mezzio\Flash\FlashMessagesInterface;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class UnsubscribeFormHandler implements MiddlewareInterface
{
    public function __construct(private ?TemplateRendererInterface $template = null) {}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        $data = [];

        /** @var FlashMessagesInterface $flashMessages */
        $flashMessages = $request->getAttribute(FlashMessageMiddleware::FLASH_ATTRIBUTE);
        if (! is_null($flashMessages)) {
            $messages = $flashMessages->getFlashes();
            if (array_key_exists('errors', $messages)) {
                $data['errors'] = $messages['errors'];
            }
        }

        return new HtmlResponse($this->template->render('app::unsubscribe-form', $data));
    }
}
