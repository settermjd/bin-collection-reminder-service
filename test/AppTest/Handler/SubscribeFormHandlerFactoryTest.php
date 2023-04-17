<?php

declare(strict_types=1);

namespace AppTest\Handler;

use App\Handler\SubscribeFormHandler;
use App\Handler\SubscribeFormHandlerFactory;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class SubscribeFormHandlerFactoryTest extends TestCase
{
    /** @var ContainerInterface&MockObject */
    protected $container;

    /** @var RouterInterface&MockObject */
    protected $router;

    protected function setUp(): void
    {
        $this->container = $this->createMock(ContainerInterface::class);
        $this->router    = $this->createMock(RouterInterface::class);
    }

    public function testFactoryWithTemplate(): void
    {
        $renderer = $this->createMock(TemplateRendererInterface::class);
        $this->container
            ->expects($this->once())
            ->method('has')
            ->with(TemplateRendererInterface::class)
            ->willReturn(true);
        $this->container
            ->expects($this->once())
            ->method('get')
            ->with(TemplateRendererInterface::class)
            ->willReturn($renderer);

        $factory  = new SubscribeFormHandlerFactory();
        $homePage = $factory($this->container);

        self::assertInstanceOf(SubscribeFormHandler::class, $homePage);
    }
}
