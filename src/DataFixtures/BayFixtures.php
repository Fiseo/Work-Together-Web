<?php

namespace App\DataFixtures;

use App\Entity\Bay;
use App\Entity\Unit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BayFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $uTemplate = (new Unit())
            ->setHaveProblem(false);

        $b = (new Bay())
            ->setLabel('B01');
        $manager->persist($b);

        for ($i = 1; $i <= 42; $i++) {
            $u = clone $uTemplate;
            $u->setBay($b);
            if ($i >= 10)
                $u->setLabel('U'.$i);
            else
                $u->setLabel('U0'.$i);
            $manager->persist($u);
        }

        $b = (new Bay())
            ->setLabel('B02');
        $manager->persist($b);

        for ($i = 1; $i <= 42; $i++) {
            $u = clone $uTemplate;
            $u->setBay($b);
            if ($i >= 10)
                $u->setLabel('U'.$i);
            else
                $u->setLabel('U0'.$i);
            $manager->persist($u);
        }

        $b = (new Bay())
            ->setLabel('B03');
        $manager->persist($b);

        for ($i = 1; $i <= 42; $i++) {
            $u = clone $uTemplate;
            $u->setBay($b);
            if ($i >= 10)
                $u->setLabel('U'.$i);
            else
                $u->setLabel('U0'.$i);
            $manager->persist($u);
        }

        $b = (new Bay())
            ->setLabel('B04');
        $manager->persist($b);

        for ($i = 1; $i <= 42; $i++) {
            $u = clone $uTemplate;
            $u->setBay($b);
            if ($i >= 10)
                $u->setLabel('U'.$i);
            else
                $u->setLabel('U0'.$i);
            $manager->persist($u);
        }

        $b = (new Bay())
            ->setLabel('B04');
        $manager->persist($b);

        for ($i = 1; $i <= 42; $i++) {
            $u = clone $uTemplate;
            $u->setBay($b);
            if ($i >= 10)
                $u->setLabel('U'.$i);
            else
                $u->setLabel('U0'.$i);
            $manager->persist($u);
        }

        $manager->flush();
    }
}
