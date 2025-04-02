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

            $game = new Game();
            $game->setTime($data['time']);
            $game->setScorePoints($data['scorePoints']);
            $game->setCompletedStations($data['completedStations']);
            $game->setGameMode($data['gameMode']);

            $line = $entityManager->getReference('App\Entity\Line', $data['idLine']);
            $game->setLine($line);

            // Gestion d'enregistrement de l'utilisateur
            // Si l'id est -1, la partie est enregistrée en anonyme (user=null)
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
}