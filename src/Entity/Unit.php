<?php

namespace App\Entity;

use App\Repository\UnitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UnitRepository::class)]
class Unit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom de l'unité ne peut pas être vide !")]
    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: "Le nom de l'unité doit contenir au moins {{ limit }} caractères !",
        maxMessage: "Le nom de l'unité ne peut pas dépasser {{ limit }} caractères !"
    )]
    private ?string $label = null;

    #[ORM\ManyToOne(inversedBy: 'units')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: "L'unité doit appartenir à une baie !")]
    private ?Bay $bay = null;

    #[ORM\Column]
    #[Assert\NotNull(message: "Il est essentiel de savoir si l'unité a un problème !")]
    private ?bool $haveProblem = null;

    /**
     * @var Collection<int, ServiceCall>
     */
    #[ORM\OneToMany(targetEntity: ServiceCall::class, mappedBy: 'unit')]
    private Collection $serviceCalls;

    /**
     * @var Collection<int, BookingUnit>
     */
    #[ORM\OneToMany(targetEntity: BookingUnit::class, mappedBy: 'unit')]
    private Collection $bookingUnits;

    /**
     * @var Collection<int, Component>
     */
    #[ORM\ManyToMany(targetEntity: Component::class, inversedBy: 'units')]
    private Collection $components;

    public function __construct()
    {
        $this->serviceCalls = new ArrayCollection();
        $this->bookingUnits = new ArrayCollection();
        $this->components = new ArrayCollection();
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

    public function getBay(): ?Bay
    {
        return $this->bay;
    }

    public function setBay(?Bay $bay): static
    {
        $this->bay = $bay;

        return $this;
    }

    /**
     * @return Collection<int, ServiceCall>
     */
    public function getServiceCalls(): Collection
    {
        return $this->serviceCalls;
    }

    public function addServiceCall(ServiceCall $serviceCall): static
    {
        if (!$this->serviceCalls->contains($serviceCall)) {
            $this->serviceCalls->add($serviceCall);
            $serviceCall->setUnit($this);
        }

        return $this;
    }

    public function removeServiceCall(ServiceCall $serviceCall): static
    {
        if ($this->serviceCalls->removeElement($serviceCall)) {
            // set the owning side to null (unless already changed)
            if ($serviceCall->getUnit() === $this) {
                $serviceCall->setUnit(null);
            }
        }

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
            $bookingUnit->setUnit($this);
        }

        return $this;
    }

    public function removeBookingUnit(BookingUnit $bookingUnit): static
    {
        if ($this->bookingUnits->removeElement($bookingUnit)) {
            // set the owning side to null (unless already changed)
            if ($bookingUnit->getUnit() === $this) {
                $bookingUnit->setUnit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Component>
     */
    public function getComponents(): Collection
    {
        return $this->components;
    }

    public function addComponent(Component $component): static
    {
        if (!$this->components->contains($component)) {
            $this->components->add($component);
        }

        return $this;
    }

    public function removeComponent(Component $component): static
    {
        $this->components->removeElement($component);

        return $this;
    }

    public function isHaveProblem(): ?bool
    {
        return $this->haveProblem;
    }

    public function setHaveProblem(bool $haveProblem): static
    {
        $this->haveProblem = $haveProblem;

        return $this;
    }
}
