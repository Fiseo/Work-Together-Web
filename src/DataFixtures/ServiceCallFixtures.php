<?php

namespace App\DataFixtures;

use App\Entity\ServiceCall;
use App\Entity\ServiceCallType;
use App\Entity\Technician;
use App\Service\UnitService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ServiceCallFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private UnitService $unitService){}

    public function load(ObjectManager $manager): void
    {
        $sct = (new ServiceCallType())
            ->setLabel('Exemple 1');
        $manager->persist($sct);

        $sct = (new ServiceCallType())
            ->setLabel('Exemple 2');
        $manager->persist($sct);

        $sc = (new ServiceCall())
            ->setType($sct)
            ->setDate(new \DateTime())
            ->setTechnician($this->getReference('technician', Technician::class))
            ->setUnit($this->unitService->getAvailableUnits(1)[0]);
        $manager->persist($sc);



        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [UserFixtures::class, BayFixtures::class];

    }
}
