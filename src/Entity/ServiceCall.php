<?php

namespace App\Entity;

use App\Repository\ServiceCallRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ServiceCallRepository::class)]
class ServiceCall
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull(message: 'La date d\'intervention est obligatoire !')]
    private ?\DateTime $date = null;

    #[ORM\ManyToOne(inversedBy: 'serviceCalls')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message: 'Connaitre le technicien est obligatoire !')]
    private ?Technician $technician = null;

    #[ORM\ManyToOne(inversedBy: 'serviceCalls')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message: 'Connaitre l\'unité subissant l\'intervention est obligatoire !')]
    private ?Unit $unit = null;

    #[ORM\ManyToOne(inversedBy: 'serviceCalls')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message: 'Le type d\'intervention est obligatoire !')]
    private ?ServiceCallType $type = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(?\DateTime $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getTechnician(): ?Technician
    {
        return $this->technician;
    }

    public function setTechnician(?Technician $technician): static
    {
        $this->technician = $technician;

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

    public function getType(): ?ServiceCallType
    {
        return $this->type;
    }

    public function setType(?ServiceCallType $type): static
    {
        $this->type = $type;

        return $this;
    }
}
