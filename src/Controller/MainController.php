<?php

namespace App\Controller;

use App\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MainController extends AbstractController
{
    #[Route('/', name: 'app_dashboard')]
    public function dashboard(): Response
    {
        if ($this->getUser() && !($this->getUser() instanceof Client))
            return $this->redirectToRoute('app_logout');

        return $this->render('main/index.html.twig', []);
    }
}
