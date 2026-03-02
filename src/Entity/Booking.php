<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotNull(message: "Il est nécessaire de savoir si la réservation est mensuel !")]
    private ?bool $isMonthly = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $start = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $end = null;

    #[ORM\ManyToOne(inversedBy: 'bookings')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message: "La type de d'offre est obligatoire !")]
    private ?Offer $offer = null;

    #[ORM\ManyToOne(inversedBy: 'bookings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $client = null;

    /**
     * @var Collection<int, BookingUnit>
     */
    #[ORM\OneToMany(targetEntity: BookingUnit::class, mappedBy: 'booking', orphanRemoval: true)]
    private Collection $bookingUnits;

    public function __construct()
    {
        $this->bookingUnits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isMonthly(): ?bool
    {
        return $this->isMonthly;
    }

    public function setIsMonthly(?bool $isMonthly): static
    {
        $this->isMonthly = $isMonthly;

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

    public function getOffer(): ?Offer
    {
        return $this->offer;
    }

    public function setOffer(?Offer $offer): static
    {
        $this->offer = $offer;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Collection<int, BookingUnit>
     */
    public function getBookingUnits(): Collection
    {
        return $this->bookingUnits;
    }

    public function addBookingUnit(BookingUnit $bookingUnit): static
    {
        if (!$this->bookingUnits->contains($bookingUnit)) {
            $this->bookingUnits->add($bookingUnit);
            $bookingUnit->setBooking($this);
        }

        return $this;
    }

    public function removeBookingUnit(BookingUnit $bookingUnit): static
    {
        if ($this->bookingUnits->removeElement($bookingUnit)) {
            // set the owning side to null (unless already changed)
            if ($bookingUnit->getBooking() === $this) {
                $bookingUnit->setBooking(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Unit>
     */
    public function getCurrentUnits(): Collection
    {
        $result = [];
        foreach ($this->getBookingUnits() as $bookingUnit) {
            if ($bookingUnit->getEnd() === $this->getEnd()) {
                $result[] = $bookingUnit->getUnit();
            }
        }
        return new ArrayCollection($result);
    }
}
