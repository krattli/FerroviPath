<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HomePageController extends AbstractController
{
    #[Route('/', name: 'ferrovipath_homepage', methods: ['GET'])]
    public function index(): Response
    {

        //Plus besoin d'injecter la variable $lines dans la homepage, GlobalServices le fais très bien

        return $this->render('homepage.html.twig', [
            'controller_name' => 'HomePageController'
        ]);
    }
}
