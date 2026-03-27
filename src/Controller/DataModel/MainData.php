<?php

namespace App\Controller\DataModel;

class MainData
{
    private float $availablePercentage = 0;
    private int $totalUnit = 0;

    private int $price = 0;

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;
        return $this;
    }

    public function getAvailablePercentage(): float
    {
        return $this->availablePercentage;
    }

    public function setAvailablePercentage(float $availablePercentage): static
    {
        $this->availablePercentage = $availablePercentage;
        return $this;
    }

    public function getTotalUnit(): int
    {
        return $this->totalUnit;
    }

    public function setTotalUnit(int $totalUnit): static
    {
        $this->totalUnit = $totalUnit;
        return $this;
    }


}
