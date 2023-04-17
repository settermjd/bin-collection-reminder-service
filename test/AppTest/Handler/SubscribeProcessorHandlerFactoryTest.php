<?php

declare(strict_types=1);

namespace AppTest\Handler;

use App\Handler\SubscribeProcessorHandler;
use App\Handler\SubscribeProcessorHandlerFactory;
use Doctrine\ORM\EntityManager;
use Laminas\OpenStreetMap\OpenStreetMap;
use Mezzio\Helper\UrlHelper;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class SubscribeProcessorHandlerFactoryTest extends TestCase
{
    public function testCanInstantiateSubscribeProcessorHandlerCorrectly()
    {
        $container = $this->createMock(ContainerInterface::class);
        $container
            ->expects($this->atMost(3))
            ->method('get')
            ->willReturnOnConsecutiveCalls(
                $this->createMock(UrlHelper::class),
                $this->createMock(OpenStreetMap::class),
                $this->createMock(EntityManager::class),
            );

        $factory = new SubscribeProcessorHandlerFactory();
        $handler = $factory($container);
        $this->assertInstanceOf(SubscribeProcessorHandler::class, $handler);
    }
}
