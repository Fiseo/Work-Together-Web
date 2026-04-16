<?php

namespace App\Repository;

use App\Entity\Offer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Offer>
 */
class OfferRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Offer::class);
    }

    /**
     * @param int $availableUnit
     * @return Collection<int, Offer>
     */
    public function findOfferGreaterThan(int $availableUnit): Collection
    {
        return new ArrayCollection($this->createQueryBuilder('o')
            ->andWhere('o.unitProvided <= :val')
            ->setParameter('val', $availableUnit)
            ->getQuery()
            ->getResult())
            ;
    }

    public function findAllActive(): Collection
    {
        return new ArrayCollection($this->createQueryBuilder('o')
            ->andWhere('o.isActive = :true')
            ->setParameter('true', true)
            ->OrderBy('o.unitProvided', 'ASC')
            ->getQuery()
            ->getResult())
            ;
    }
}
