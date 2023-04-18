<?php

declare(strict_types=1);

namespace App\Handler;

use App\Error\ErrorsListFlattener;
use Laminas\InputFilter\InputFilterInterface;
use Mezzio\Flash\FlashMessageMiddleware;
use Mezzio\Flash\FlashMessagesInterface;
use Psr\Http\Message\ServerRequestInterface;

use function array_walk;

trait ProcessorHandlerTrait
{
    private function getFlattenedErrorsList(array $errors): array
    {
        $flattener = new ErrorsListFlattener();
        array_walk($errors, [$flattener, 'flattenArray']);
        return $flattener->getFlattenedArray();
    }

    private function setFlashMessage(ServerRequestInterface $request, InputFilterInterface $inputFilter): void
    {
        /** @var FlashMessagesInterface $flashMessages */
        $flashMessages = $request->getAttribute(FlashMessageMiddleware::FLASH_ATTRIBUTE);
        if ($flashMessages instanceof FlashMessagesInterface) {
            $flashMessages->flash('errors', $this->getFlattenedErrorsList($inputFilter->getMessages()));
            $flashMessages->flash('data', $inputFilter->getValues());
        }
    }
}
