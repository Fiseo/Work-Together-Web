<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Individual;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/user')]
final class UserController extends AbstractController
{
    #[Route('/', name: 'app_user')]
    public function index(): Response
    {
        /** @var Client $user */
        $user = $this->getUser();

        if ($user === null) {
            $this->addFlash(
                'error',
                'Page not found !'
            );
            return $this->redirectToRoute('app_dashboard');
        }

        if ($user instanceof Individual)
            return $this->render('user/individualIndex.html.twig', [ //TODO : Twig
                'individual' => $user,
            ]);
        else
            return $this->render('user/companyIndex.html.twig', [ //TODO : Twig
                'company' => $user,
            ]);
    }

    #[Route('/edit', name: 'app_user_edit')]
    public function edit(): Response
    {
        /** @var Client $user */
        $user = $this->getUser();

        if ($user === null) {
            $this->addFlash(
                'error',
                'Page not found !'
            );
            return $this->redirectToRoute('app_dashboard');
        }

        if ($user instanceof Individual)
            return $this->render('user/individualEdit.html.twig', [ //TODO : Twig
                'individual' => $user,
            ]);
        else
            return $this->render('user/companyEdit.html.twig', [ //TODO : Twig
                'company' => $user,
            ]);
    }

    #[Route('/booking', name: 'app_user_booking')]
    public function booking(): Response
    {
        /** @var Client $user */
        $user = $this->getUser();

        if ($user === null) {
            $this->addFlash(
                'error',
                'Page not found !'
            );
            return $this->redirectToRoute('app_dashboard');
        }

        return $this->render('user/booking.html.twig', [ //TODO : Twig
            'booking' => $user->getBookings(),
        ]);
    }

    #[Route('/unit', name: 'app_user_unit')]
    public function unit():Response
    {
        /** @var Client $user */
        $user = $this->getUser();

        if ($user === null) {
            $this->addFlash(
                'error',
                'Page not found !'
            );
            return $this->redirectToRoute('app_dashboard');
        }

        return $this->render('user/unit.html.twig', [ //TODO : Twig
            'unit' => $user->getUnits(),
        ]);
    }
}
