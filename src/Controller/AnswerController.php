<?php

namespace App\Controller;

use App\Service\LineServices;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class AnswerController extends AbstractController
{

    public function __construct(private LineServices $lineServices)
    {
        
    }

    #[Route('/answer', name: 'ferrovipath_answer', methods: ['GET'])]
    public function index(Request $request): Response
    {
        // Récupère la ligne choisie ou une valeur par défaut
        $selectedLine = $request->query->get('line', 'default'); 
        //Récupère le chemin de la ligne choisie
        $imagePath = $this->lineServices->getImageForALine($selectedLine);
        // Retourne la page avec l'image sélectionnée
        return $this->render('answer/lines.html.twig', [
            'imagePath' => $imagePath,
        ]);
    }
}
