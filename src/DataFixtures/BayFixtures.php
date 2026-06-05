<?php

namespace App\DataFixtures;

use App\Entity\Bay;
use App\Entity\Unit;
use App\Service\UnitService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BayFixtures extends Fixture
{

    private function createBay(string $label, ObjectManager $manager)
    {
        $b = (new Bay())
            ->setLabel($label)
            ->setUnitPrefix("U");
        $manager->persist($b);

        for ($i = 1; $i <= 42; $i++) {
            $u = new Unit();
            $u->setBay($b);
            if ($i >= 10)
                $u->setLabel($b->getUnitPrefix().$i);
            else
                $u->setLabel($b->getUnitPrefix().'0'.$i);
            if (mt_rand(1, 67) === 1)
                $u->setHaveProblem(true);
            else
                $u->setHaveProblem(false);

            $manager->persist($u);
        }
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 30; $i++) {
            if ($i >= 10)
                $this->createBay("B".$i, $manager);
            else
                $this->createBay("B0".$i, $manager);
        }

        $manager->flush();
    }
}
