<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'suburb_bin_collection')]
class SuburbBinCollection
{
    #[ORM\Id]
    #[ORM\Column(name: 'suburb', type: Types::STRING, length: 40)]
    private ?string $suburb;

    #[ORM\Column(name: 'collected_on', type: Types::STRING, length: 40)]
    private ?string $collectedOn;

    public function __construct(?int $id, ?string $suburb, ?string $collectedOn)
    {
        $this->id          = $id;
        $this->suburb      = $suburb;
        $this->collectedOn = $collectedOn;
    }

    public function getCollectedOn(): ?string
    {
        return $this->collectedOn;
    }
}
