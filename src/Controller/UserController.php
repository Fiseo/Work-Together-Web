<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Company;
use App\Entity\Individual;
use App\Enum\BookingStatus;
use App\Form\CompanyType;
use App\Form\IndividualType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/user')]
final class UserController extends ModelController
{
    #[Route('/', name: 'app_user')]
    public function index(): Response
    {
        if (!$this->isConnected())
            return $this->kick();

        /** @var Client $user */
        $user = $this->getUser();

        if ($user instanceof Individual) {
            /** @var Individual $user */
            return $this->render('user/individualIndex.html.twig', [
                'individual' => $user,
                'nbrActiveBooking' => $user->getBookingsFilter(BookingStatus::Active)->count(),
                'nbrFinishedBooking' => $user->getBookingsFilter(BookingStatus::Finished)->count(),
                'nbrActiveUnit' => $user->getUnits()->count(),
            ]);
        }
        else {
            /** @var Company $user */
            return $this->render('user/companyIndex.html.twig', [
                'company' => $user,
                'nbrActiveBooking' => $user->getBookingsFilter(BookingStatus::Active)->count(),
                'nbrFinishedBooking' => $user->getBookingsFilter(BookingStatus::Finished)->count(),
                'nbrActiveUnit' => $user->getUnits()->count(),
            ]);
        }
    }

    #[Route('/edit', name: 'app_user_edit')]
    public function edit(
        Request                $request,
        EntityManagerInterface $em,
    ): Response
    {
        if (!$this->isConnected())
            return $this->kick();

        /** @var Client $user */
        $user = $this->getUser();

        if ($user instanceof Individual)
            $form = $this->createForm(IndividualType::class, $user);
        else
            $form = $this->createForm(CompanyType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($user);
            $em->flush();

            $this->addFlash(
                'success',
                'Les modifications ont bien été pris en compte'
            );

            return $this->redirectToRoute('app_user');
        }

        if ($user instanceof Individual)
            return $this->render('user/individualEdit.html.twig', [
                'individual' => $user,
                'form' => $form
            ]);
        else
            return $this->render('user/companyEdit.html.twig', [
                'company' => $user,
                'form' => $form
            ]);
    }

    #[Route('/booking', name: 'app_user_booking')]
    public function booking(): Response
    {
        if (!$this->isConnected())
            return $this->kick();

        /** @var Client $user */
        $user = $this->getUser();

        return $this->render('user/booking.html.twig', [ //TODO : Twig
            'bookings' => $user->getBookings()
        ]);
    }

    #[Route('/unit', name: 'app_user_unit')]
    public function unit():Response
    {
        if (!$this->isConnected())
            return $this->kick();

        /** @var Client $user */
        $user = $this->getUser();

        return $this->render('user/unit.html.twig', [ //TODO : Twig
            'unit' => $user->getUnits(),
        ]);
    }
}
