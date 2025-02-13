<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class StationController extends AbstractController
{
    #[Route('/station', name: 'ferrovipath_station')]
    public function index(): Response
    {
        return $this->render('homepage.html.twig', [
            'controller_name' => 'StationController',
        ]);
    }
}
