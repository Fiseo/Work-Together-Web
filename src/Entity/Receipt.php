<?php

namespace App\Entity;

use App\Repository\ReceiptRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReceiptRepository::class)]
class Receipt
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    private ?string $invoice_number = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $creation = null;

    #[ORM\ManyToOne(inversedBy: 'receipts')]
    private ?Booking $booking = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 14, nullable: true)]
    private ?string $companyRegister = null;

    #[ORM\Column]
    private ?int $totalHT = null;

    #[ORM\Column]
    private ?int $totalTva = null;

    #[ORM\Column]
    private ?int $totalTtc = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $startPeriod = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $endPeriod = null;

    #[ORM\ManyToOne(inversedBy: 'receipts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Price $price = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInvoiceNumber(): ?string
    {
        return $this->invoice_number;
    }

    public function setInvoiceNumber(string $invoice_number): static
    {
        $this->invoice_number = $invoice_number;

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

    public function getBooking(): ?Booking
    {
        return $this->booking;
    }

    public function setBooking(?Booking $booking): static
    {
        $this->booking = $booking;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
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

    public function getTotalHT(): ?int
    {
        return $this->totalHT;
    }

    public function setTotalHT(int $totalHT): static
    {
        $this->totalHT = $totalHT;

        return $this;
    }

    public function getTotalTva(): ?int
    {
        return $this->totalTva;
    }

    public function setTotalTva(int $totalTva): static
    {
        $this->totalTva = $totalTva;

        return $this;
    }

    public function getTotalTtc(): ?int
    {
        return $this->totalTtc;
    }

    public function setTotalTtc(int $totalTtc): static
    {
        $this->totalTtc = $totalTtc;

        return $this;
    }

    public function getStartPeriod(): ?\DateTime
    {
        return $this->startPeriod;
    }

    public function setStartPeriod(\DateTime $startPeriod): static
    {
        $this->startPeriod = $startPeriod;

        return $this;
    }

    public function getEndPeriod(): ?\DateTime
    {
        return $this->endPeriod;
    }

    public function setEndPeriod(\DateTime $endPeriod): static
    {
        $this->endPeriod = $endPeriod;

        return $this;
    }

    public function getPrice(): ?Price
    {
        return $this->price;
    }

    public function setPrice(?Price $price): static
    {
        $this->price = $price;

        return $this;
    }
}
