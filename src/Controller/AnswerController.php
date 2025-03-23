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
            'metro1' => '/img/Ligne1Answer.png',
            'metro2' => '/img/Ligne2Answer.png',
            'metro3' => '/img/Ligne3Answer.png',
            'metro3bis' => '/img/Ligne3bisAnswer.png',
            'metro4' => '/img/Ligne4Answer.png',
            'metro5' => '/img/Ligne5Answer.png',
            'metro6' => '/img/Ligne6Answer.png',
            'metro7' => '/img/Ligne7Answer.png',
            'metro7bis' => '/img/Ligne7bisAnswer.png',
            'metro8' => '/img/Ligne8Answer.png',
            'metro9' => '/img/Ligne9Answer.png',
            'metro10' => '/img/Ligne10Answer.png',
            'metro11' => '/img/Ligne11Answer.png',
            'metro12' => '/img/Ligne12Answer.png',
            'metro13' => '/img/Ligne13Answer.png',
            'metro14' => '/img/Ligne14Answer.png',
            'metro15' => '/img/Ligne15Answer.png',
            'metro16' => '/img/Ligne16answer.png',
            'metro17' => '/img/Ligne17answer.png',
            'metro18' => '/img/Ligne18Answer.png',
            'metro19' => '/img/Ligne19Answer.png',
        ];

        // Image par défaut
        $imagePath = $images[$selectedLine] ?? '/img/carteMetro.png'; 

        // Retourne la page avec l'image sélectionnée
        return $this->render('answer/lines.html.twig', [
            'imagePath' => $imagePath,
        ]);
    }
}
