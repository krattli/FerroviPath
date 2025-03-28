<?php

namespace App\Controller;

use App\Repository\LineRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HomePageController extends AbstractController
{
    #[Route('/', name: 'ferrovipath_homepage', methods: ['GET'])]
    public function index(LineRepository $lineRepository): Response
    {
        $lines = $lineRepository->findAll();


        return $this->render('homepage.html.twig', [
            'controller_name' => 'HomePageController',
            'lines' => $lines
        ]);
    }
}
