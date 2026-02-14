<?php

namespace App\Entity;

use App\Repository\ComponentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ComponentRepository::class)]
class Component
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le libellé ne peut pas être vide !")]
    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: "Le libellé doit contenir au moins {{ limit }} caractères !",
        maxMessage: "Le libellé ne peut pas dépasser {{ limit }} caractères !"
    )]
    private ?string $label = null;

    #[ORM\ManyToOne(inversedBy: 'components')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message: "La type de composant est obligatoire !")]
    private ?ComponentType $type = null;

    /**
     * @var Collection<int, BookingUnit>
     */
    #[ORM\ManyToMany(targetEntity: BookingUnit::class, mappedBy: 'components')]
    private Collection $bookingUnits;

    /**
     * @var Collection<int, Unit>
     */
    #[ORM\ManyToMany(targetEntity: Unit::class, mappedBy: 'components')]
    private Collection $units;

    public function __construct()
    {
        $this->bookingUnits = new ArrayCollection();
        $this->units = new ArrayCollection();
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

    public function getType(): ?ComponentType
    {
        return $this->type;
    }

    public function setType(?ComponentType $type): static
    {
        $this->type = $type;

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
            $bookingUnit->addComponent($this);
        }

        return $this;
    }

    public function removeBookingUnit(BookingUnit $bookingUnit): static
    {
        if ($this->bookingUnits->removeElement($bookingUnit)) {
            $bookingUnit->removeComponent($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Unit>
     */
    public function getUnits(): Collection
    {
        return $this->units;
    }

    public function addUnit(Unit $unit): static
    {
        if (!$this->units->contains($unit)) {
            $this->units->add($unit);
            $unit->addComponent($this);
        }

        return $this;
    }

    public function removeUnit(Unit $unit): static
    {
        if ($this->units->removeElement($unit)) {
            $unit->removeComponent($this);
        }

        return $this;
    }
}
