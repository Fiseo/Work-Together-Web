<?php

namespace App\Controller\DataModel;

class MainData
{
    private float $availablePercentage = 0;
    private int $totalUnit = 0;

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
