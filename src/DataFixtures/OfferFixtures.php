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
            ->setUnitProvided(1)
            ->setDescription("Idéal pour tester notre infrastructure. Une unité dédiée, accès complet à nos services réseau et supervision 24/7.");
        $this->addReference('base', $o);
        $manager->persist($o);

        $o = (new Offer())
            ->setLabel("Start-Up")
            ->setDiscount(90)
            ->setUnitProvided(10)
            ->setDescription("Conçu pour les jeunes entreprises en croissance. 10 unités avec une remise de 10%, parfait pour démarrer sans surcoût.");
        $this->addReference('startup', $o);
        $manager->persist($o);

        $o = (new Offer())
            ->setLabel("PME")
            ->setDiscount(80)
            ->setUnitProvided(21)
            ->setDescription("La formule équilibrée pour les PME. 21 unités avec 20% de remise et redondance électrique accru.");
        $this->addReference('pme', $o);
        $manager->persist($o);

        $o = (new Offer())
            ->setLabel("Entreprise")
            ->setDiscount(70)
            ->setUnitProvided(42)
            ->setDescription("Notre offre phare pour les grandes structures. 42 unités avec 30% de remise, SLA renforcé et accès prioritaire au support technique.");
        $this->addReference('entreprise', $o);
        $manager->persist($o);

        $manager->flush();
    }
}
