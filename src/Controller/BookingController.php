<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/booking')]
final class BookingController extends ModelController
{
    #[Route('/new', name: 'app_booking_new')]
    public function new(): Response
    {
        //TODO : création d'un booking
        return $this->render('base.html.twig', []);//TODO : Twig
    }

    #[Route('/{booking}/pay', name: 'app_booking_pay')]
    public function edit():Response {

        //TODO : Paiement d'un booking
        return $this->render('base.html.twig', []);//TODO : Twig
    }

    #[Route('/{booking}/', name: 'app_booking_details')]
    public function details():Response {

        //TODO : Consulter les informations d'un booking
        return $this->render('base.html.twig', []);//TODO : Twig
    }
}
