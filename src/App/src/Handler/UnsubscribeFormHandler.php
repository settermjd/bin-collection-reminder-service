<?php

declare(strict_types=1);

namespace App\Handler;

use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class UnsubscribeFormHandler implements MiddlewareInterface
{
    use FormHandlerTrait;

    public function __construct(private readonly TemplateRendererInterface $template)
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $data = $this->setDataFromFlashMessages($request);

        return new HtmlResponse($this->template->render('app::unsubscribe-form', $data));
    }
}
