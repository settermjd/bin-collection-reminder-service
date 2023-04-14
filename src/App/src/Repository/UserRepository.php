<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\SuburbBinCollection;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    /**
     * @return array<int,User>
     */
    public function getMobileUsers(): array
    {
        $queryBuilder = $this->_em->createQueryBuilder();
        return $queryBuilder
            ->select(['u', 's.collectedOn'])
            ->from(User::class, 'u')
            ->leftJoin(SuburbBinCollection::class, 's')
            ->where($queryBuilder->expr()->isNotNull('u.mobile'))
            ->getQuery()
            ->getResult();
    }

    /**
     * @return array<int,User>
     */
    public function getEmailUsers(): array
    {
        $queryBuilder = $this->_em->createQueryBuilder();
        return $queryBuilder
            ->select(['u', 's.collectedOn'])
            ->from(User::class, 'u')
            ->leftJoin(SuburbBinCollection::class, 's')
            ->where($queryBuilder->expr()->isNotNull('u.email'))
            ->getQuery()
            ->getResult();
    }
}