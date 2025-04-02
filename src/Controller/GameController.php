<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Line;
use App\Entity\User;
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
            $data = json_decode($request->getContent(), true);

            // Si un idGame existe, on update une partie déjà existante donc pas d'enregistrement de nouvelle partie
            if (!empty($data['idGame'])) {
                $game = $entityManager->getRepository(Game::class)->find($data['idGame']);
                if (!$game) {
                    return new Response('Game not found', Response::HTTP_NOT_FOUND);
                }
            } else {
                $game = new Game();
            }

            $game->setUpdatedAt(new \DateTime());

            $game->setTime($data['time']);
            $game->setScorePoints($data['scorePoints']);
            $game->setCompletedStations($data['completedStations']);
            $game->setGameMode($data['gameMode']);

            $line = $entityManager->getReference(Line::class, $data['idLine']);
            $game->setLine($line);

            if (isset($data['idUser']) && $data['idUser'] != -1) {
                $user = $entityManager->getRepository(User::class)->find($data['idUser']);
                $game->setUser($user);
            }

            $entityManager->persist($game);
            $entityManager->flush();

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