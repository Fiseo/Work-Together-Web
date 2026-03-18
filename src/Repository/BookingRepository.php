<?php

namespace App\Repository;

use App\Entity\Booking;
use App\Enum\BookingStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Booking>
 */
class BookingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Booking::class);
    }

    /**
     * @return Collection<int, Booking>
     */
    public function findActive(): Collection
    {
        $result = [];
        $bookings = $this->findAll();
        foreach ($bookings as $booking) {
            if ($booking->getStatus() == BookingStatus::Active) {
                $result[] = $booking;
            }
        }
        return new ArrayCollection($result);
    }
}
