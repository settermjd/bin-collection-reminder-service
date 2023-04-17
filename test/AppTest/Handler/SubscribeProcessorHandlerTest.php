<?php

declare(strict_types=1);

namespace AppTest\Handler;

use App\Handler\SubscribeProcessorHandler;
use Doctrine\ORM\EntityManager;
use Laminas\Diactoros\Response\RedirectResponse;
use Laminas\OpenStreetMap\OpenStreetMap;
use Mezzio\Helper\UrlHelper;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class SubscribeProcessorHandlerTest extends TestCase
{
    public function testCanProcessAValidRequestSuccessfully()
    {
        // phpcs:disable Generic.Files.LineLength
        $searchResult = <<<EOF
{
    "address": {
        "bakery": "B\u00e4cker Kamps",
        "city_district": "Mitte",
        "continent": "European Union",
        "country": "Deutschland",
        "country_code": "de",
        "footway": "Bahnsteig U6",
        "neighbourhood": "Sprengelkiez",
        "postcode": "13353",
        "state": "Berlin",
        "suburb": "Wedding"
    },
    "boundingbox": [
        "52.5460929870605",
        "52.5460968017578",
        "13.3591794967651",
        "13.3591804504395"
    ],
    "class": "shop",
    "display_name": "B\u00e4cker Kamps, Bahnsteig U6, Sprengelkiez, Wedding, Mitte, Berlin, 13353, Deutschland, European Union",
    "icon": "https://nominatim.openstreetmap.org/images/mapicons/shopping_bakery.p.20.png",
    "importance": 0.201,
    "lat": "52.5460941",
    "licence": "Data \u00a9 OpenStreetMap contributors, ODbL 1.0. https://www.openstreetmap.org/copyright",
    "lon": "13.35918",
    "osm_id": "317179427",
    "osm_type": "node",
    "place_id": "1453068",
    "type": "bakery"
}
EOF;
        // phpcs:enable

        $searchQuery   = '135 pilkington avenue, birmingham';
        $openStreetMap = $this->createMock(OpenStreetMap::class);
        $openStreetMap
            ->expects($this->once())
            ->method('search')
            ->with($searchQuery)
            ->willReturn($searchResult);
        $handler = new SubscribeProcessorHandler(
            $this->createMock(UrlHelper::class),
            $openStreetMap,
            $this->createMock(EntityManager::class),
        );

        $request = $this->createMock(ServerRequestInterface::class);
        $request
            ->expects($this->once())
            ->method('getParsedBody')
            ->willReturn([
                'address'  => $searchQuery,
                'mobile'   => '',
                'email'    => '',
                'fullName' => '',
            ]);

        $response = $handler->process(
            $request,
            $this->createMock(RequestHandlerInterface::class),
        );

        $this->assertInstanceOf(RedirectResponse::class, $response);
    }
}
