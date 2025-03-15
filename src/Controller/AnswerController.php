<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class AnswerController extends AbstractController
{
    #[Route('/answer', name: 'ferrovipath_answer', methods: ['GET'])]
    public function index(Request $request): Response
    {
        // Récupère la ligne choisie ou une valeur par défaut
        $selectedLine = $request->query->get('line', 'default'); 

        // Associe chaque ligne à une image
        $images = [
            'metro1' => '/img/m1.png',
            'metro2' => '/img/metro2.png',
            'metro3' => '/img/metro3.png',
        ];

        // Image par défaut
        $imagePath = $images[$selectedLine] ?? '/img/Logo.png'; 

        // Retourne la page avec l'image sélectionnée
        return $this->render('answer/lines.html.twig', [
            'imagePath' => $imagePath,
        ]);
    }
}
