<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class NetworkController extends AbstractController
{
    #[Route('/station', name: 'ferrovipath_station')]
    public function index(): Response
    {
        return $this->render('network/index.html.twig', [
            'controller_name' => 'ReseauController',
        ]);
    }
}
