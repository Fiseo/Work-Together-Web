<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/user')]
final class UserController extends AbstractController
{
    #[Route('/', name: 'app_user')]
    public function index(): Response
    {
        //TODO : Page de consultation de ses informations
        return $this->render('base.html.twig', []);//TODO : Twig
    }

    #[Route('/edit', name: 'app_user_edit')]
    public function edit(): Response
    {
        //TODO : Page de modification de ses informations
        return $this->render('base.html.twig', []);//TODO : Twig
    }

    #[Route('/booking', name: 'app_user_booking')]
    public function booking(): Response
    {
        //TODO : Page de consultation de sa liste de bookings
        return $this->render('base.html.twig', []);//TODO : Twig
    }

    #[Route('/unit', name: 'app_user_unit')]
    public function unit():Response
    {
        //TODO : Page de consultation de sa liste de bookings
        return $this->render('base.html.twig', []);//TODO : Twig
    }
}
