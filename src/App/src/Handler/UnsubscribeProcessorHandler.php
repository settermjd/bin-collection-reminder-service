<?php

declare(strict_types=1);

namespace App\Handler;

use App\Entity\User;
use App\InputFilter\UnsubscribeUserInputFilter;
use Doctrine\ORM\EntityManager;
use Laminas\Diactoros\Response\RedirectResponse;
use Mezzio\Helper\UrlHelper;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class UnsubscribeProcessorHandler implements MiddlewareInterface
{
    use ProcessorHandlerTrait;

    public function __construct(
        private readonly UrlHelper $helper,
        private readonly EntityManager $entityManager
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $routeName = 'unsubscribe.confirmation';

        $inputFilter = new UnsubscribeUserInputFilter();
        $inputFilter->setData($request->getParsedBody());
        if ($inputFilter->isValid()) {
            $user = $this->entityManager
                ->getRepository(User::class)
                ->findOneBy(
                    [
                        'email' => $inputFilter->getValue('email'),
                    ]
                );
            $this->entityManager->remove($user);
            $this->entityManager->flush();
        } else {
            $routeName = 'unsubscribe.form';
            $this->setFlashMessage($request, $inputFilter);
        }

        return new RedirectResponse(
            $this->helper->generate($routeName)
        );
    }
}
