<?php

namespace App\MessageHandler;

use App\Message\RenewMessage;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class RenewMessageHandler
{
    public function __construct(
        private BookingRepository $repo,
        private EntityManagerInterface $em,
    ){}
    public function __invoke(RenewMessage $message): void
    {
        $bookings = $this->repo->findActive();
        foreach ($bookings as $b) {
            if (
                ($b->getEnd()->format('Y-m-d') == (new \DateTime())->format('Y-m-d'))
                && $b->isRenewable()) {
                if ($b->isMonthly())
                    $newEnd = new \DateTime($b->getEnd()->modify('+1 month')->format('Y-m-d'));
                else
                    $newEnd = new \DateTime($b->getEnd()->modify('+1 year')->format('Y-m-d'));
                $b->setEnd($newEnd);
                foreach ($b->getBookingUnits() as $unit) {
                    $unit->setEnd($newEnd);
                    $this->em->persist($unit);
                }
                $this->em->persist($b);
                echo 'Modification effectuée'.PHP_EOL;
            }
        }
        $this->em->flush();
        echo 'Passage'.PHP_EOL;
    }
}
