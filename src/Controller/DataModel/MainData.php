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

    public function setAvailablePercentage(float $availablePercentage): void
    {
        $this->availablePercentage = $availablePercentage;
    }

    public function getTotalUnit(): int
    {
        return $this->totalUnit;
    }

    public function setTotalUnit(int $totalUnit): void
    {
        $this->totalUnit = $totalUnit;
    }


}
