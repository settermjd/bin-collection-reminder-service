<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\SuburbBinCollection;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function getMobileUsers(): ArrayCollection
    {
        $queryBuilder = $this->_em->createQueryBuilder();
        $result       = $queryBuilder
            ->select('u')
            ->from(User::class, 'u')
            ->leftJoin(SuburbBinCollection::class, 's')
            ->where($queryBuilder->expr()->isNotNull('u.mobile'))
            ->getQuery()
            ->getResult();

        return new ArrayCollection($result);
    }

    public function getEmailUsers(): ArrayCollection
    {
        $queryBuilder = $this->_em->createQueryBuilder();
        $result       = $queryBuilder
            ->select('u')
            ->from(User::class, 'u')
            ->leftJoin(SuburbBinCollection::class, 's')
            ->where($queryBuilder->expr()->isNotNull('u.email'))
            ->getQuery()
            ->getResult();

        return new ArrayCollection($result);
    }
}
