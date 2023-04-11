<?php

declare(strict_types=1);

namespace App\Handler;

use App\InputFilter\SubscribeUserInputFilter;
use App\InputFilter\UnsubscribeUserInputFilter;
use Laminas\Diactoros\Response\RedirectResponse;
use Mezzio\Flash\FlashMessageMiddleware;
use Mezzio\Flash\FlashMessagesInterface;
use Mezzio\Helper\UrlHelper;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class UnsubscribeProcessorHandler implements MiddlewareInterface
{
    private UrlHelper $helper;

    public function __construct(UrlHelper $helper)
    {
        $this->helper = $helper;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        $routeName = 'unsubscribe.confirmation';

        $inputFilter = new UnsubscribeUserInputFilter();
        $inputFilter->setData($request->getParsedBody());

        if (! $inputFilter->isValid()) {
            /** @var FlashMessagesInterface $flashMessages */
            $flashMessages = $request->getAttribute(FlashMessageMiddleware::FLASH_ATTRIBUTE);
            if (! is_null($flashMessages)) {
                $errorList = [];
                $errors = $inputFilter->getMessages();
                array_walk_recursive($errors, function ($item) use (&$errorList)
                    {
                        $errorList[] = $item;
                    },
                    $errorList
                );
                $flashMessages->flash('errors', $errorList);
            }
            $routeName = 'unsubscribe.form';
        }

        return new RedirectResponse(
            $this->helper->generate($routeName)
        );
    }
}
