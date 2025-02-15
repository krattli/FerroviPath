<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomePageController extends AbstractController
{
    #[Route('/', name: 'ferrovipath_homepage', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('homepage.html.twig', [
            'controller_name' => 'HomePageController',
        ]);
    }
}
