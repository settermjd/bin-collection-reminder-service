<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'user')]
class User
{
    #[ORM\Column(name: 'full_name', type: Types::STRING, length: 100)]
    private ?string $fullName;

    #[ORM\Column(name: 'email', type: Types::STRING, length: 250, unique: true, nullable: true)]
    private ?string $email;

    #[ORM\Column(name: 'mobile', type: Types::STRING, length: 14, unique: true, nullable: true)]
    private ?string $mobile;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: SuburbBinCollection::class)]
    #[ORM\JoinColumn(name: 'suburb', referencedColumnName: 'suburb')]
    private ?SuburbBinCollection $suburbBinCollection = null;

    public function __construct(
        ?string $suburb,
        ?string $email,
        ?string $mobile,
        ?string $fullName,
        ?int $id = null
    ) {
        $this->id       = $id;
        $this->suburb   = $suburb;
        $this->email    = $email;
        $this->mobile   = $mobile;
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

    public function getBinCollectionDay(): string
    {
        return $this->suburbBinCollection->getCollectedOn();
    }
}
