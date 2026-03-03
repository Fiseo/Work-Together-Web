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

    protected function kick($redirect = 'app_dashboard', bool $sendMessage = true, string $type = 'error', string $message = 'Page not found !'): void
    {
        if ($sendMessage)
            $this->addFlash($type, $message);
        $this->redirectToRoute($redirect);
    }

    protected function needConnection($redirect = 'app_dashboard', bool $sendMessage = true, string $type = 'error', string $message = 'Page not found !'): void{
        if (!$this->isConnected()) {
            $this->kick($redirect, $sendMessage, $type, $message);
        }
    }
}
