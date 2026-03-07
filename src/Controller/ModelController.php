<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

abstract class ModelController extends AbstractController
{
    protected function isConnected(): bool
    {
        if ($this->getUser() !== null)
            return true;
        return false;
    }

    protected function kick($redirect = 'app_dashboard', bool $sendMessage = true, string $type = 'error', string $message = 'Page not found !'): Response
    {
        if ($sendMessage)
            $this->addFlash($type, $message);
        return $this->redirectToRoute($redirect);
    }
}
