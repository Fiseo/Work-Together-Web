<?php

namespace App\Controller;

use App\Controller\DataModel\MainData;
use App\Entity\Client;
use App\Repository\OfferRepository;
use App\Repository\UnitRepository;
use App\Service\UnitService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MainController extends ModelController
{
    #[Route('/', name: 'app_dashboard')]
    public function dashboard(
        OfferRepository $oRepo,
        UnitRepository $uRepo,
        UnitService $uService,
    ): Response
    {
        if ($this->getUser() && !($this->getUser() instanceof Client))
            return $this->redirectToRoute('app_logout');

        $nbrUnits = count($uRepo->findAll());
        $data = (new MainData())
            ->setTotalUnit($nbrUnits)
            ->setAvailablePercentage($uService->getNumberUnit() / $nbrUnits * 100);
        return $this->render('main/index.html.twig', [
            'data' => $data,
            'offers' => $oRepo->findAll()
        ]);
    }

    #[Route('/yet', name: 'app_yet_to_implement')]
    public function yetToImplement(): Response
    {
        return $this->kick(
            type: 'info',
            message: 'This feature have yet to be implemented.'
        );
    }
}
