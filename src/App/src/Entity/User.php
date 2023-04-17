<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'user')]
class User
{
    #[Column(name: 'full_name', type: Types::STRING, length: 100)]
    private ?string $fullName;

    #[Column(name: 'email', type: Types::STRING, length: 250, unique: true, nullable: true)]
    private ?string $email;

    #[Column(name: 'mobile', type: Types::STRING, length: 14, unique: true, nullable: true)]
    private ?string $mobile;

    #[Id]
    #[ManyToOne(targetEntity: SuburbBinCollection::class)]
    #[JoinColumn(name: 'suburb', referencedColumnName: 'suburb')]
    private ?SuburbBinCollection $suburbBinCollection = null;

    public function __construct(
        ?string $suburb,
        ?string $email,
        ?string $mobile,
        ?string $fullName,
        ?int $id = null
    ) {
        $this->id = $id;
        $this->suburb = $suburb;
        $this->email = $email;
        $this->mobile = $mobile;
        $this->fullName = $fullName;
    }

    public function getId(): ?int
    {
        return $this->id ?? null;
    }

    public function getSuburb(): string
    {
        return $this->suburb ?? '';
    }

    public function getEmail(): string
    {
        return $this->email ?? '';
    }

    public function getMobile(): string
    {
        return $this->mobile ?? '';
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

}