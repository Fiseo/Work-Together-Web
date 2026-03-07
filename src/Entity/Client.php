<?php

namespace App\Entity;

use App\Enum\BookingStatus;
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
     * @param BookingStatus|null $statusWanted Return only Bookings with a certain status
     * @param BookingStatus|null $statusUnwanted Return only Bookings without a certain status
     * Prioritize wanted over unwanted
     * @return Collection<int, Booking>
     */
    public function getBookingsFilter(?BookingStatus $statusWanted = null, ?BookingStatus $statusUnwanted = null): Collection
    {
        if (isset($statusWanted)) {
            $result = [];
            foreach ($this->getBookings() as $booking){
                if ($booking->getStatus() === $statusWanted)
                    $result[] = $booking;
            }
            return new ArrayCollection($result);
        } else if (isset($statusUnwanted)) {
            $result = [];
            foreach ($this->getBookings() as $booking) {
                if ($booking->getStatus() !== $statusUnwanted)
                    $result[] = $booking;
            }
            return new ArrayCollection($result);
        } else {
            return $this->getBookings();
        }
    }

    /**
     * @return Collection<int, Unit>
     */
    public function getUnits(): Collection
    {
        $result = [];
        foreach ($this->getBookingsFilter(BookingStatus::Active) as $booking){
            foreach ($booking->getUnits() as $unit){
                $result[] = $unit;
            }
        }
        return new ArrayCollection($result);
    }
}
