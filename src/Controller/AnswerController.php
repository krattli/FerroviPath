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
            'metro1' => '/img/m1.webp',
            'metro2' => '/img/m2.webp',
            'metro3' => '/img/m3.webp',
            'metro3bis' => '/img/m3bis.webp',
            'metro4' => '/img/m4.webp',
            'metro5' => '/img/m5.webp',
            'metro6' => '/img/m6.webp',
            'metro7' => '/img/m7.webp',
            'metro7bis' => '/img/m7bis.webp',
            'metro8' => '/img/m8.webp',
            'metro9' => '/img/m9.webp',
            'metro10' => '/img/m10.webp',
            'metro11' => '/img/m11.webp',
            'metro12' => '/img/m12.webp',
            'metro13' => '/img/m13.webp',
            'metro14' => '/img/m14.webp',
            'metro11' => '/img/m11.png',

        ];

        // Image par défaut
        $imagePath = $images[$selectedLine] ?? '/img/carteMetro.png'; 

        // Retourne la page avec l'image sélectionnée
        return $this->render('answer/lines.html.twig', [
            'imagePath' => $imagePath,
        ]);
    }
}
