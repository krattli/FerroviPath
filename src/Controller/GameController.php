<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Line;
use App\Service\GameServices;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class GameController extends AbstractController
{
    #[Route('/game/{id}', name: 'ferrovipath_game', methods: ['GET'])]
    public function index(Line $line): Response
    {
        return $this->render('game/index.html.twig', [
            'controller_name' => 'GameController',
            'line' => $line
        ]);
    }

    #[Route('/save-game', name: 'save_game', methods: ['POST'])]
    public function saveGame(Request $request, EntityManagerInterface $entityManager): Response
    {
        try {
            GameServices::saveGame($request, $entityManager);
            return new Response('Game saved successfully', Response::HTTP_OK);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return new Response('Internal Server Error', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    #[Route('/resume-game/{id}', name: 'ferrovipath_resume_game')]
    public function resumeGame(Game $game): Response
    {
        return $this->render('game/index.html.twig', [
            'line' => $game->getLine(),
            'game' => $game,
        ]);
    }

}