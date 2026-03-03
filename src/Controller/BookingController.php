<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\BookingUnit;
use App\Entity\Client;
use App\Form\BookingType;
use App\Repository\OfferRepository;
use App\Service\UnitService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/booking')]
final class BookingController extends ModelController
{
    #[Route('/new', name: 'app_booking_new')]
    public function new(
        OfferRepository        $or,
        UnitService            $us,
        Request                $request,
        EntityManagerInterface $em,
    ): Response
    {
        $this->needConnection(redirect: 'app_login', type: 'info', message: 'Veuillez vous connecter avant d\'effectuer une commande.');

        $offerList = $or->findOfferGreaterThan($us->getNumberUnit());
        if ($offerList->isEmpty()) {
            $this->addFlash(
                'info',
                'Nous sommes désolé mais aucune offre n\'est disponible à l\'heure actuelle.'
            );
            return $this->redirectToRoute('app_dashboard');
        }

        $booking = (new Booking())
                        ->setIsPayed(false)
                        ->setStart(new \DateTime())
                        ->setClient($this->getUser())
                        ->setIsRenewable(true)
                        ->setLabel(bin2hex(random_bytes(8)));

        $form = $this->createForm(BookingType::class, $booking, ['offerAvailable' => $offerList]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            if ($booking->isMonthly())
                $end = (new \DateTime($booking->getStart()->format('Y-m-d')))->modify('+1 month');
            else
                $end = (new \DateTime($booking->getStart()->format('Y-m-d')))->modify('+1 year');
            $booking->setEnd($end);
            $em->persist($booking);

            $units = $us->getAvailableUnits($booking->getOffer()->getUnitProvided());
            $buTemplate = (new BookingUnit())
                ->setStart($booking->getStart())
                ->setEnd($booking->getEnd())
                ->setBooking($booking);

            foreach ($units as $unit) {
                $bu = clone $buTemplate;
                $bu->setUnit($unit);
                $em->persist($bu);
            }

            $em->flush();

            $this->addFlash(
                'success',
                'Votre réservation est bien enregistrée.
                 Vous avez maintenant 5 jours pour effectuer le paiement.'
            );

            return $this->redirectToRoute('app_user_booking');
        }

        $errors = $form->getErrors(true);
        foreach ($errors as $error) {
            $this->addFlash('error', $error->getMessage());
        }

        return $this->render('booking/new.html.twig', [ //TODO : Twig
            'form' => $form,
        ]);
    }

    #[Route('/{booking}/pay', name: 'app_booking_pay')]
    public function edit():Response {

        //TODO : Paiement d'un booking
        return $this->render('base.html.twig', []);//TODO : Twig
    }

    #[Route('/{booking}/renewable', name: 'app_booking_renewable')]
    public function reverseRenewable(Booking $booking, EntityManagerInterface $em): void
    {
        $this->needConnection(sendMessage: false);

        /** @var Client $user */
        $user = $this->getUser();

        if ($user->getId() !== $booking->getClient()->getId())
            $this->kick(sendMessage: false);

        $booking->setIsRenewable(!$booking->isRenewable());
        $em->persist($booking);
        $em->flush();
        $this->redirectToRoute('app_booking_details', ['booking' => $booking->getId()]);
    }

    #[Route('/{booking}/', name: 'app_booking_details')]
    public function details(
        Booking $booking,
    ):Response {
        $this->needConnection();

        /** @var Client $user */
        $user = $this->getUser();

        if ($user->getId() !== $booking->getClient()->getId())
            $this->kick();

        return $this->render('booking/detail.html.twig', [ //TODO : Twig
            'booking' => $booking,
        ]);
    }
}
