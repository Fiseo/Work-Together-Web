<?php

namespace App\Service;

use App\Repository\UnitRepository;

class UnitService
{
    private int $numberUnit;
    public function __construct(
        private UnitRepository $unitRepository
    ){}
    public function isAvailable(int $number): bool
    {
        if (!isset($this->numberUnit))
            $this->numberUnit = $this->unitRepository->findAvailable()->count();
        return ($this->numberUnit >= $number);
    }
}
