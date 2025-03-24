<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Line;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
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
    public function saveGame(Request $request, EntityManagerInterface $entityManager, Security $security): Response
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

            $user = $security->getUser();
            if ($user instanceof User) {
                $game->setUser($user);
            } else {
                $game->setUser(null);
            }


            $entityManager->persist($game);
            $entityManager->flush();

            return new Response('Game saved successfully', Response::HTTP_OK);
        } catch (\Exception $e) {
            // Log the exception message for debugging
            error_log($e->getMessage());
            return new Response('Internal Server Error', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
