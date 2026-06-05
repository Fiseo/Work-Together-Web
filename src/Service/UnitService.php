<?php

namespace App\Service;

use App\Entity\Unit;
use App\Repository\UnitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

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
        $this->setNumberUnit();
        return $this->numberUnit;
    }

    public function isAvailable(int $number): bool
    {
        $this->setNumberUnit();
        return ($this->numberUnit >= $number);
    }

    public function isAvailableAt(int $number, \DateTime $date): bool
    {
        $num = $this->unitRepository->findAvailableAt($date)->count();
        return ($num >= $number);
    }

    /**
     * @param int $number
     * @return Collection<int, Unit> return an empty collection if asked more than available
     */
    public function getAvailableUnits(int $number): Collection
    {
        $result = new ArrayCollection();
        if (!$this->isAvailable($number))
            return $result;

        $availableUnits = $this->unitRepository->findAvailable();
        for ($i = 1; $i <= $number; $i++) {
            $result->add($availableUnits->get($i));
        }
        return $result;
    }

    /**
     * @param int $number
     * @param \DateTime $date
     * @return Collection<int, Unit> return an empty collection if asked more than available
     */
    public function getAvailableUnitsAt(int $number, \DateTime $date): Collection
    {
        $result = new ArrayCollection();
        if (!$this->isAvailableAt($number, $date))
            return $result;

        $availableUnits = $this->unitRepository->findAvailableAt($date);
        for ($i = 1; $i <= $number; $i++) {
            $result->add($availableUnits->get($i));
        }
        return $result;
    }
}
