<?php

namespace App\Entity;

use App\Repository\CivilityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CivilityRepository::class)]
class Civility
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

    /**
     * @var Collection<int, Staff>
     */
    #[ORM\OneToMany(targetEntity: Staff::class, mappedBy: 'civility')]
    private Collection $staffs;

    /**
     * @var Collection<int, Individual>
     */
    #[ORM\OneToMany(targetEntity: Individual::class, mappedBy: 'civility')]
    private Collection $clients;

    public function __construct()
    {
        $this->staffs = new ArrayCollection();
        $this->clients = new ArrayCollection();
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

    /**
     * @return Collection<int, Staff>
     */
    public function getStaffs(): Collection
    {
        return $this->staffs;
    }

    public function addStaff(Staff $staff): static
    {
        if (!$this->staffs->contains($staff)) {
            $this->staffs->add($staff);
            $staff->setCivility($this);
        }

        return $this;
    }

    public function removeStaff(Staff $staff): static
    {
        if ($this->staffs->removeElement($staff)) {
            // set the owning side to null (unless already changed)
            if ($staff->getCivility() === $this) {
                $staff->setCivility(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Individual>
     */
    public function getClients(): Collection
    {
        return $this->clients;
    }

    public function addClient(Individual $client): static
    {
        if (!$this->clients->contains($client)) {
            $this->clients->add($client);
            $client->setCivility($this);
        }

        return $this;
    }

    public function removeClient(Individual $client): static
    {
        if ($this->clients->removeElement($client)) {
            // set the owning side to null (unless already changed)
            if ($client->getCivility() === $this) {
                $client->setCivility(null);
            }
        }

        return $this;
    }
}
