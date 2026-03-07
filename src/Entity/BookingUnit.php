<?php

namespace App\Entity;

use App\Repository\BookingUnitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookingUnitRepository::class)]
class BookingUnit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'bookingUnits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Booking $booking = null;

    #[ORM\ManyToOne(inversedBy: 'bookingUnits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Unit $unit = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $start = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $end = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBooking(): ?Booking
    {
        return $this->booking;
    }

    public function setBooking(?Booking $booking): static
    {
        $this->booking = $booking;

        return $this;
    }

    public function getUnit(): ?Unit
    {
        return $this->unit;
    }

    public function setUnit(?Unit $unit): static
    {
        $this->unit = $unit;

        return $this;
    }

    public function getStart(): ?\DateTime
    {
        return $this->start;
    }

    public function setStart(?\DateTime $start): static
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?\DateTime
    {
        return $this->end;
    }

    public function setEnd(?\DateTime $end): static
    {
        $this->end = $end;

        return $this;
    }

    public function getLastServiceCall(): ?ServiceCall
    {
        $serviceCalls = $this->getUnit()->getServiceCalls();
        $filtered = [];
        foreach ($serviceCalls as $serviceCall) {
            if ($this->getStart() >= $serviceCall->getDate() && $serviceCall->getDate() <= $this->getEnd())
                $filtered[] = $serviceCall;
        }

        $closest = null;
        foreach ($filtered as $serviceCall) {
            if ($closest === null || $serviceCall->getDate() > $closest->getDate()) {
                $closest = $serviceCall;
            }
        }
        return $closest;
    }
}
