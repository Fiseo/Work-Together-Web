<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
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

    public function getCompanyRegister(): ?string
    {
        return $this->companyRegister;
    }

    public function setCompanyRegister(string $companyRegister): static
    {
        $this->companyRegister = $companyRegister;

        return $this;
    }

    public function getCreation(): ?\DateTime
    {
        return $this->creation;
    }

    public function setCreation(\DateTime $creation): static
    {
        $this->creation = $creation;

        return $this;
    }
}
