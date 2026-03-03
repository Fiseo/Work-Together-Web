<?php

namespace App\Repository;

use App\Entity\Unit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Unit>
 */
class UnitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Unit::class);
    }

    public function findAllWithBookingUnits(): Collection
    {
        $result = $this->createQueryBuilder('u')
            ->leftJoin('u.bookingUnits', 'b')
            ->addSelect('b')
            ->getQuery()
            ->getResult();
        return new ArrayCollection($result);
    }
    /**
     * @return Collection<int, Unit>
     */
    public function findAvailable(): Collection
    {
        $nonFiltered = $this->findAllWithBookingUnits();

        $result = [];
        foreach ($nonFiltered as $unit) {
            if ($unit->isAvailable())
                $result[] = $unit;
        }

        return new ArrayCollection($result);
    }


}
