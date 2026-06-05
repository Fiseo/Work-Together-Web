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
    private function createServiceCall(ServiceCallType $sct, \DateTime $date, ObjectManager $manager) {
        $sc = (new ServiceCall())
            ->setType($sct)
            ->setDate($date)
            ->setTechnician($this->getReference('technician', Technician::class))
            ->setUnit($this->unitService->getAvailableUnitsAt(1, $date)[0]);
        $manager->persist($sc);
    }
    public function __construct(private UnitService $unitService){}

    public function load(ObjectManager $manager): void
    {
        $sct = (new ServiceCallType())
            ->setLabel('Reallocation');
        $manager->persist($sct);

        $sct = (new ServiceCallType())
            ->setLabel('Rewiring');
        $manager->persist($sct);

        $scts = [];
        $scts[] = $sct;

        $sct = (new ServiceCallType())
            ->setLabel('Piece Change');
        $manager->persist($sct);

        $scts[] = $sct;


        $start = new \DateTime('2015-01-01');
        $today = new \DateTime();

        $current = clone $start;

        while ($current < $today) {

            $sct = $scts[array_rand($scts)];

            $this->createServiceCall($sct, $current, $manager);

            // Avance dans le temps (densité du dataset)
            $current->modify('+' . mt_rand(5, 140) . ' days');
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [UserFixtures::class, BayFixtures::class];

    }
}
