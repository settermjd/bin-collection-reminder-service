<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'suburb_bin_collection')]
class SuburbBinCollection
{
    #[Id]
    #[Column(name: 'suburb', type: Types::STRING, length: 40)]
    private ?string $suburb;

    #[Column(name: 'collected_on', type: Types::STRING, length: 40)]
    private ?string $collectedOn;

    public function __construct(?int $id, ?string $suburb, ?string $collectedOn)
    {
        $this->id = $id;
        $this->suburb = $suburb;
        $this->collectedOn = $collectedOn;
    }

    public function getCollectedOn(): ?string
    {
        return $this->collectedOn;
    }
}