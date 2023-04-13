<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'user')]
class User
{
    #[Id]
    #[Column(type: Types::INTEGER)]
    #[GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id;

    #[Column(name: 'suburb', type: Types::STRING, length: 40)]
    private ?string $suburb;

    #[Column(name: 'email', type: Types::STRING, length: 250, unique: true, nullable: true)]
    private ?string $email;

    #[Column(name: 'mobile', type: Types::STRING, length: 14, unique: true, nullable: true)]
    private ?string $mobile;
}