<?php

declare(strict_types=1);

namespace App\Factory;

use Psr\Container\ContainerInterface;
use Twilio\Rest\Client;

class TwilioRestClientFactory
{
    public function __invoke(ContainerInterface $container): Client
    {
        [
            'account_sid' => $accountSid,
            'auth_token'  => $authToken,
        ] = $container->get('config')['twilio'];

        return new Client($accountSid, $authToken);
    }
}
