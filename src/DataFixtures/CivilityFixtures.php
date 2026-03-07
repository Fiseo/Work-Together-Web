<?php

namespace App\DataFixtures;

use App\Entity\Civility;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CivilityFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $civility1 = new Civility();
        $civility1->setLabel('Homme');
        $this->addReference('h', $civility1);
        $manager->persist($civility1);

        $civility2 = new Civility();
        $civility2->setLabel('Femme');
        $this->addReference('f', $civility2);
        $manager->persist($civility2);

        $manager->flush();
    }
}
