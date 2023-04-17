<?php

declare(strict_types=1);

namespace App\Handler;

use Mezzio\Flash\FlashMessageMiddleware;
use Mezzio\Flash\FlashMessagesInterface;
use Psr\Http\Message\ServerRequestInterface;

trait FormHandlerTrait
{
    public function setDataFromFlashMessages(ServerRequestInterface $request): array
    {
        $data = [];

        /** @var FlashMessagesInterface $flashMessages */
        $flashMessages = $request->getAttribute(FlashMessageMiddleware::FLASH_ATTRIBUTE);

        if (! $flashMessages === null) {
            $messages       = $flashMessages->getFlashes();
            $data['errors'] = $messages['errors'] ?? '';
            $data['data']   = $messages['data'] ?? '';
        }

        return $data;
    }
}
