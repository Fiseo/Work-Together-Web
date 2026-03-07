<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
class Company extends Client
{
    #[ORM\Column(length: 14)]
    #[Assert\NotBlank(message: "Le numéro de SIRET est obligatoire !")]
    #[Assert\Length(
        exactly: 14,
        exactMessage: 'Le numéro de SIRET doit être fait de {{ limit }} caractères !'
    )]
    private ?string $companyRegister = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull(message: "La date de création est obligatoire !")]
    #[Assert\Range(
        max: 'today',
        notInRangeMessage: 'La date de création ne peut être dans le futur !'
    )]
    private ?\DateTime $creation = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom de l'entreprise ne peut pas être vide !")]
    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: "Le nom de l'entreprise doit contenir au moins {{ limit }} caractères !",
        maxMessage: "Le nom de l'entreprise ne peut pas dépasser {{ limit }} caractères !"
    )]
    private ?string $name = null;

    /**
     * @var Collection<int, Booking>
     */
    #[ORM\OneToMany(targetEntity: Booking::class, mappedBy: 'company')]
    private Collection $bookings;

    public function __construct()
    {
        $this->bookings = new ArrayCollection();
    }

    public function getCompanyRegister(): ?string
    {
        return $this->companyRegister;
    }

    public function setCompanyRegister(?string $companyRegister): static
    {
        $this->companyRegister = $companyRegister;

        return $this;
    }

    public function getCreation(): ?\DateTime
    {
        return $this->creation;
    }

    public function setCreation(?\DateTime $creation): static
    {
        $this->creation = $creation;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

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
            $booking->setClient($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): static
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getClient() === $this) {
                $booking->setClient(null);
            }
        }

        return $this;
    }
}
