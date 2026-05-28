<?php

namespace App\DataFixtures;

use App\Entity\Bay;
use App\Entity\Unit;
use App\Service\UnitService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BayFixtures extends Fixture
{
    public function __construct(private UnitService $unitService){}
    public function load(ObjectManager $manager): void
    {
        $uTemplate = (new Unit())
            ->setHaveProblem(false);

        $b = (new Bay())
            ->setLabel('B01')
            ->setUnitPrefix("U");
        $manager->persist($b);

        for ($i = 1; $i <= 42; $i++) {
            $u = clone $uTemplate;
            $u->setBay($b);
            if ($i >= 10)
                $u->setLabel($b->getUnitPrefix().$i);
            else
                $u->setLabel($b->getUnitPrefix().'0'.$i);
            $manager->persist($u);
        }

        $b = (new Bay())
            ->setLabel('B02')
            ->setUnitPrefix("U");
        $manager->persist($b);

        for ($i = 1; $i <= 42; $i++) {
            $u = clone $uTemplate;
            $u->setBay($b);
            if ($i >= 10)
                $u->setLabel($b->getUnitPrefix().$i);
            else
                $u->setLabel($b->getUnitPrefix().'0'.$i);
            $manager->persist($u);
        }

        $b = (new Bay())
            ->setLabel('B03')
            ->setUnitPrefix("U");
        $manager->persist($b);

        for ($i = 1; $i <= 42; $i++) {
            $u = clone $uTemplate;
            $u->setBay($b);
            if ($i >= 10)
                $u->setLabel($b->getUnitPrefix().$i);
            else
                $u->setLabel($b->getUnitPrefix().'0'.$i);
            $manager->persist($u);
        }

        $b = (new Bay())
            ->setLabel('B04')
            ->setUnitPrefix("U");
        $manager->persist($b);

        for ($i = 1; $i <= 42; $i++) {
            $u = clone $uTemplate;
            $u->setBay($b);
            if ($i >= 10)
                $u->setLabel($b->getUnitPrefix().$i);
            else
                $u->setLabel($b->getUnitPrefix().'0'.$i);
            $manager->persist($u);
        }

        $b = (new Bay())
            ->setLabel('B05')
            ->setUnitPrefix("U");
        $manager->persist($b);

        for ($i = 1; $i <= 42; $i++) {
            $u = clone $uTemplate;
            $u->setBay($b);
            if ($i >= 10)
                $u->setLabel($b->getUnitPrefix().$i);
            else
                $u->setLabel($b->getUnitPrefix().'0'.$i);
            $manager->persist($u);
        }

        $manager->flush();

        $units = $this->unitService->getAvailableUnits(6);

        foreach ($units as $unit) {
            $unit->setHaveProblem(true);
            $manager->persist($unit);
        }

        $manager->flush();
    }
}
