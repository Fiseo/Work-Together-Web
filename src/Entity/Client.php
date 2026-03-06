<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\MappedSuperclass]
abstract class Client extends User
{
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $review = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Range(
        min: 1,
        max: 5,
        notInRangeMessage: 'La note doit être entre {{ min }} et {{ max }}.'
    )]
    private ?int $rating = null;

    public function getReview(): ?string
    {
        return $this->review;
    }

    public function setReview(?string $review): static
    {
        $this->review = $review;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(?int $rating): static
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * @return Collection<int, Booking>
     */
    abstract function getBookings(): Collection;
    abstract function addBooking(Booking $booking): static;
    abstract function removeBooking(Booking $booking): static;

    /**
     * @return Collection<int, Unit>
     */
    public function getUnits(): Collection
    {
        $result = [];
        foreach ($this->getBookings() as $booking)
            foreach ($booking->getCurrentUnits() as $unit)
                $result[] = $unit;
        return new ArrayCollection($result);
    }

    /**
     * @return Collection<int, Booking>
     */
    public function getActiveBookings(): Collection
    {
        $now = new \DateTime();
        $result = [];
        foreach ($this->getBookings() as $booking){
            if ($booking->isPayed() && $booking->getStart() <= $now && $booking->getEnd() >= $now)
                $result[] = $booking;
        }
        return new ArrayCollection($result);
    }

    /**
     * @return Collection<int, Booking>
     */
    public function getFinishedBookings(): Collection
    {
        $now = new \DateTime();
        $result = [];
        foreach ($this->getBookings() as $booking){
            if ($booking->isPayed() && $booking->getEnd() <= $now)
                $result[] = $booking;
        }
        return new ArrayCollection($result);
    }

    /**
     * @return Collection<int, Unit>
     */
    public function getActiveUnits(): Collection
    {
        $result = [];
        foreach ($this->getActiveBookings() as $booking){
            foreach ($booking->getCurrentUnits() as $unit){
                $result[] = $unit;
            }
        }
        return new ArrayCollection($result);
    }
}
