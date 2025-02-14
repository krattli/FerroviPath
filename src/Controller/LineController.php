<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class LineController extends AbstractController
{
    #[Route('/line', name: 'app_line')]
    public function index(): Response
    {
        return $this->render('line/index.html.twig', [
            'controller_name' => 'LineController',
        ]);
    }
}
