<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AnswerController extends AbstractController
{
    #[Route('/answer', name: 'ferrovipath_answer', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('answer/index.html.twig', [
            'controller_name' => 'AnswerController',
        ]);
    }
}
