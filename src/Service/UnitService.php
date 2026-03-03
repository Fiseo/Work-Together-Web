<?php

namespace App\Service;

use App\Repository\UnitRepository;

class UnitService
{
    private int $numberUnit;
    public function __construct(
        private UnitRepository $unitRepository
    ){}

    private function setNumberUnit(): void
    {
        $this->numberUnit = $this->unitRepository->findAvailable()->count();
    }

    public function getNumberUnit(): int
    {
        if (!isset($this->numberUnit))
            $this->setNumberUnit();
        return $this->numberUnit;
    }

    public function isAvailable(int $number): bool
    {
        if (!isset($this->numberUnit))
            $this->setNumberUnit();
        return ($this->numberUnit >= $number);
    }
}
