<?php

declare(strict_types=1);

namespace App\Handler;

use App\Entity\User;
use App\InputFilter\SubscribeUserInputFilter;
use Doctrine\ORM\EntityManager;
use Laminas\Diactoros\Response\RedirectResponse;
use Laminas\OpenStreetMap\Format\ResponseFormat;
use Laminas\OpenStreetMap\OpenStreetMap;
use Laminas\OpenStreetMap\Result\Search\SearchOptions;
use Mezzio\Helper\UrlHelper;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

use function strtolower;

class SubscribeProcessorHandler implements MiddlewareInterface
{
    use ProcessorHandlerTrait;

    public function __construct(
        private readonly UrlHelper $helper,
        private readonly OpenStreetMap $openStreetMap,
        private readonly EntityManager $entityManager,
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $requestData = $request->getParsedBody();
        $routeName   = 'home';

        $inputFilter = new SubscribeUserInputFilter();
        $inputFilter->setData($requestData);
        if ($inputFilter->isValid()) {
            $searchResult = $this->openStreetMap
                ->search(
                    $requestData['address'],
                    ResponseFormat::JSON,
                    limit: 1,
                    searchOptions: new SearchOptions(
                        showAddressDetails: true,
                        deDupeResults: true
                    ),
                );

            $user = new User(
                suburb: strtolower($searchResult[0]->getAddress()->getSuburb()),
                email: $requestData['email'] ?? null,
                mobile: $requestData['mobile'] ?? null,
                fullName: $requestData['fullName'] ?? null,
            );

            $this->entityManager->persist($user);
            $this->entityManager->flush();
        } else {
            $this->setFlashMessage($request, $inputFilter);
        }

        return new RedirectResponse($this->helper->generate($routeName));
    }
}
