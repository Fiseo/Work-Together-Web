<?php

namespace App\MessageHandler;

use App\Enum\BookingStatus;
use App\Message\DeleteUnpayed;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class DeleteUnpayedHandler
{
    public function __construct(
        private BookingRepository $repo,
        private EntityManagerInterface $em,
    ){}
    public function __invoke(DeleteUnpayed $message): void
    {
        $bookings = $this->repo->findByStatus(BookingStatus::NeedPayement);
        $maxDate = (new \DateTime())->modify('-8 day')->format('Y-m-d');
        foreach ($bookings as $b) {
            if ($b->getStart()->format('Y-m-d') === $maxDate) {
                foreach ($b->getActiveBookingUnits() as $unit) {
                    $this->em->remove($unit);
                }
                $this->em->remove($b);
            }
        }
        $this->em->flush();
    }
}
