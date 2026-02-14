<?php

namespace App\Entity;

use App\Repository\TechnicianRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TechnicianRepository::class)]
class Technician extends Staff
{
    /**
     * @var Collection<int, ServiceCall>
     */
    #[ORM\OneToMany(targetEntity: ServiceCall::class, mappedBy: 'technician')]
    private Collection $serviceCalls;

    public function __construct()
    {
        $this->serviceCalls = new ArrayCollection();
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
            $serviceCall->setTechnician($this);
        }

        return $this;
    }

    public function removeServiceCall(ServiceCall $serviceCall): static
    {
        if ($this->serviceCalls->removeElement($serviceCall)) {
            // set the owning side to null (unless already changed)
            if ($serviceCall->getTechnician() === $this) {
                $serviceCall->setTechnician(null);
            }
        }

        return $this;
    }
}
