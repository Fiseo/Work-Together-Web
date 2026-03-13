<?php

namespace App\DataFixtures;

use App\Entity\Booking;
use App\Entity\BookingUnit;
use App\Entity\Individual;
use App\Entity\Offer;
use App\Service\UnitService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BookingFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private UnitService $unitService){}
    public function load(ObjectManager $manager): void
    {
        $booking = (new Booking())
            ->setIsPayed(true)
            ->setStart(new \DateTime('2024-05-18'))
            ->setEnd(new \DateTime('2024-08-18'))
            ->setClient($this->getReference('jane', Individual::class))
            ->setIsRenewable(true)
            ->setLabel(bin2hex(random_bytes(8)))
            ->setIsMonthly(true)
            ->setOffer($this->getReference('base', Offer::class));
        $manager->persist($booking);

        $units = $this->unitService->getAvailableUnits($booking->getOffer()->getUnitProvided());
        $buTemplate = (new BookingUnit())
            ->setStart($booking->getStart())
            ->setEnd($booking->getEnd())
            ->setBooking($booking);

        foreach ($units as $unit) {
            $bu = clone $buTemplate;
            $bu->setUnit($unit);
            $manager->persist($bu);
        }

        $booking = (new Booking())
            ->setIsPayed(true)
            ->setStart(new \DateTime('2025-05-18'))
            ->setEnd(new \DateTime('2026-05-18'))
            ->setClient($this->getReference('jane', Individual::class))
            ->setIsRenewable(true)
            ->setLabel(bin2hex(random_bytes(8)))
            ->setIsMonthly(false)
            ->setOffer($this->getReference('base', Offer::class));
        $manager->persist($booking);

        $units = $this->unitService->getAvailableUnits($booking->getOffer()->getUnitProvided());
        $buTemplate = (new BookingUnit())
            ->setStart($booking->getStart())
            ->setEnd($booking->getEnd())
            ->setBooking($booking);

        foreach ($units as $unit) {
            $bu = clone $buTemplate;
            $bu->setUnit($unit);
            $manager->persist($bu);
        }

        $booking = (new Booking())
            ->setIsPayed(true)
            ->setStart(new \DateTime('2017-05-18'))
            ->setEnd(new \DateTime('2021-05-18'))
            ->setClient($this->getReference('jane', Individual::class))
            ->setIsRenewable(true)
            ->setLabel(bin2hex(random_bytes(8)))
            ->setIsMonthly(true)
            ->setOffer($this->getReference('startup', Offer::class));
        $manager->persist($booking);

        $units = $this->unitService->getAvailableUnits($booking->getOffer()->getUnitProvided());
        $buTemplate = (new BookingUnit())
            ->setStart($booking->getStart())
            ->setEnd($booking->getEnd())
            ->setBooking($booking);

        foreach ($units as $unit) {
            $bu = clone $buTemplate;
            $bu->setUnit($unit);
            $manager->persist($bu);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [UserFixtures::class, OfferFixtures::class];

    }
}
