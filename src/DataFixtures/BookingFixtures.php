<?php

namespace App\DataFixtures;

use App\Entity\Booking;
use App\Entity\BookingUnit;
use App\Entity\Client;
use App\Entity\Company;
use App\Entity\Individual;
use App\Entity\Offer;
use App\Service\ReceiptService;
use App\Service\UnitService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BookingFixtures extends Fixture implements DependentFixtureInterface
{
    private function createBooking(Client $client, \DateTime $startDate, \DateTime $endDate, Offer $offer, ObjectManager $manager)
    {
        $b = (new Booking())
            ->setIsPayed(true)
            ->setStart($startDate)
            ->setEnd($endDate)
            ->setClient($client)
            ->setLabel(bin2hex(random_bytes(8)))
            ->setOffer($offer);

        $interval = $startDate->diff($endDate);

        if ($interval->y > 0 && $interval->m === 0)
            $b->setIsMonthly(false);
        else
            $b->setIsMonthly(true);

        if (new \DateTime() < $endDate && mt_rand(1, 5) === 1)
            $b->setIsRenewable(false);
        elseif (new \DateTime() > $endDate)
            $b->setIsRenewable(false);
        else
            $b->setIsRenewable(true);

        $manager->persist($b);

        $this->receiptService->createReceiptsForBooking($b);

        $u = $this->unitService->getAvailableUnitsAt($b->getOffer()->getUnitProvided(), $b->getStart());

        $buTemplate = (new BookingUnit())
            ->setStart($b->getStart())
            ->setEnd($b->getEnd())
            ->setBooking($b);

        foreach ($u as $unit) {
            $bu = clone $buTemplate;
            $bu->setUnit($unit);
            $manager->persist($bu);
        }
        $manager->flush();
        $manager->clear();
    }
    public function __construct(private UnitService $unitService, private ReceiptService $receiptService){}
    public function load(ObjectManager $manager): void
    {
        $vigile = $this->getReference('v', Individual::class);
        $jane = $this->getReference('j', Individual::class);
        $lactalis = $this->getReference('l', Company::class);

        $base = $this->getReference('base', Offer::class);
        $stup = $this->getReference('startup', Offer::class);
        $pme = $this->getReference('pme', Offer::class);
        $entr = $this->getReference('entreprise', Offer::class);

        $clients = [$vigile, $jane, $lactalis];
        $offers = [
            50 => $base,
            25 => $stup,
            15 => $pme,
            10 => $entr,
        ];

        $start = new \DateTime('2015-01-01');
        $today = new \DateTime();

        $current = clone $start;

        while ($current < $today) {

            $client = $clients[array_rand($clients)];
            $offer = null;

            $offer = null;
            $totalWeight = array_sum(array_keys($offers));
            $rand = mt_rand(1, $totalWeight);
            $cumulative = 0;

            foreach ($offers as $weight => $item) {
                $cumulative += $weight;
                if ($rand <= $cumulative) {
                    $offer = $item;
                    break; // ← manquait aussi dans ton code original
                }
            }

            $startDate = clone $current;

            // Choix mois ou année
            $isYearly = mt_rand(0, 1) === 1;

            if ($isYearly) {
                $duration = mt_rand(1, 5); // 1 à 5 ans
                $endDate = (clone $startDate)->modify("+$duration years");
            } else {
                $duration = mt_rand(1, 12*5); // 1 à 5 ans en mois
                $endDate = (clone $startDate)->modify("+$duration months");
            }

            // Si dépasse aujourd'hui → ajustement
            if ($endDate > $today) {

                if ($isYearly) {
                    // prochaine date annuelle valide
                    $endDate = (clone $startDate);
                    while ($endDate <= $today) {
                        $endDate->modify('+1 year');
                    }
                } else {
                    // prochaine date mensuelle valide
                    $endDate = (clone $startDate);
                    while ($endDate <= $today) {
                        $endDate->modify('+1 month');
                    }
                }
            }

            $this->createBooking($client, $startDate, $endDate, $offer, $manager);

            // Après createBooking()
            foreach ($clients as $key => $c) {
                $clients[$key] = $manager->find(Client::class, $c->getId());
            }
            foreach ($offers as $weight => $o) {
                $offers[$weight] = $manager->find(Offer::class, $o->getId());
            }

            // Avance dans le temps (densité du dataset)
            $current->modify('+' . mt_rand(5, 140) . ' days');
        }
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            OfferFixtures::class,
            BayFixtures::class,
            ServiceCallFixtures::class
        ];

    }
}
