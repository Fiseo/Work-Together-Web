<?php

namespace App\DataFixtures;

use App\Entity\Offer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OfferFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $o = (new Offer())
            ->setLabel("Base")
            ->setDiscount(100)
            ->setUnitProvided(1);
        $this->addReference('base', $o);
        $manager->persist($o);

        $o = (new Offer())
            ->setLabel("Start-Up")
            ->setDiscount(90)
            ->setUnitProvided(10);
        $this->addReference('startup', $o);
        $manager->persist($o);

        $o = (new Offer())
            ->setLabel("PME")
            ->setDiscount(80)
            ->setUnitProvided(21);
        $this->addReference('pme', $o);
        $manager->persist($o);

        $o = (new Offer())
            ->setLabel("Entreprise")
            ->setDiscount(70)
            ->setUnitProvided(42);
        $this->addReference('entreprise', $o);
        $manager->persist($o);

        $manager->flush();
    }
}
