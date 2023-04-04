<?php

declare(strict_types=1);

namespace AppTest\Handler;

use App\Handler\SubscribeFormHandler;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;

class SubscribeFormHandlerTest extends TestCase
{
    /** @var ContainerInterface&MockObject */
    protected $container;

    protected function setUp(): void
    {
        $this->container = $this->createMock(ContainerInterface::class);
    }

    public function testReturnsJsonResponseWhenNoTemplateRendererProvided(): void
    {
        $homePage = new SubscribeFormHandler(null);
        $response = $homePage->handle(
            $this->createMock(ServerRequestInterface::class)
        );

        self::assertInstanceOf(JsonResponse::class, $response);
    }

    public function testReturnsHtmlResponseWhenTemplateRendererProvided(): void
    {
        $renderer = $this->createMock(TemplateRendererInterface::class);
        $renderer
            ->expects($this->once())
            ->method('render')
            ->with('app::home-page', $this->isType('array'))
            ->willReturn('');

        $homePage = new SubscribeFormHandler($renderer);

        $response = $homePage->handle(
            $this->createMock(ServerRequestInterface::class)
        );

        self::assertInstanceOf(HtmlResponse::class, $response);
    }
}
