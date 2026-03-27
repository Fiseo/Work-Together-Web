<?php

namespace App\Repository;

use App\Entity\Price;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Price>
 */
class PriceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Price::class);
    }

    /**
     * @return Price|null Return the current price in function
     */
    public function findCurrent(): ?Price
    {
        return  $this->createQueryBuilder('p')
            ->andWhere('p.end IS NULL')
            ->getQuery()
            ->getOneOrNullResult();
    }


    /**
     * @param \DateTime $date
     * @return Price|null
     */
    public function findByDate(\DateTime $date): ?Price
    {
        $qb = $this->createQueryBuilder('p');
        $expr = $qb->expr();
        return $qb->where(
            $expr->orX(
                $expr->between(':date', 'p.start', 'p.end'),
                $expr->andX(
                    $expr->gte(':date', 'p.start'),
                    $expr->isNull('p.end')
                )
            )
        )->setParameter('date', $date)
            ->getQuery()
            ->getOneOrNullResult();

    }

}
