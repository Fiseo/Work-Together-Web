<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Client;
use App\Entity\User;
use App\Enum\BookingStatus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class ApiController extends ModelController
{
    #[Route('/api', name: 'app_api', methods: ['GET'])]
    public function index(
        SerializerInterface $serializer,
    ): JsonResponse
    {
        if (!$this->isConnected())
            return new JsonResponse(['error' => "Aucun compte n'est connecté"]);

        /** @var Client $user */
        $user = $this->getUser();
        $bookings = $user->getBookings();

        $results = [];
        foreach ($bookings as $booking) {
            if ($booking->getStatus() != BookingStatus::Active)
                continue;
            $results[$booking->getLabel()] = [];
            foreach ($booking->getBookingUnits() as $bookingUnit) {
                $unit = $bookingUnit->getUnit();
                $results[$booking->getLabel()][$unit->getFullLabel()] = [$unit->getStatus()];
            }
        }

        $results = $serializer->normalize($results);
        return new JsonResponse($results, 200);
    }
}
