<?php

declare(strict_types=1);

namespace App\Factory;

use Psr\Container\ContainerInterface;
use SendGrid;

class SendGridFactory
{
    public function __invoke(ContainerInterface $container): SendGrid
    {
        [
            'api_key' => $apiKey,
        ] = $container->get('config')['sendgrid'];

        return new SendGrid($apiKey);
    }
}
