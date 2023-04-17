<?php

declare(strict_types=1);

namespace App\Handler;

use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class SubscribeFormHandler implements RequestHandlerInterface
{
    use FormHandlerTrait;

    public function __construct(private readonly TemplateRendererInterface $template)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $data = $this->setDataFromFlashMessages($request);

        return new HtmlResponse($this->template->render('app::subscribe-form', $data));
    }
}
