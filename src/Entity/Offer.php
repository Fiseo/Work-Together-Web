<?php

namespace App\Entity;

use App\Repository\OfferRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OfferRepository::class)]
class Offer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le libellé ne peut pas être vide !')]
    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: "Le libellé doit contenir au moins {{ limit }} caractères !",
        maxMessage: "Le libellé ne peut pas dépasser {{ limit }} caractères !"
    )]
    private ?string $label = null;

    #[ORM\Column]
    #[Assert\NotNull(message: 'La réduction est obligatoire !')]
    #[Assert\Range(
        min: 0,
        max: 100,
        notInRangeMessage: 'La réduction doit être entre {{ min }} et {{ max }} !'
    )]
    private ?int $discount = null;

    #[ORM\Column]
    #[Assert\NotNull(message: 'Le nombre d\'unité est obligatoire !')]
    private ?int $unitProvided = null;

    /**
     * @var Collection<int, Booking>
     */
    #[ORM\OneToMany(targetEntity: Booking::class, mappedBy: 'offer')]
    private Collection $bookings;

    public function __construct()
    {
        $this->bookings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDiscount(): ?int
    {
        return $this->discount;
    }

    public function setDiscount(int $discount): static
    {
        $this->discount = $discount;

        return $this;
    }

    public function getUnitProvided(): ?int
    {
        return $this->unitProvided;
    }

    public function setUnitProvided(int $unitProvided): static
    {
        $this->unitProvided = $unitProvided;

        return $this;
    }

    /**
     * @return Collection<int, Booking>
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): static
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings->add($booking);
            $booking->setOffer($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): static
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getOffer() === $this) {
                $booking->setOffer(null);
            }
        }

        return $this;
    }
}
