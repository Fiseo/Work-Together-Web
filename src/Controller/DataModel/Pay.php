<?php

namespace App\Controller\DataModel;

use App\Entity\Booking;

class Pay
{
    private int $priceBefore;
    private int $priceAfter;
    private int $priceTVA;
    private Booking $booking;

    public function getPriceBefore(): int
    {
        return $this->priceBefore;
    }

    public function setPriceBefore(int $priceBefore): void
    {
        $this->priceBefore = $priceBefore;
    }

    public function getPriceAfter(): int
    {
        return $this->priceAfter;
    }

    public function setPriceAfter(int $priceAfter): void
    {
        $this->priceAfter = $priceAfter;
    }

    public function getPriceTVA(): int
    {
        return $this->priceTVA;
    }

    public function setPriceTVA(int $priceTVA): void
    {
        $this->priceTVA = $priceTVA;
    }

    public function getBooking(): Booking
    {
        return $this->booking;
    }

    public function setBooking(Booking $booking): void
    {
        $this->booking = $booking;
    }
}
