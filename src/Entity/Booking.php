<?php

namespace App\Entity;

use App\Enum\BookingStatus;
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

    /**
     * @var Collection<int, BookingUnit>
     */
    #[ORM\OneToMany(targetEntity: BookingUnit::class, mappedBy: 'booking', orphanRemoval: true)]
    private Collection $bookingUnits;

    #[ORM\Column]
    private ?bool $isPayed = null;

    #[ORM\Column]
    private ?bool $isRenewable = null;

    #[ORM\ManyToOne(inversedBy: 'bookings')]
    private ?Individual $individual = null;

    #[ORM\ManyToOne(inversedBy: 'bookings')]
    private ?Company $company = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

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
        if ($this->individual !== null)
            return $this->individual;
        else
            return $this->company;
    }

    public function setClient(?Client $client): static
    {
        if ($client instanceof Individual)
            $this->individual = $client;
        else
            $this->company = $client;
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
    public function getUnits(): Collection
    {
        $result = [];
        foreach ($this->getBookingUnits() as $bookingUnit) {
            if ($bookingUnit->getEnd()->format('Y-m-d') === $this->getEnd()->format('Y-m-d')) {
                $result[] = $bookingUnit->getUnit();
            }
        }
        return new ArrayCollection($result);
    }

    public function isPayed(): ?bool
    {
        return $this->isPayed;
    }

    public function setIsPayed(bool $isPayed): static
    {
        $this->isPayed = $isPayed;

        return $this;
    }

    public function isRenewable(): ?bool
    {
        return $this->isRenewable;
    }

    public function setIsRenewable(bool $isRenewable): static
    {
        $this->isRenewable = $isRenewable;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getStatus(): BookingStatus
    {
        $now = new \DateTime();
        if ($this->isPayed() && $this->getStart() <= $now && $this->getEnd() >= $now)
            return BookingStatus::Active;
        else if ($this->isPayed() && $this->getEnd() < $now)
            return BookingStatus::Finished;
        else if (!$this->isPayed())
            return BookingStatus::NeedPayement;
        return BookingStatus::Null;
    }
}
