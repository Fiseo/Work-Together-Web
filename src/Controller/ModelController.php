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

    protected function needConnection(string $type = 'error', string $message = 'Page not found !', $redirect = 'app_dashboard'): void{
        if (!$this->isConnected()) {
            $this->addFlash($type, $message);
            $this->redirectToRoute($redirect);
        }
    }
}
