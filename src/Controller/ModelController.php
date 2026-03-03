<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class ModelController extends AbstractController
{
    protected function isConnected(): bool
    {
        if ($this->getUser())
            return true;
        return false;
    }

    protected function needConnection(): void{
        if (!$this->isConnected())
            $this->redirectToRoute('app_login');
    }
}
